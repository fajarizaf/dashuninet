<?php

namespace App\Http\Controllers;

use App\Models\RequestDeposit;
use App\Models\UserInvoices;
use App\Models\Customer;
use App\Models\SiteStatus;
use App\Models\InvoicesProofPayment;
use App\Models\UserInvoicestransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class RequestDepositController extends Controller
{
    /**
     * Menampilkan daftar request deposit
     */
    public function index(Request $request)
    {
        $deposits = RequestDeposit::with(['customer', 'invoice', 'status'])
            ->latest();

        // Filter berdasarkan tanggal request
        if ($request->request_date_from) {
            $deposits->whereDate('request_date', '>=', $request->request_date_from);
        }

        if ($request->request_date_to) {
            $deposits->whereDate('request_date', '<=', $request->request_date_to);
        }

        // Filter berdasarkan customer
        if ($request->customer_name) {
            $deposits->whereHas('customer', function($query) use ($request) {
                $query->where('customer_name', 'LIKE', "%{$request->customer_name}%");
            });
        }

        // Filter berdasarkan status
        if ($request->status_id) {
            $deposits->where('status_id', $request->status_id);
        }

        // Filter berdasarkan amount
        if ($request->amount_from) {
            $deposits->where('amount', '>=', $request->amount_from);
        }

        if ($request->amount_to) {
            $deposits->where('amount', '<=', $request->amount_to);
        }

        $data = $deposits->paginate(30)->withQueryString();

        // Data untuk filter dropdown
        $customers = Customer::select('id', 'customer_name')
            ->where('is_active', 1)
            ->orderBy('customer_name')
            ->get();

        $statuses = SiteStatus::select('id', 'status_name')
            ->whereIn('id', [1034, 1035]) // Status pending dan approved
            ->get();

        return view('page.request_deposit.index', [
            'data' => $data,
            'customers' => $customers,
            'statuses' => $statuses,
            'request' => $request
        ]);
    }

    /**
     * Menampilkan detail request deposit
     */
    public function show($id)
    {
        $deposit = RequestDeposit::with([
            'customer',
            'invoice.invoicesProofPayment',
            'status'
        ])->findOrFail($id);

        return view('page.request_deposit.detail', [
            'deposit' => $deposit
        ]);
    }

    /**
     * Set request deposit status to In Progress (1040)
     */
    public function setInProgress(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $deposit = RequestDeposit::findOrFail($id);

            // Update status deposit menjadi in progress (1040)
            $deposit->update([
                'status_id' => 1040,
                'process_date' => Carbon::now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status request deposit berhasil diubah menjadi In Progress'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve request deposit
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $deposit = RequestDeposit::findOrFail($id);

            // Update status deposit menjadi approved (1035)
            $deposit->update([
                'status_id' => 1035,
                'process_date' => Carbon::now()
            ]);

            // Update status invoice menjadi paid (1036)
            if ($deposit->invoice_id) {
                $invoice = UserInvoices::find($deposit->invoice_id);
                $invoice->update([
                    'status_id' => 1036,
                    'invoice_datepaid' => Carbon::now()
                ]);

                $PREFIX = "TRX-";
                $TRANSACTION_NUMBER = IdGenerator::generate(['table' => 'user_invoices_transaction', 'field' => 'trx_number', 'length' => 9, 'prefix' => $PREFIX]);

                // Catat transaksi deposit ke tabel user_invoices_transaction
                UserInvoicestransaction::create([
                    'reseller_id' => $invoice->reseller_id ?? null,
                    'trx_number' => $TRANSACTION_NUMBER,
                    'invoice_id' => $deposit->invoice_id,
                    'trx_date' => Carbon::now(),
                    'currency' => 'IDR',
                    'gateway' => $invoice->payment_method ?? 'DEPOSIT',
                    'is_deposit' => 1,
                    'fees' => 0,
                    'amount_in' => $deposit->amount,
                    'description' => 'Deposit payment for invoice #' . ($invoice->invoice_number ?? $deposit->invoice_id),
                    'payment_status' => 'Paid',
                    'refundid' => null
                ]);
            }

            DB::commit();

            $CUSTOMERS = Customer::find($invoice->customer_id);

            // Set Notification
            $params_notif = [
                "subject" => "Upload bukti transfer pengajuan deposit telah disetujui",
                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja menyetujui bukti pembayaran terkait pengajuan deposit oleh ' . $CUSTOMERS->customer_name . ' pada invoices #' . $deposit->invoice_id,
                "group_id" => "1"
            ];
                                    
            // notif to sales executive
            $notif_sales_executive = app(AdminController::class)->Create_notification('1', $params_notif);

            // notif to sales leader
            $notif_sales_leader = app(AdminController::class)->Create_notification('6', $params_notif);

            // notif to noc
            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);

            // PUSH notification
            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/notif/create', [
                    "user" => "customer",
                    "template_id" => 25,
                    "id" => INV-$invoice->id,
                    "user_id" => [$CUSTOMERS->id]
                ]);

            // EMAIL notification
            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/email/send', [
                        'action' => 'Pengajuan Deposit Disetujui',
                        'send_to' => $CUSTOMERS->customer_email,
                        'name' => $CUSTOMERS->customer_name,
                        'request_id' => $deposit->id,
                        'amount' => number_format($deposit->amount, 0),
                        'invoices_id' => '#'.$deposit->invoice_id,
                        'payment_method' => $deposit->payment_method,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Request deposit berhasil diapprove'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan bukti pembayaran
     */
    public function viewProof($invoiceId)
    {
        try {
            $proofPayment = InvoicesProofPayment::where('invoice_id', $invoiceId)->first();
            
            if (!$proofPayment || !$proofPayment->file) {
                return response()->json(['error' => 'File tidak ditemukan'], 404);
            }
            
            // Stream download dari backend
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('BACKEND_TOKEN')
            ])->get(env('BACKEND_URL') . '/image/private/get/ums/' . $proofPayment->file);
            
            if ($response->successful()) {
                $contentType = $response->header('Content-Type') ?? 'application/octet-stream';
                
                return response($response->body())
                    ->header('Content-Type', $contentType)
                    ->header('Content-Disposition', 'inline; filename="proof_payment.pdf"');
            }
            
            return response()->json(['error' => 'File tidak dapat diakses'], 404);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }

    /**
     * Upload bukti transfer
     */
    public function uploadProof(Request $request, $invoiceId)
    {
        $request->validate([
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB max
        ]);

        try {
            $invoice = UserInvoices::findOrFail($invoiceId);
            
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $filename = $file->getClientOriginalName();
                $tmpFilePath = $file->getPathname();
                $mimeType = $file->getClientMimeType();
                $curlFile = new \CURLFile($tmpFilePath, $mimeType, $filename);

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('BACKEND_URL') . '/upload/image',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'upload' => $curlFile, 
                        'type' => 'ums', 
                        'privacy' => 'private'
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . env('BACKEND_TOKEN')
                    ),
                ));

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                if ($httpCode === 200) {
                     $responseData = json_decode($response, true);
                     
                     if (isset($responseData['status']) && $responseData['status'] === 'success') {
                         $filePath = $responseData['images'];
                         
                         // Create or update proof payment record
                         $proofPayment = InvoicesProofPayment::updateOrCreate(
                             ['invoice_id' => $invoiceId],
                             [
                                 'file' => $filePath,
                                 'status' => 'pending',
                                 'reject_reason' => null
                             ]
                         );
                         
                         return response()->json([
                             'success' => true,
                             'message' => 'Bukti transfer berhasil diupload',
                             'file_path' => $filePath
                         ]);
                     }
                 }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal upload ke server backend'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Create Topup Deposit request and corresponding invoice
     */
    public function storeTopup(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customer,id',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($validated['customer_id']);

            // Generate invoice number with prefix INV-
            $new_invoicenumber = IdGenerator::generate([
                'table' => 'user_invoices',
                'field' => 'invoice_number',
                'length' => 11,
                'prefix' => 'INV-'
            ]);

            $tax = 0;
            $subtotal = (float) $validated['amount'];
            $total = $subtotal + $tax;

            // Create invoice for deposit topup
            $invoice = UserInvoices::create([
                'reseller_id' => session('reseller_id'),
                'invoice_number' => $new_invoicenumber,
                'invoice_type' => 'deposit',
                'customer_id' => $customer->id,
                'invoice_date' => Carbon::now(),
                'invoice_duedate' => Carbon::now()->addDays(7),
                'payment_method' => 'DEPOSIT',
                'tax' => $tax,
                'subtotal' => $subtotal,
                'total' => $total,
                'is_publish' => 1,
                'status_id' => 1037, // Unpaid/Pending invoice
            ]);

            // Create deposit request linked to the invoice
            $deposit = RequestDeposit::create([
                'customer_id' => $customer->id,
                'invoice_id' => $invoice->id,
                'payment_method' => 'DEPOSIT',
                'amount' => $subtotal,
                'request_date' => Carbon::now(),
                'status_id' => 1034, // Pending
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Topup deposit berhasil dibuat',
                'deposit_id' => $deposit->id,
                'invoice_id' => $invoice->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat topup deposit: ' . $e->getMessage(),
            ], 500);
        }
    }
}