<?php

namespace App\Http\Controllers;

use App\Library\RouterosAPI;
use App\Models\OrderProject;
use App\Models\SiteProject;
use App\Models\SiteRouter;
use DB;
use App\Models\Customer;
use App\Models\CustomerMembership;
use App\Models\InvoicesProofPayment;
use App\Models\LogActivity;
use App\Models\SiteProduct;
use App\Models\SiteProductField;
use App\Models\SiteProductPrice;
use App\Models\UserInvoices;
use App\Models\UserInvoicesitem;
use App\Models\UserInvoicespayment;
use App\Models\UserInvoicestransaction;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\SiteProductGroup;


class InvoicesController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function List_draft(Request $request)
    {

        $invoices = UserInvoices::latest();

        $count_invoices_draft = UserInvoices::query()->where('is_publish', 0)->where('user_invoices.status_id', "!=", (int)1008)->count();

        if ($request->invoices_date) {
            $invoices->where('user_invoices.invoice_date', $request->invoices_date);
        }

        if ($request->invoices_duedate) {
            $invoices->where('user_invoices.invoice_duedate', $request->invoices_duedate);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        $invoices->where('user_invoices.is_publish', (int)0);
        $invoices->where('user_invoices.status_id', '!=', 1008);

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');

        $invoices->select('customer.customer_name', 'user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.is_publish', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name', 'user_invoices.created_at');
        $invoices->omniFilter();

        $cust = Customer::query();
        $cust->select("id", "customer_number", "customer_name", "customer_email");
        $cust->omniFilter();
        $cust = $cust->get();

        return view('page/invoices_draft', [
            'cust' => $cust,
            'count_draft' => $count_invoices_draft,
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }

    public function count_invoices($request, $status)
    {

        $invoices = UserInvoices::latest();

        if ($request->invoices_date_from) {
            $invoices->whereDate('user_invoices.invoice_date', '>=', $request->invoices_date_from);
        }

        if ($request->invoices_date_to) {
            $invoices->whereDate('user_invoices.invoice_date', '<=', $request->invoices_date_to);
        }

        if ($request->invoices_number) {
            $invoices->where('user_invoices.invoice_number', $request->invoices_number);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->invoices_status) {
            $invoices->where('user_invoices.status_id', $request->invoices_status);
        } else {
            $invoices->where('user_invoices.status_id', $status);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        if ($request->year) {
            $invoices->whereYear('trx_date', $request->year);
        }
        if ($request->month) {
            $invoices->whereMonth('trx_date', $request->month);
        }
        if ($request->month || $request->year) {
            $invoices->join('user_invoices_transaction', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id');
        }
        if ($request->filter_area) {
            $invoices->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id');
            $invoices->join('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id');
            $invoices->where('project_id', $request->filter_area);
        }


        $invoices->where('user_invoices.is_publish', (int)1);

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');
        $invoices->omniFilter();

        return $invoices->count();

    }


    public function List_publish(Request $request)
    {

        $invoices = UserInvoices::latest();

        if ($request->invoices_status == '1036') {
            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1037') {
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_paid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1008') {
            $count_invoices_paid = 0;
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = self::count_invoices($request, '1008');
        }

        if (!$request->invoices_status) {

            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_cancel = self::count_invoices($request, '1008');

        }

        if ($request->invoices_date_from) {
            $invoices->whereDate('user_invoices.invoice_date', '>=', $request->invoices_date_from);
        }

        if ($request->invoices_date_to) {
            $invoices->whereDate('user_invoices.invoice_date', '<=', $request->invoices_date_to);
        }

        if ($request->invoices_number) {
            $invoices->where('user_invoices.invoice_number', $request->invoices_number);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->invoices_status) {
            $invoices->where('user_invoices.status_id', $request->invoices_status);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        if ($request->year) {
            $invoices->whereYear('trx_date', $request->year);
        }
        if ($request->month) {
            $invoices->whereMonth('trx_date', $request->month);
        }
        if ($request->month || $request->year) {
            $invoices->join('user_invoices_transaction', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id');
        }
        if ($request->filter_area) {
            $invoices->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id');
            $invoices->join('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id');
            $invoices->where('project_id', $request->filter_area);
        }

        $invoices->where('is_publish', (int)1);

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');

        $invoices->select('customer.customer_name', 'user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.is_publish', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name', 'user_invoices.created_at');
        $invoices->omniFilter();


        return view('page/invoices_publish', [
            'count_paid' => $count_invoices_paid,
            'count_unpaid' => $count_invoices_unpaid,
            'count_cancel' => $count_invoices_cancel,
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }


    public function List_duedate(Request $request)
    {

        $invoices = UserInvoices::query();

        if ($request->invoices_status == '1036') {
            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1037') {
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_paid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1008') {
            $count_invoices_paid = 0;
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = self::count_invoices($request, '1008');
        }

        if (!$request->invoices_status) {

            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_cancel = self::count_invoices($request, '1008');

        }

        if ($request->invoices_date_from) {
            $invoices->whereDate('user_invoices.invoice_date', '>=', $request->invoices_date_from);
        }

        if ($request->invoices_date_to) {
            $invoices->whereDate('user_invoices.invoice_date', '<=', $request->invoices_date_to);
        }

        if ($request->invoices_number) {
            $invoices->where('user_invoices.invoice_number', $request->invoices_number);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        if ($request->year) {
            $invoices->whereYear('trx_date', $request->year);
        }
        if ($request->month) {
            $invoices->whereMonth('trx_date', $request->month);
        }
        if ($request->month || $request->year) {
            $invoices->join('user_invoices_transaction', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id');
        }
        if ($request->filter_area) {
            $invoices->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id');
            $invoices->join('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id');
            $invoices->where('project_id', $request->filter_area);
        }

        $invoices->where('is_publish', (int)1);
        $invoices->where('user_invoices.status_id', '1037');
        $invoices->whereRaw('invoice_duedate BETWEEN  CURDATE() AND CURDATE() + INTERVAL 10 DAY');
        $invoices->orderBy('invoice_duedate');

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');

        $invoices->select('customer.customer_name', 'user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.is_publish', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name', 'user_invoices.created_at');
        $invoices->omniFilter();


        return view('page/invoices_duedate', [
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }

    public function List_pastduedate(Request $request)
    {

        $invoices = UserInvoices::query();

        if ($request->invoices_status == '1036') {
            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1037') {
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_paid = 0;
            $count_invoices_cancel = 0;
        }

        if ($request->invoices_status == '1008') {
            $count_invoices_paid = 0;
            $count_invoices_unpaid = 0;
            $count_invoices_cancel = self::count_invoices($request, '1008');
        }

        if (!$request->invoices_status) {

            $count_invoices_paid = self::count_invoices($request, '1036');
            $count_invoices_unpaid = self::count_invoices($request, '1037');
            $count_invoices_cancel = self::count_invoices($request, '1008');

        }

        if ($request->invoices_date_from) {
            $invoices->whereDate('user_invoices.invoice_date', '>=', $request->invoices_date_from);
        }

        if ($request->invoices_date_to) {
            $invoices->whereDate('user_invoices.invoice_date', '<=', $request->invoices_date_to);
        }

        if ($request->invoices_number) {
            $invoices->where('user_invoices.invoice_number', $request->invoices_number);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        if ($request->year) {
            $invoices->whereYear('trx_date', $request->year);
        }
        if ($request->month) {
            $invoices->whereMonth('trx_date', $request->month);
        }
        if ($request->month || $request->year) {
            $invoices->join('user_invoices_transaction', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id');
        }
        if ($request->filter_area) {
            $invoices->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id');
            $invoices->join('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id');
            $invoices->where('project_id', $request->filter_area);
        }

        $invoices->where('is_publish', (int)1);
        $invoices->where('user_invoices.status_id', '1037');
        $invoices->whereRaw('invoice_duedate <  CURDATE()');
        $invoices->orderByDesc('invoice_duedate');

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');

        $invoices->select('customer.customer_name', 'user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.is_publish', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name', 'user_invoices.created_at');
        $invoices->omniFilter();


        return view('page/invoices_pastduedate', [
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }

    public function List_proofOfPayment(Request $request)
    {

        $invoices = UserInvoices::latest();

        if ($request->invoices_date) {
            $invoices->where('user_invoices.invoice_date', $request->invoices_date);
        }

        if ($request->invoices_duedate) {
            $invoices->where('user_invoices.invoice_duedate', $request->invoices_duedate);
        }

        if ($request->invoices_id) {
            $invoices->where('user_invoices.id', $request->invoices_id);
        }

        if ($request->customer_name) {
            $invoices->where('customer.customer_name', 'LIKE', "%$request->customer_name%");
        }

        $invoices->where('status', 'Pending');
        $invoices->join('invoices_proof_payment', 'invoices_proof_payment.invoice_id', '=', 'user_invoices.id');
        // $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('customer', 'customer.id', '=', 'user_invoices.customer_id');
        $invoices->select('file', 'customer.customer_name', 'user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'user_invoices.created_at');
        $invoices->omniFilter();

        return view('page/invoices_proof-of-payment', [
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }


    public function List_billaccount(Request $request)
    {

        $invoices = UserInvoices::latest();

        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id');

        if ($request->billing_account) {
            $invoices->where('user_invoices_item.billing_account', $request->billing_account);
        } else {
            $invoices->where('user_invoices_item.billing_account', '000');
        }

        $invoices->select('user_invoices.id', 'user_invoices.invoice_type', 'user_invoices.is_publish', 'user_invoices.invoice_number', 'user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name');
        $invoices->omniFilter();


        return view('page/invoices_billing_account', [
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }


    public function Detail($invoices_id)
    {

        $cek_invoices = UserInvoices::query()->where('id', (int)$invoices_id)->first();
        // dd($cek_invoices);
        if ($cek_invoices == null || ($cek_invoices->reseller_id != session('reseller_id') && session('company_id') != 1)) {
            return redirect('console/invoices/list/draft')->with('failed', 'Not Found');
        }

        $invoices = UserInvoices::query()->where('id', (int)$invoices_id)->get();
        $order_id = UserInvoicesItem::query()->where('invoice_id', (int)$invoices_id)->first()->order_id;
        $invoices_item = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->where('item_name', 'not like', "%Potongan / Discount%")->get();
        $invoices_item_promo = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->where('item_name', 'like', "%Potongan / Discount%")->get();
        $invoices_transaction = UserInvoicestransaction::query()->where('invoice_id', (int)$invoices_id)->get();
        $invoices_transaction_count = UserInvoicestransaction::query()->where('invoice_id', (int)$invoices_id)->count();
        $invoices_payment = UserInvoicespayment::query()->where('user_invoices_payment.invoice_id', $invoices_id)->join('site_channel', 'site_channel.id', '=', 'user_invoices_payment.channel_id')->get();
        $get_customer_id = UserInvoices::query()->where('id', (int)$invoices_id)->first()->customer_id;


        $customer = Customer::query()
            ->leftJoin('customer_company', 'customer_company.user_id', '=', 'customer.id')
            ->leftJoin('site_company', 'customer_company.company_id', '=', 'site_company.id')
            ->where('customer.id', (int)$get_customer_id)->first();

        $proof_payment = InvoicesProofPayment::query()->where('invoice_id', (int)$invoices_id)->get();
        $proof_payment_count = InvoicesProofPayment::query()->where('invoice_id', (int)$invoices_id)->count();


        $product_id = UserInvoicesItem::query()->where('invoice_id', (int)$invoices_id)->first()->product_id;
        $product_group = SiteProduct::query()->where('site_product.id', (int)$product_id)->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')->first()->product_group_headline;
        $companies["UMS"] =
            [
            "id" => 1,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMI"] =
            [
            "id" => 2,
            "name" => "PT. UNINET MEDIA INFRASTRUKTUR",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMTEL"] =
            [
            "id" => 3,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Mandiri",
            "account_number" => "1170031177777"

        ];
        // print_r($companies[$product_group]);
        // die($product_group);

        $log_inv = LogActivity::query()
            ->where('module', 'invoices')
            ->where('module_id', (int)$invoices_id)
            ->orderByDesc('created_at')
            ->get();

        return view('page/invoices-detail', [
            'invoices' => $invoices,
            'invoices_item' => $invoices_item,
            'invoices_item_promo' => $invoices_item_promo,
            'customer' => $customer,
            'proof_payment' => $proof_payment,
            'proof_payment_count' => $proof_payment_count,
            'invoices_transaction' => $invoices_transaction,
            'invoices_transaction_count' => $invoices_transaction_count,
            'invoices_payment' => $invoices_payment,
            'log_inv' => $log_inv,
            'company' => $companies[$product_group],
        ]);

    }


    public function Edit($invoices_id)
    {

        $invoices = UserInvoices::query()->where('id', (int)$invoices_id)->get();
        $order_id = UserInvoices::query()->where('id', (int)$invoices_id)->first()->order_id;
        $invoices_item = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->get();
        $invoices_transaction = UserInvoicestransaction::query()->where('invoice_id', (int)$invoices_id)->get();
        $invoices_transaction_count = UserInvoicestransaction::query()->where('invoice_id', (int)$invoices_id)->count();
        $get_customer_id = UserInvoices::query()->where('id', (int)$invoices_id)->first()->customer_id;

        $billing_account = UserSubscription::query()->where('customer_id', $get_customer_id)->get();
        
        // $customer = Customer::query()->where('id', (int) $get_customer_id)->get();
        $customer = Customer::query()
            ->leftJoin('customer_company', 'customer_company.user_id', '=', 'customer.id')
            ->leftJoin('site_company', 'customer_company.company_id', '=', 'site_company.id')
            ->where('customer.id', (int)$get_customer_id)->first();

        $product_id = UserInvoicesItem::query()->where('invoice_id', (int)$invoices_id)->first()->product_id;
        $product_group = SiteProduct::query()->where('site_product.id', (int)$product_id)->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')->first()->product_group_headline;
        $companies["UMS"] =
            [
            "id" => 1,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMI"] =
            [
            "id" => 2,
            "name" => "PT. UNINET MEDIA INFRASTRUKTUR",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMTEL"] =
            [
            "id" => 3,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Mandiri",
            "account_number" => "1170031177777"

        ];

        $proof_payment = InvoicesProofPayment::query()->where('invoice_id', (int)$invoices_id)->get();
        $proof_payment_count = InvoicesProofPayment::query()->where('invoice_id', (int)$invoices_id)->count();

        return view('page/invoices_edit', [
            'invoices' => $invoices,
            'invoices_item' => $invoices_item,
            'billing_account' => $billing_account,
            'customer' => $customer,
            'company' => $companies[$product_group],
            'proof_payment' => $proof_payment,
            'proof_payment_count' => $proof_payment_count,
            'invoices_transaction' => $invoices_transaction,
            'invoices_transaction_count' => $invoices_transaction_count
        ]);

    }

    public function Update(Request $request)
    {

        $billing_account = $request->billing_account;
        $item_product = $request->product_id;
        $item_name = $request->item_name;
        $item_qty = $request->item_qty;
        $unit_amount = $request->unit_amount;

        $delete_item = UserInvoicesitem::where('invoice_id', (int)$request->invoice_id)->delete();

        for ($count = 0; $count < collect($item_name)->count(); $count++) {

            $order_id = UserSubscription::query()->where('billing_account', $billing_account[$count])->first()->order_id;

            $create_item = UserInvoicesitem::create([
                'invoice_id' => $request->invoice_id,
                'billing_account' => $billing_account[$count],
                'product_id' => $item_product[$count],
                'item_name' => $item_name[$count],
                'item_type' => 'ISP',
                'quantity' => $item_qty[$count],
                'amount' => $unit_amount[$count],
                'order_id' => $order_id
            ]);

        }

        $invoices = UserInvoices::where('id', $request->invoice_id)->update([
            'invoice_date' => $request->invoice_date,
            'invoice_duedate' => $request->invoice_duedate,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'invoices',
            'module_id' => $request->invoice_id,
            'log_label' => 'Update Invoices',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set update invoices, with invoices id :' . $request->invoice_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/invoices/edit/' . $request->invoice_id)->with('success', 'Success, Update invoices Invoices');

    }


    public function publish_invoices(Request $request)
    {

        $CUSTOMER_ID = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->customer_id;

        $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();

        $invoices = UserInvoices::where('id', $request->invoice_id)->update([
            'is_publish' => 1,
        ]);

        // SEND EMAIL To Customer
        self::Send_Invoices_Email($request->invoice_id, $CUSTOMER);

        return redirect('/console/invoices/detail/' . $request->invoice_id)->with('success', 'Success, set publish and send email to customer');

    }


    public function batch_publish_invoices(Request $request)
    {

        $invoices = $request->invoice_id;

        $max = count($invoices) - 1;

        for ($x = 0; $x <= $max; $x++) {

            $CUSTOMER_ID = UserInvoices::query()->where('id', (int)$invoices[$x])->first()->customer_id;

            $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();
            
            // set invoices status is publish true
            $set_publish = UserInvoices::where('id', $invoices[$x])->update([
                'is_publish' => 1,
            ]);

            // SEND EMAIL To Customer
            self::Send_Invoices_Email($invoices[$x], $CUSTOMER);

        }

        return redirect('/console/invoices/list/draft')->with('success', 'Success, set invoices draft to publish and send email to customer');

    }

    // function email tester
    public function Send_Invoices_Emails($invoices_id, $customer)
    {

        $INVOICES = UserInvoices::query()->where('id', (int)$invoices_id)->first();
        $INVOICES_ITEM = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->where('item_name', 'not like', "%Potongan / Discount%")->get();
        $INVOICES_ITEM_PROMO = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->where('item_name', 'like', "%Potongan / Discount%")->get();

        $sub_tagihan = 0;
        foreach ($INVOICES_ITEM as $item) {

            $invoices_items[$item->id] = [
                "item_name" => $item->item_name,
                "item_amount" => 'IDR. ' . number_format($item->amount, 0)
            ];

            $sub_tagihan = $sub_tagihan + $item->amount;

        }

        foreach ($INVOICES_ITEM_PROMO as $itemd) {

            $invoices_items_promo[$itemd->id] = [
                "item_name" => $itemd->item_name,
                "item_amount" => 'IDR. - ' . number_format($itemd->amount, 0)
            ];

        }

        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/email/send', [
                'action' => 'Terbit Tagihan',
                'send_to' => 'fajarizaf@gmail.com',
                'name' => $customer->customer_name,
                'inv_number' => $INVOICES->id,
                'inv_due' => $INVOICES->invoice_duedate,
                'inv_date' => $INVOICES->invoice_date,
                'invoice_item' => $invoices_items,
                'invoice_item_promo' => $invoices_items_promo,
                'sub_tagihan' => 'IDR. ' . number_format($sub_tagihan, 0),
                'subtotal' => 'IDR. ' . number_format($INVOICES->subtotal, 0),
                'tax' => $INVOICES->tax . '%',
                'total' => 'IDR. ' . number_format($INVOICES->total, 0),

            ]);

        return $response;

    }


    public function Send_Invoices_Email($invoices_id, $customer, $subject = "Terbit Tagihan")
    {

        $INVOICES = UserInvoices::query()->where('id', (int)$invoices_id)->first();
        $INVOICES_ITEM = UserInvoicesitem::query()->where('invoice_id', (int)$invoices_id)->where('item_name', 'not like', "%Potongan / Discount%")->get();

        $sub_tagihan = 0;
        foreach ($INVOICES_ITEM as $item) {

            $invoices_items[$item->id] = [
                "item_name" => $item->item_name,
                "item_amount" => 'IDR. ' . number_format($item->amount, 0)
            ];

            $sub_tagihan = $sub_tagihan + $item->amount;

        }

        $product_id = UserInvoicesItem::query()->where('invoice_id', (int)$invoices_id)->first()->product_id;
        $product_group = SiteProduct::query()->where('site_product.id', (int)$product_id)->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')->first()->product_group_headline;
        $companies["UMS"] =
            [
            "id" => 1,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMI"] =
            [
            "id" => 2,
            "name" => "PT. UNINET MEDIA INFRASTRUKTUR",
            "bank_name" => "Bank Central Asia (KCP SETIABUDI ATRIUM)",
            "account_number" => "7660 6006 68"

        ];
        $companies["UMTEL"] =
            [
            "id" => 3,
            "name" => "PT. UNINET MEDIA SAKTI",
            "bank_name" => "Bank Mandiri",
            "account_number" => "1170031177777"

        ];

        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/email/send', [
                'action' => $subject, //'Terbit Tagihan',
                'send_to' => $customer->customer_email,
                'name' => $customer->customer_name,
                'inv_number' => $INVOICES->id,
                'inv_due' => $INVOICES->invoice_duedate,
                'inv_date' => $INVOICES->invoice_date,
                'invoice_item' => $invoices_items,
                'invoice_item_promo' => null,
                'sub_tagihan' => 'IDR. ' . number_format($sub_tagihan, 0),
                'subtotal' => 'IDR. ' . number_format($INVOICES->subtotal, 0),
                'tax' => $INVOICES->tax . '%',
                'total' => 'IDR. ' . number_format($INVOICES->total, 0),
                'company' => $companies[$product_group],

            ]);

        return $response;

    }


    public function add_payment(Request $request)
    {

        $amount_tagihan = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->total;
        $date_tagihan = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->invoice_date;
        $customer_id = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->customer_id;
        $status_tagihan = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->status_id;
        

        // if($amount_tagihan <= $request->amount) {

        $new_invoicenumber = IdGenerator::generate(['table' => 'user_invoices', 'field' => 'invoice_number', 'length' => 11, 'prefix' => 'INV-']);

        $set_paid = UserInvoices::where('id', $request->invoice_id)->update([
            'invoice_number' => $new_invoicenumber,
            'invoice_datepaid' => $request->payment_date,
            'status_id' => 1036
        ]);

        $approve_proofpayment = InvoicesProofPayment::where('invoice_id', $request->invoice_id)->update([
            'status' => 'Approved'
        ]);

        $PREFIX = "TRX-";

        $TRANSACTION_NUMBER = IdGenerator::generate(['table' => 'user_invoices_transaction', 'field' => 'trx_number', 'length' => 9, 'prefix' => $PREFIX]);

        $AMOUNT_TRANSACTION = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->total;
        $customer = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->customer_id;
        $CUSTOMERS = Customer::query()->where('id', (int)$customer)->first();


        $ADD_TRANSACTION = UserInvoicestransaction::create([
            'reseller_id' => session('reseller_id'),
            'trx_number' => $TRANSACTION_NUMBER,
            'trx_date' => $request->payment_date,
            'invoice_id' => $request->invoice_id,
            'currency' => 'IDR',
            'amount_in' => $request->amount,
            'gateway' => $request->payment_method,
            'transid' => $request->transaction_id,
            'fees' => $request->fees,
            'payment_status' => 'Paid',
        ]);


            // apabila status tagihan belum paid
        if ($status_tagihan != 1036) {
            
                // CEK ORDER Type membership or not
                // Apabila order layanan membership, lakukan aktiavasi membership
            $invoice_item = UserInvoicesitem::query()->where('invoice_id', $request->invoice_id)->where('order_id', '!=', '')->get();

            foreach ($invoice_item as $item) {

                $product_type = SiteProduct::query()->where('id', $item->product_id)->first()->product_type;

                    // apabila product type membership ditemukan
                if ($product_type == 'membership') {

                    $membership_status = CustomerMembership::query()->where('customer_id', (int)$customer_id)->first()->is_active;

                    if ($membership_status == 0) {

                            // AKTIVASI MEMBERSHIP
                        $activation = Http::withToken(env('BACKEND_TOKEN'))->withBody(json_encode(["id" => $customer_id]), 'application/json')->post(env('BACKEND_URL') . '/membership/activation/');

                    }

                        // SET COMMISION TO UPLINE
                    $activation = Http::withToken(env('BACKEND_TOKEN'))->post(env('BACKEND_URL') . '/membership/setCommision/' . $customer_id);

                }

                    // get all subscription customer in deactive
                $subscription = UserSubscription::query()->where('order_id', $item->order_id)->where('status_id', 1002)->get();

                $api = new RouterosAPI();

                    //set active subscription
                foreach ($subscription as $sub) {

                    $AREA_ID = OrderProject::query()->where('order_id', $sub->order_id)->first();
                    $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();
                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();

                    if ($api->connect($router->ipaddress, $router->username, $router->password)) {

                        $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $sub->subscription_number]));
                            
                            // apabila layanan deactive di mikrotik maka set active layanan yang berkaitan dengan invoices tersebut
                        if ($secret[0]['profile'] == 'profile-isolir') {

                            $profile_name = SiteProduct::query()->where('id', $sub->product_id)->first()->product_profile;

                                // set active secret, change profile
                            $params = array_merge(['password' => $secret['0']['password']], [
                                '.id' => $secret['0']['.id'],
                                'name' => $secret['0']['name'],
                                'service' => $secret['0']['service'],
                                'profile' => $profile_name,
                                'disabled' => 'false',
                            ]);

                            $api->comm('/ppp/secret/set', $params);

                                // get connection
                            $arrID = $api->comm("/ppp/active/getall", array(".proplist" => ".id", "?name" => $sub->subscription_number));


                            if (!empty($arrID)) { 

                                    // reset connection
                                $api->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"], ));

                                $api->disconnect();

                                $LOG_ACTIVITY = LogActivity::create([
                                    'module' => 'subscription',
                                    'module_id' => $sub->id,
                                    'log_label' => 'Auto Set Active Subscription triger set paid invoices',
                                    'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to active subscription, with subscribtion id :' . $sub->id,
                                    'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                                    'log_user_id' => auth()->user()->id,
                                    'log_user_ip' => request()->ip(),
                                ]);

                            }

                        }

                    }

                    $Update = UserSubscription::where('id', $sub->id)->update([
                        'status_id' => 1001,
                        'reactive_date' => now()
                    ]);

                }

            }

        }

            

            // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/notif/create', [
                "user" => "customer",
                "template_id" => 9,
                "id" => $request->invoice_id,
                "user_id" => [$customer]
            ]);

            // EMAIL notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/email/send', [
                'action' => 'Tagihan Terbayar',
                'send_to' => $CUSTOMERS->customer_email,
                'customer_name' => $CUSTOMERS->customer_name,
                'invoice_id' => $request->invoice_id,
                'invoice_date' => $date_tagihan,
                'invoice_status' => 'Paid',
                'invoice_total' => 'IDR. ' . number_format($amount_tagihan, 0),
                'invoice_paid' => 'IDR. ' . number_format($request->amount, 0),
            ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'invoices',
            'module_id' => $request->invoice_id,
            'log_label' => 'Paid Invoices',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to paid invoices, with invoices id :' . $request->invoice_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/invoices/detail/' . $request->invoice_id)->with('success', 'Success, Success set invoice to paid');

        // } else {

        //     return redirect('/console/invoices/detail/'.$request->invoice_id)->with('failed', 'Failed, Nominal pembayaran kurang dari total tagihan yang perlu dibayar');

        // }

    }


    public function bukti_bayar_rejected(Request $request)
    {

        $customer = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->customer_id;

        $set_paid = InvoicesProofPayment::where('invoice_id', $request->invoice_id)->update([
            'status' => 'Rejected',
            'reject_reason' => $request->rejected_reason,
        ]);

        $log_label = 'Rejected Proof Of Payment';
        $template_id = 7;

        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/notif/create', [
                "user" => "customer",
                "template_id" => $template_id,
                "id" => $request->invoice_id,
                "user_id" => [$customer]
            ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'invoices',
            'module_id' => $request->invoice_id,
            'log_label' => $log_label,
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set Proof Of Payment to Rejected, with invoices id :' . $request->invoice_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/invoices/detail/' . $request->invoice_id)->with('success', 'Success, Proof of Payment set to Rejected');

    }


    public function Upload_bukti_bayar(Request $request)
    {

        $attachment = '';

        $response = 'success';

        if ($request->hasFile('bukti_bayar')) {

            $iconImageFile = $request->file('bukti_bayar');
            $iconfilename = $iconImageFile->getClientOriginalName();
            $icontmpFilePath = $iconImageFile->getPathname();
            $iconImageMimeType = $iconImageFile->getClientMimeType();
            $iconimage = new \CURLFile($icontmpFilePath, $iconImageMimeType, $iconfilename);


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
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'private'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('BACKEND_TOKEN') . ''
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response);

            $attachment = $response->images;

            $response = $response->status;

            curl_close($curl);
        }

        if ($response) {

            $add = InvoicesProofPayment::create([
                'invoice_id' => $request->invoices_id,
                'file' => $attachment,
                'status' => 'Approved',
            ]);

            return redirect('/console/invoices/detail/' . $request->invoices_id)->with('success', 'Success, upload proof of payment');

        } else {

            return redirect('/console/invoices/detail/' . $request->invoices_id)->with('failed', 'Failed, upload proof of payment');

        }

    }

    public function download_attachments($attachments)
    {

        return response()->streamDownload(function () use ($attachments) {
            $response = Http::withToken(env('BACKEND_TOKEN'))->withHeaders([
                'accept' => 'application/octet-stream',
            ])->get(env('BACKEND_URL') . '/image/private/get/ums/' . $attachments);
            echo $response->body();
        }, $attachments); // replace with actual name

    }

// versi 1
/*
    public function terbit_invoices_perlayanan(Request $request) {

        $current_date = date('Y-m-d');

        $subscription = UserSubscription::query()->where('next_due_date', $current_date)->get();

        if(count($subscription) != 0) {

            foreach ($subscription as $sub) {
                
                $product = SiteProduct::query()->where('id', (int) $sub->product_id)->first();

                $tax = 11;
                $subtotal = $sub->amount;
                $price_tax = ($subtotal * $tax) / 100;
                $total = $subtotal + $price_tax;

                $INVOICES = UserInvoices::create([
                    'invoice_type' => 'renew',
                    'customer_id' => $sub->customer_id,
                    'order_id' => $sub->order_id,
                    'invoice_date' => Carbon::now(),
                    'invoice_duedate' => Carbon::now()->addDays(7),
                    'payment_method' => 'Bank Transfer',
                    'tax' => $tax,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'is_publish' => 0,
                    'status_id' => 1037,
                ]);

                $INVOICES_ITEM = UserInvoicesitem::create([
                    'invoice_id' => $INVOICES->id,
                    'billing_account' => $sub->billing_account,
                    'order_id' => $sub->order_id,
                    'product_id' => $product->id,
                    'item_name' => $product->product_name . ' - ' .$product->product_plan .' '. self::Prorate_period($current_date),
                    'item_type' => $product->product_type,
                    'payment_method' => 'Bank Transfer',
                    'tax' => 0,
                    'quantity' => 1,
                    'amount' => $subtotal,
                ]);

                $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                    'next_due_date' => date('Y-m-d', strtotime('1 month')),
                ]);

            }

        }

    }


    public function terbit_invoices(Request $request) {

        $current_date = date('Y-m-d');

        $customer = Customer::query()->get();
        
        if(count($customer) != 0) {

            foreach ($customer as $user) {
                
                $subscription = UserSubscription::query()
                ->where('customer_id', $user->id)
                ->where('next_due_date', $current_date)
                ->where('status_id', 1001)
                ->get();

                if(count($subscription) != 0) {

                    $INVOICES = UserInvoices::create([
                        'invoice_type' => 'renew',
                        'customer_id' => $user->id,
                        'invoice_date' => Carbon::now(),
                        'invoice_duedate' => Carbon::now()->addDays(7),
                        'payment_method' => 'Bank Transfer',
                        'is_publish' => 0,
                        'status_id' => 1037,
                    ]);

                    $subtotal = 0;
                    foreach($subscription as $sub) {

                        $product = SiteProduct::query()->where('id', (int) $sub->product_id)->first();

                        $INVOICES_ITEM = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' .$product->product_plan .' '. self::Prorate_period($current_date),
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $sub->amount,
                        ]);

                        $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                            'next_due_date' => date('Y-m-d', strtotime('1 month')),
                        ]);

                        $subtotal = $subtotal + $sub->amount;

                    }

                    $tax = 11;
                    $price_tax = ($subtotal * $tax) / 100;
                    $total = $subtotal + $price_tax;

                    $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total
                    ]);

                } else {
                    echo "subscription not found";
                }

            }

        } else {
            echo "customer not found";
        }

    }


    public function terbit_invoices_manual(Request $request) {

        $current_date = date('Y-m-d');

        $current_date_month = date('m');
        $current_date_year = date('Y');

        $customer = Customer::query()->get();

        if(count($customer) != 0) {

            foreach ($customer as $user) {
                
                $subscription = UserSubscription::query()
                ->where('customer_id', $user->id)
                ->whereMonth('next_due_date', $current_date_month)
                ->whereYear('next_due_date', $current_date_year)
                ->where('status_id', 1001)
                ->get();

                if(count($subscription) != 0) {

                    $INVOICES = UserInvoices::create([
                        'invoice_type' => 'renew',
                        'customer_id' => $user->id,
                        'invoice_date' => Carbon::now(),
                        'invoice_duedate' => Carbon::now()->addDays(7),
                        'payment_method' => 'Bank Transfer',
                        'is_publish' => 0,
                        'status_id' => 1037,
                    ]);

                    $subtotal = 0;
                    foreach($subscription as $sub) {

                        $product = SiteProduct::query()->where('id', (int) $sub->product_id)->first();

                        $INVOICES_ITEM = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' .$product->product_plan .' '. self::Prorate_period($current_date),
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $sub->amount,
                        ]);

                        $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                            'next_due_date' => date('Y-m-d', strtotime('1 month')),
                        ]);

                        $subtotal = $subtotal + $sub->amount;

                    }

                    $tax = 11;
                    $price_tax = ($subtotal * $tax) / 100;
                    $total = $subtotal + $price_tax;

                    $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total
                    ]);

                }

            }

        } else {
            echo "customer not found";
        }

    }



    public function terbit_invoices_manual_percustomer(Request $request) {

        $current_date = date('Y-m-d');

        $customer = Customer::query()->where('customer_number', $request->customer_number)->get();

        if(count($customer) != 0) {

            foreach ($customer as $user) {
                
                $subscription = UserSubscription::query()
                ->where('customer_id', $user->id)
                ->where('status_id', 1001)
                ->get();

                if(count($subscription) != 0) {

                    $INVOICES = UserInvoices::create([
                        'invoice_type' => 'renew',
                        'customer_id' => $user->id,
                        'invoice_date' => Carbon::now(),
                        'invoice_duedate' => Carbon::now()->addDays(7),
                        'payment_method' => 'Bank Transfer',
                        'is_publish' => 0,
                        'status_id' => 1037,
                        'created_by' => auth()->user()->id,
                    ]);

                    $subtotal = 0;
                    foreach($subscription as $sub) {

                        $product = SiteProduct::query()->where('id', (int) $sub->product_id)->first();

                        $INVOICES_ITEM = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' .$product->product_plan .' '. self::Prorate_period($current_date),
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $sub->amount,
                        ]);

                        $subtotal = $subtotal + $sub->amount;

                    }

                    $tax = 11;
                    $price_tax = ($subtotal * $tax) / 100;
                    $total = $subtotal + $price_tax;

                    $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total
                    ]);

                    return redirect('/console/invoices/list/draft')->with('success', 'Success, Create new invoices');
                } else {
                    echo "subscription not found";
                }

            }

        } else {
            echo "customer not found";
        }

    }


    // versi 1
    public function Prorate_period($date_live) {

        $now = Carbon::parse($date_live);

        $current_day = $now->day;
        $prev_month = $now->month;
        $current_year = $now->year;

        $period_start = $current_year.'/'.$prev_month.'/26';

        $month = $now->month + 1;

        $period_end = $current_year.'/'.$month.'/25';

        $period = '( '.$period_start.' - '.$period_end.' )';

        return $period;

    }
     */

    // versi 2
    public function terbit_invoices_perlayanan(Request $request)
    {

        $current_date = date('Y-m-d');

        $subscription = UserSubscription::query()->where('next_due_date', $current_date)->get();

        if (count($subscription) != 0) {

            foreach ($subscription as $sub) {

                $product = SiteProduct::query()->where('id', (int)$sub->product_id)->first();

                $tax = 11;
                $subtotal = $sub->amount;
                $price_tax = ($subtotal * $tax) / 100;
                $total = $subtotal + $price_tax;

                $INVOICES = UserInvoices::create([
                    'reseller_id' => session('reseller_id'),
                    'invoice_type' => 'renew',
                    'customer_id' => $sub->customer_id,
                    'order_id' => $sub->order_id,
                    'invoice_date' => Carbon::now(),
                    'invoice_duedate' => Carbon::now()->addDays(9),
                    'payment_method' => 'Bank Transfer',
                    'tax' => $tax,
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'is_publish' => 0,
                    'status_id' => 1037,
                ]);

                $INVOICES_ITEM = UserInvoicesitem::create([
                    'invoice_id' => $INVOICES->id,
                    'billing_account' => $sub->billing_account,
                    'order_id' => $sub->order_id,
                    'product_id' => $product->id,
                    'item_name' => $product->product_name . ' - ' . $product->product_plan . ' ' . self::Prorate_period($current_date),
                    'item_type' => $product->product_type,
                    'payment_method' => 'Bank Transfer',
                    'tax' => 0,
                    'quantity' => 1,
                    'amount' => $subtotal,
                ]);

                $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                    'next_due_date' => date('Y-m-d', strtotime('1 month')),
                ]);

            }

        }

    }

    // versi 2
    public function terbit_invoices(Request $request)
    {

        $current_date = date('Y-m-d');

        $customer = Customer::query()->get();

        if (count($customer) != 0) {

            foreach ($customer as $user) {
                $company_group = SiteProductGroup::query()
                    ->select('product_group_headline')
                    ->where('is_hidden', 0)
                    ->groupby('product_group_headline')
                    ->get();

                foreach ($company_group as $comp) {
                    // echo $comp->product_group_headline;
                    // cek subscription dengan 'payment_type' = "recurring"
                    $subscription = UserSubscription::query()
                        ->select('user_subscription.id', 'user_subscription.product_id', 'order_id', 'billing_account', 'amount')
                        ->join('site_product_price', 'site_product_price.product_id', '=', 'user_subscription.product_id')
                        ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
                        ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
                        ->where('customer_id', $user->id)
                        ->where('next_due_date', $current_date)
                        ->where('status_id', 1001)
                        ->where('payment_type', "recurring")
                        ->where('product_group_headline', $comp->product_group_headline)
                        ->get();

                    if (count($subscription) != 0) {

                        $INVOICES = UserInvoices::create([
                            'reseller_id' => session('reseller_id'),
                            'invoice_type' => 'renew',
                            'customer_id' => $user->id,
                            'invoice_date' => Carbon::now(),
                            'invoice_duedate' => Carbon::now()->addDays(9),
                            'payment_method' => 'Bank Transfer',
                            'is_publish' => 0,
                            'status_id' => 1037,
                            'reseller_id' => 1,
                        ]);

                        $subtotal = 0;
                        foreach ($subscription as $sub) {

                            $product = SiteProduct::query()->where('id', (int)$sub->product_id)->first();

                            $INVOICES_ITEM = UserInvoicesitem::create([
                                'order_id' => $sub->order_id,
                                'billing_account' => $sub->billing_account,
                                'invoice_id' => $INVOICES->id,
                                'product_id' => $product->id,
                                'item_name' => $product->product_name . ' - ' . $product->product_plan . ' ---' . self::Prorate_period($current_date),
                                'item_type' => $product->product_type,
                                'payment_method' => 'Bank Transfer',
                                'tax' => 0,
                                'quantity' => 1,
                                'amount' => $sub->amount,
                            ]);

                            $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                                'next_due_date' => date('Y-m-d', strtotime('1 month')),
                            ]);

                            $subtotal = $subtotal + $sub->amount;

                        }

                        $tax = 11;
                        $price_tax = ($subtotal * $tax) / 100;
                        $total = $subtotal + $price_tax;

                        $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                            'subtotal' => $subtotal,
                            'tax' => $tax,
                            'total' => $total
                        ]);

                    } else {
                        echo $comp->product_group_headline . " subscription not found with user_id = " . $user->id . " <br>";
                    }
                }

            }

        } else {
            echo "customer not found";
        }

    }



    // versi 2
    public function terbit_invoices_manual(Request $request)
    {

        $current_date = date('Y-m-d');

        $current_date_month = date('m');
        $current_date_year = date('Y');

        $customer = Customer::query()->get();

        if (count($customer) != 0) {

            foreach ($customer as $user) {

                $subscription = UserSubscription::query()
                    ->where('customer_id', $user->id)
                    ->whereMonth('next_due_date', $current_date_month)
                    ->whereYear('next_due_date', $current_date_year)
                    ->where('status_id', 1001)
                    ->get();

                if (count($subscription) != 0) {

                    $INVOICES = UserInvoices::create([
                        'reseller_id' => session('reseller_id'),
                        'invoice_type' => 'renew',
                        'customer_id' => $user->id,
                        'invoice_date' => Carbon::now(),
                        'invoice_duedate' => Carbon::now()->addDays(9),
                        'payment_method' => 'Bank Transfer',
                        'is_publish' => 0,
                        'status_id' => 1037,
                    ]);

                    $subtotal = 0;
                    foreach ($subscription as $sub) {

                        $product = SiteProduct::query()->where('id', (int)$sub->product_id)->first();

                        $INVOICES_ITEM = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' . $product->product_plan . ' ' . self::Prorate_period($current_date),
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $sub->amount,
                        ]);

                        $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                            'next_due_date' => date('Y-m-d', strtotime('1 month')),
                        ]);

                        $subtotal = $subtotal + $sub->amount;

                    }

                    $tax = 11;
                    $price_tax = ($subtotal * $tax) / 100;
                    $total = $subtotal + $price_tax;

                    $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total
                    ]);

                }

            }

        } else {
            echo "customer not found";
        }

    }


    // versi 2
    public function terbit_invoices_manual_percustomer(Request $request)
    {

        $current_date = date('Y-m-d');

        $customer = Customer::query()->where('id', $request->customer_number)->get();

        if (count($customer) != 0) {

            foreach ($customer as $user) {
                $company_group = SiteProductGroup::query()
                    ->select('product_group_headline')
                    ->where('is_hidden', 0)
                    ->groupby('product_group_headline')
                    ->get();

                foreach ($company_group as $comp) {

                    $base_query = UserSubscription::query()
                        ->select('user_subscription.id', 'user_subscription.product_id', 'order_id', 'billing_account', 'amount', 'status_id')
                        ->join('site_product_price', 'site_product_price.product_id', '=', 'user_subscription.product_id')
                        ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
                        ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
                        ->where('customer_id', $user->id)
                        // ->where('next_due_date', $current_date)
                        ->where('payment_type', "recurring")
                        ->where('product_group_headline', $comp->product_group_headline);

                    $check_active = clone $base_query;
                    $is_active = $check_active->where('status_id', 1001)->exists();

                    if ($is_active) {
                        $base_query->where('status_id', 1001);
                    }

                    $subscription = $base_query->get();

                    if (count($subscription) != 0) {

                        $INVOICES = UserInvoices::create([
                            'reseller_id' => session('reseller_id'),
                            'invoice_type' => 'renew',
                            'customer_id' => $user->id,
                            'invoice_date' => Carbon::now(),
                            'invoice_duedate' => Carbon::now()->addDays(10),
                            'payment_method' => 'Bank Transfer',
                            'is_publish' => 0,
                            'status_id' => 1037,
                            'created_by' => auth()->user()->id,
                        ]);

                        $subtotal = 0;
                        foreach ($subscription as $sub) {

                            $product = SiteProduct::query()->where('id', (int)$sub->product_id)->first();

                            $INVOICES_ITEM = UserInvoicesitem::create([
                                'order_id' => $sub->order_id,
                                'billing_account' => $sub->billing_account,
                                'invoice_id' => $INVOICES->id,
                                'product_id' => $product->id,
                                'item_name' => $product->product_name . ' - ' . $product->product_plan . ' ' . self::Prorate_period($current_date),
                                'item_type' => $product->product_type,
                                'payment_method' => 'Bank Transfer',
                                'tax' => 0,
                                'quantity' => 1,
                                'amount' => $sub->amount,
                            ]);

                            $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                                'next_due_date' => date('Y-m-d', strtotime('1 month')),
                            ]);

                            $subtotal = $subtotal + $sub->amount;

                        }

                        $tax = 11;
                        $price_tax = ($subtotal * $tax) / 100;
                        $total = $subtotal + $price_tax;

                        $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                            'subtotal' => $subtotal,
                            'tax' => $tax,
                            'total' => $total
                        ]);

                        return redirect('/console/invoices/list/draft')->with('success', 'Success, Create new invoices');

                    } else {
                        echo $comp->product_group_headline . " subscription not found with user_id = " . $user->id . " <br>";
                    }
                }

            }

        } else {
            echo "customer not found";
        }

    }


    public function terbit_invoices_peralihan(Request $request)
    {

        $current_date = date('Y-m-d');

        $customer = Customer::query()->get();

        if (count($customer) != 0) {

            foreach ($customer as $user) {

                $subscription = UserSubscription::query()
                    ->where('customer_id', $user->id)
                    ->where('next_due_date', $current_date)
                    ->where('status_id', 1001)
                    ->get();

                $c_sub = count($subscription);
                echo $c_sub;

                if ($c_sub != 0) {

                    $INVOICES = UserInvoices::create([
                        'reseller_id' => session('reseller_id'),
                        'invoice_type' => 'renew',
                        'customer_id' => $user->id,
                        'invoice_date' => Carbon::now(),
                        'invoice_duedate' => Carbon::now()->addDays(9),
                        'payment_method' => 'Bank Transfer',
                        'is_publish' => 0,
                        'status_id' => 1037,
                    ]);

                    $subtotal = 0;
                    foreach ($subscription as $sub) {

                        $product = SiteProduct::query()->where('id', (int)$sub->product_id)->first();

                        $prorate_amount = self::Prorate_calculations($sub->amount);

                        $INVOICES_ITEMS = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' . $product->product_plan . '( 2024/8/26 - 2024/8/31 )',
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $prorate_amount,
                        ]);

                        $INVOICES_ITEM = UserInvoicesitem::create([
                            'order_id' => $sub->order_id,
                            'billing_account' => $sub->billing_account,
                            'invoice_id' => $INVOICES->id,
                            'product_id' => $product->id,
                            'item_name' => $product->product_name . ' - ' . $product->product_plan . ' ' . self::Prorate_period($current_date),
                            'item_type' => $product->product_type,
                            'payment_method' => 'Bank Transfer',
                            'tax' => 0,
                            'quantity' => 1,
                            'amount' => $sub->amount,
                        ]);

                        $update_nextinvoices = UserSubscription::where('id', $sub->id)->update([
                            'next_due_date' => date('Y-m-d', strtotime('1 month')),
                        ]);

                        $subtotal = $subtotal + $sub->amount + $prorate_amount;

                    }

                    $tax = 11;
                    $price_tax = ($subtotal * $tax) / 100;
                    $total = $subtotal + $price_tax;

                    $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total
                    ]);

                }

            }

        } else {
            echo "customer not found";
        }

    }


    public function Prorate_calculations($amount_subscription)
    {

        $now = Carbon::now();

        $totalDayInMonth = $now->daysInMonth;

        $cost_per_day = $amount_subscription / $totalDayInMonth;

        $prorate = 7 * $cost_per_day;

        return $prorate;

    }


    // versi 2
    public function Prorate_period($date_live)
    {

        $now = Carbon::parse($date_live);

        $current_day = $now->day;
        $current_month = $now->month;
        $current_year = $now->year;
        $totalDayInMonth = $now->daysInMonth;

        $period_start = $current_year . '/' . $current_month . '/' . $current_day;

        $period_end = $current_year . '/' . $current_month . '/' . $totalDayInMonth;

        $period = '( ' . $period_start . ' - ' . $period_end . ' )';

        return $period;

    }


    public function cancel_invoices(Request $request)
    {

        $invoices = UserInvoices::where('id', $request->invoice_id)->update([
            'status_id' => "1008",
            'updated_by' => auth()->user()->id,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'invoices',
            'module_id' => $request->invoice_id,
            'log_label' => 'Cancel Invoices',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set cancel invoice, with invoice id :' . $request->invoice_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/invoices/detail/' . $request->invoice_id)->with('success', 'Success, set cancel invoice');

    }


    public function reminder_invoices(Request $request)
    {

        $CUSTOMER_ID = UserInvoices::query()->where('id', (int)$request->invoice_id)->first()->customer_id;

        $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();

        // SEND EMAIL To Customer
        self::Send_Invoices_Email($request->invoice_id, $CUSTOMER, "Reminder Tagihan");

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'invoices',
            'module_id' => $request->invoice_id,
            'log_label' => 'Reminder Invoices',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been sent email reminder to customer, with invoice id :' . $request->invoice_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/invoices/detail/' . $request->invoice_id)->with('success', 'Success, send email reminder to customer');

    }


    public function StatisticPerYear(Request $request)
    {
        if ($request->filter_year) {
            $year = $request->filter_year;
        } else {
            $now = Carbon::now();
            $year = $now->year;
        }

        $initYear = UserInvoicestransaction::query()
            ->select(DB::raw('YEAR(trx_date) year'))
            ->groupby('year')
            ->omniFilter()
            ->get(); //->toArray();

        $total_paid = UserInvoicestransaction::query()->whereYear('trx_date', $year)->omniFilter()->sum('amount_in');
        $total_unpaid = UserInvoices::query()->where('status_id', '1037')->whereYear('created_at', $year)->omniFilter()->sum('total');
        $total_cancel = UserInvoices::query()->where('status_id', '1008')->whereYear('created_at', $year)->omniFilter()->sum('total');

        $count_paid = UserInvoicestransaction::query()->whereYear('trx_date', $year)->omniFilter()->count();
        $count_unpaid = UserInvoices::query()->where('status_id', '1037')->whereYear('created_at', $year)->omniFilter()->count();
        $count_cancel = UserInvoices::query()->where('status_id', '1008')->whereYear('created_at', $year)->omniFilter()->count();

        $total_paid_group_by_month = UserInvoicestransaction::query()->select(DB::raw('sum(amount_in) as `data`'), DB::raw('YEAR(trx_date) year, MONTH(trx_date) month'))
            ->whereYear('trx_date', $year)
            ->groupby('year', 'month')
            ->omniFilter()
            ->get(); //->toArray();

        $month = array(array('month' => 'Januari'), array('month' => 'Februari'), array('month' => 'Maret'), array('month' => 'April'), array('month' => 'Mei'), array('month' => 'Juni'), array('month' => 'Juli'), array('month' => 'Agustus'), array('month' => 'September'), array('month' => 'Oktober'), array('month' => 'November'), array('month' => 'Desember'));

        foreach ($total_paid_group_by_month as $dat) {
            $dataQuery[$dat->month] = array('total' => $dat->data, 'bln' => $dat->month);
        }

        $total_cogs = 0;
        foreach ($month as $key => $d) {
            $a = 0;
            if (isset($dataQuery[$key + 1]['bln'])) {
                $a = $dataQuery[$key + 1]['total'];
            }
            $cogs = 70 / 100 * $a;
            $profit = $a - $cogs;
            $month_map[] = array('month' => $d['month'], 'count' => $a);
            if ($a > 0) {
                $month_list[] = array('number' => $key + 1, 'month' => $d['month'], 'revenue' => $a, 'cogs' => $cogs, 'profit' => $profit);
            }
            $total_cogs += $cogs;
        }

        return view('page/rev-stat-peryear', [
            'total_paid' => number_format($total_paid, 0),
            'cogs' => number_format($total_cogs, 0),
            'profit' => number_format($total_paid - $total_cogs, 0),
            'count_cancel' => $count_cancel,
            'count_unpaid' => $count_unpaid,
            'count_paid' => $count_paid,
            'statistic_perday' => json_encode($month_map),
            'month_list' => $month_list,
            'year' => $year,
            'initYear' => $initYear,
        ]);

    }

    public function StatisticByYear(Request $request)
    {
        $total_paid = UserInvoicestransaction::query()->omniFilter()->sum('amount_in');
        $total_unpaid = UserInvoices::query()->where('status_id', '1037')->omniFilter()->sum('total');
        $total_cancel = UserInvoices::query()->where('status_id', '1008')->omniFilter()->sum('total');

        $count_paid = UserInvoicestransaction::query()->omniFilter()->count();
        $count_unpaid = UserInvoices::query()->where('status_id', '1037')->omniFilter()->count();
        $count_cancel = UserInvoices::query()->where('status_id', '1008')->omniFilter()->count();

        $total_paid_group_by_year = UserInvoicestransaction::query()->select(DB::raw('sum(amount_in) as `data`'), DB::raw('YEAR(trx_date) year'))
            ->groupby('year')
            ->omniFilter()
            ->get(); //->toArray();

        $total_cogs = 0;
        foreach ($total_paid_group_by_year as $dat) {
            $year[] = array('month' => $dat->year, 'count' => $dat->data);
            $cogs = 70 / 100 * $dat->data;
            $profit = $dat->data - $cogs;
            $year_list[] = array('year' => $dat->year, 'revenue' => $dat->data, 'cogs' => $cogs, 'profit' => $profit);

            $total_cogs += $cogs;
        }

        return view('page/rev-stat-byyear', [
            'total_paid' => number_format($total_paid, 0),
            'cogs' => number_format($total_cogs, 0),
            'profit' => number_format($total_paid - $total_cogs, 0),
            'count_cancel' => $count_cancel,
            'count_unpaid' => $count_unpaid,
            'count_paid' => $count_paid,
            'statistic_perday' => json_encode($year),
            'year_list' => $year_list,
        ]);

    }

    public function current_date(Request $request)
    {

        $current_date = date('Y-m-d H:i:s');

        dd($current_date);

    }


}
