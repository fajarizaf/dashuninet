<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerMembership;
use App\Models\LogActivity;
use App\Models\Pipeline;
use App\Models\SiteProduct;
use App\Models\SiteProductField;
use App\Models\SiteProductGroup;
use App\Models\SiteProductPrice;
use App\Models\SiteStatus;
use App\Models\SiteProject;
use App\Models\SiteEmployee;
use App\Models\User;
use App\Models\UserInvoices;
use App\Models\UserInvoicesitem;
use App\Models\UserInvoicestransaction;
use App\Models\UserOrderDetail;
use App\Models\UserOrderField;
use App\Models\UserOrderItem;
use App\Models\UserOrderDocument;
use App\Models\UserOrderSpk;
use App\Models\UserRole;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionField;
use App\Models\OrderProject;
use App\Models\SiteCompany;
use App\Models\CustomerCompany;
use App\Models\Promo;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SalesorderController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function list(Request $request)
    {

        $salesorder = UserOrder::latest();

        if ($request->salesorder_number) {
            $salesorder->where('user_order.order_number', $request->salesorder_number);
        }

        if ($request->sales_pic) {
            $salesorder->where('user_order.sales_id', $request->sales_pic);
        }

        if ($request->customer_name) {
            $salesorder->where('user_order_detail.customer_name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->status_id) {
            $salesorder->where('user_order.status_id', $request->status_id);
        } else {
            $salesorder->where('user_order.status_id', '!=', 1009);
        }

        if ($request->date_order) {
            $salesorder->whereDate('user_order.order_date', $request->date_order);
        }

        // if ($request->product_name) {
        //     $salesorder->orWhere('user_order_item.product_id', $request->product_name);
        // }

        if ($request->target_to_live) {
            $salesorder->whereDate('user_order.target_to_live', $request->target_to_live);
        }

        if (session('role_id') == 1) {
            $salesorder->where('user_order.sales_id', auth()->user()->id);
        }

        $salesorder->join('user_order_detail', 'user_order_detail.order_id', '=', 'user_order.id');
        // $salesorder->join('user_order_item', 'user_order_item.order_id', '=', 'user_order.id');
        // $salesorder->join('site_product', 'site_product.id', '=', 'user_order_item.product_id');
        $salesorder->join('site_status', 'site_status.id', '=', 'user_order.status_id');
        $salesorder->join('user', 'user.id', '=', 'user_order.sales_id');

        $salesorder->select('user.first_name', 'user.last_name', 'user_order.id', 'user_order.order_date', 'user_order.target_to_live', 'user_order.order_number', 'user_order_detail.sales_name', 'user_order_detail.customer_name', 'site_status.status_name', 'site_status.updated_at', 'site_status.created_at');
        $salesorder->orderBy('user_order.target_to_live', 'desc');

        $salesorder->where('user_order.order_section', 'sales order');
        $salesorder->where('user_order.sales_id', '!=', '');

        // omni filter query
        $salesorder->omniFilter();

        $product_group = SiteProductGroup::query()->where('is_hidden', (int)0)->get();
        $incoming = UserOrder::query()->where('order_section', 'sales order')->where('sales_id', null)->where('status_id', '!=', 1009)->omniFilter()->count();
        $distinct_order_item = SiteProduct::query()->where('is_hidden', 0)->get();
        $sales_pic = UserRole::query()->select('user.id', 'user.first_name', 'user.last_name')->whereIn('user_role.role_id', [1, 6])->where('user.is_active', (int)1)->join('user', 'user.id', '=', 'user_role.user_id')->get();
        $site_project = SiteProject::query()->where('status', '=', 'active')->get();
        $site_employee = SiteEmployee::query()->where('status', '=', 'active')->orderBy('name')->get();

        $site_company = SiteCompany::query()->where('parentid', session('company_id'))->get();

        $customer_company = CustomerCompany::query()
            ->join('site_company', 'site_company.id', '=', 'customer_company.company_id')
            ->where('site_company.status_id', '1001')
            ->groupBy('customer_company.company_id')
            ->get();

        $promo = Promo::query()->where('is_active', '1')->get();

        return view('page/salesorder', [
            'product_group' => $product_group,
            'incoming' => $incoming,
            'sales_pic' => $sales_pic,
            'product_filter' => $distinct_order_item,
            'data' => $salesorder->paginate(30)->withQueryString(),
            'site_project' => $site_project,
            'site_employee' => $site_employee,
            'site_company' => $site_company,
            'customer_company' => $customer_company,
            'promo' => $promo,
            'customer' => $customer_company,
        ]);

    }

    public function add_so_corporate(Type $var = null)
    {
        $promo = Promo::query()->where('is_active', '1')->get();
        $site_project = SiteProject::query()->where('status', '=', 'active')->get();
        $site_employee = SiteEmployee::query()->where('status', '=', 'active')->orderBy('name')->get();
        $customer_company = CustomerCompany::query()
            ->join('site_company', 'site_company.id', '=', 'customer_company.company_id')
            ->where('site_company.status_id', '1001')
            ->groupBy('customer_company.company_id')
            ->get();

        return view('page/add_so_corporate', [
            'promo' => $promo,
            'site_project' => $site_project,
            'site_employee' => $site_employee,
            'customer_company' => $customer_company,
        ]);
    }


    public function List_incoming(Request $request)
    {


        $salesorder = UserOrder::latest();

        if ($request->salesorder_number) {
            $salesorder->where('user_order.order_number', $request->salesorder_number);
        }

        if ($request->customer_name) {
            $salesorder->where('user_order_detail.customer_name', $request->customer_name);
        }

        if ($request->status_id) {
            $salesorder->where('user_order.status_id', $request->status_id);
        } else {
            $salesorder->where('user_order.status_id', '!=', 1009);
        }

        if ($request->date_order) {
            $salesorder->whereDate('user_order.order_date', $request->date_order);
        }

        if ($request->product_name) {
            $salesorder->orWhere('user_order_item.product_id', $request->product_name);
        }

        if ($request->target_to_live) {
            $salesorder->whereDate('user_order.target_to_live', $request->target_to_live);
        }

        $salesorder->join('user_order_detail', 'user_order_detail.order_id', '=', 'user_order.id');
        $salesorder->join('user_order_item', 'user_order_item.order_id', '=', 'user_order.id');
        $salesorder->join('site_product', 'site_product.id', '=', 'user_order_item.product_id');
        $salesorder->join('site_status', 'site_status.id', '=', 'user_order.status_id');

        $salesorder->select('user_order.id', 'user_order.order_date', 'user_order.target_to_live', 'user_order.order_number', 'user_order_detail.sales_name', 'user_order_detail.customer_name', 'site_product.product_name', 'site_product.product_plan', 'site_product.product_desc', 'site_status.status_name', 'site_status.updated_at', 'site_status.created_at');
        $salesorder->orderBy('user_order.target_to_live', 'desc');

        $salesorder->where('user_order.order_section', 'order');
        $salesorder->where('user_order.sales_id', '=', null);

        // omni filter query
        $salesorder->omniFilter();

        $product_group = SiteProductGroup::query()->where('is_hidden', (int)0)->get();
        $distinct_order_item = SiteProduct::query()->where('is_hidden', 0)->get();
        $sales_pic = UserRole::query()->select('user.id', 'user.first_name', 'user.last_name')->where('user_role.role_id', (int)1)->where('user.is_active', (int)1)->join('user', 'user.id', '=', 'user_role.user_id')->get();
        $site_project = SiteProject::query()->where('status', '=', 'active')->get();
        $site_employee = SiteEmployee::query()->where('status', '=', 'active')->orderBy('name')->get();

        $site_company = SiteCompany::query()->where('parentid', session('company_id'))->get();

        $customer_company = CustomerCompany::query()
            ->join('site_company', 'site_company.id', '=', 'customer_company.company_id')
            ->where('site_company.status_id', '1001')
            ->groupBy('customer_company.company_id')
            ->get();

        $promo = Promo::query()->where('is_active', '1')->get();

        return view('page/salesorder-incoming', [
            'product_group' => $product_group,
            'sales_pic' => $sales_pic,
            'site_employee' => $site_employee,
            'product_filter' => $distinct_order_item,
            'data' => $salesorder->paginate(30)->withQueryString(),
            'site_project' => $site_project,
            'site_company' => $site_company,
            'customer_company' => $customer_company,
            'promo' => $promo,
            'customer' => $customer_company,
        ]);

    }


    public static function Get_due_target_tolive($order_id, $target_to_live, $status)
    {

        $due = '';

        $date_live = UserSubscription::query()->where('order_id', $order_id)->first();

        if ($date_live) {
            $live = $date_live->complete_date;
        } else {
            $live = "";
        }

        if ($live == '' || $status != 'Completed') {
            $now = Carbon::now()->format('Y-m-d');

            $dues = Carbon::now()->diffInDays(Carbon::parse($target_to_live), true);

            if ($dues != 0) {
                if ($now > $target_to_live) {
                    $due = '<span class="badge bg-azure text-azure-fg">due : + ' . $dues . ' days</span>';
                } else {
                    $due = '<span class="badge bg-azure text-azure-fg">due : - ' . $dues . ' days</span>';
                }
            }
        }

        echo $due;

    }

    public function Detail_spk(Request $request)
    {

        $spk = UserOrderSpk::query()->where('id', (int)$request->spk_id)->first();
        $customer = UserOrder::query()
            ->join('user_order_detail', 'user_order.id', '=', 'user_order_detail.order_id')
            ->join('customer', 'customer.id', '=', 'user_order.customer_id')
            ->where('order_id', (int)$spk->order_id)->first();

        return view('page/salesorder-spk-detail', [
            'order_id' => $request->order_id,
            'spk' => $spk,
            'customer' => $customer,
        ]);

    }

    public function Document_spk(Request $request)
    {

        $now = Carbon::now();

        $customer_id = UserOrder::query()->where('id', (int)$request->order_id)->first()->customer_id;
        $customer = Customer::query()->where('id', (int)$customer_id)->first();

        $latest_document = UserOrderDocument::query()
            ->where('document_type', 'spk')
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($latest_document != null) {
            $document_numbering = $latest_document->id;
        } else {
            $document_numbering = 1;
        }

        return view('page/salesorder-document-spk', [
            'order_id' => $request->order_id,
            'customer' => $customer,
            'document_numbering' => $document_numbering,
            'now_month' => $now->month,
            'now_year' => $now->year,
            'now' => $now,
        ]);

    }

    public function Document_ba(Request $request)
    {

        $now = Carbon::now();

        $customer_id = UserOrder::query()->where('id', (int)$request->order_id)->first()->customer_id;
        $customer = Customer::query()->where('id', (int)$customer_id)->first();

        $latest_document = UserOrderDocument::query()
            ->where('document_type', 'ba')
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($latest_document != null) {
            $document_numbering = $latest_document->id;
        } else {
            $document_numbering = 1;
        }

        return view('page/salesorder-document-ba', [
            'customer' => $customer,
            'document_numbering' => $document_numbering,
            'now_month' => $now->month,
            'now_year' => $now->year,
            'now' => $now->toDateString(),
        ]);

    }


    public function Upload_Document(Request $request)
    {

        $now = Carbon::now();

        if ($request->hasFile('upload')) {

            $iconImageFile = $request->file('upload');
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

            $status = $response->status;

            curl_close($curl);

            if ($status) {

                if ($status == 'success') {

                    $get_document = UserOrderDocument::query()->where('document_number', $iconfilename)->count();

                    if ($get_document == 0) {
                        $add = UserOrderDocument::create([
                            'order_id' => $request->order_id,
                            'document_number' => $iconfilename,
                            'document_type' => $request->document_type,
                            'document_name' => $response->images,
                        ]);
                    } else {
                        $Update = UserOrderDocument::where('order_id', $request->order_id)->update([
                            'document_name' => $response->images,
                        ]);
                    }

                    return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, Document uploaded');

                } else {
                    return redirect('/console/salesorder/detail/' . $request->order_id)->with('failed', 'Failed,' . $response->message);
                }

            } else {

                return redirect('/console/salesorder/detail/' . $request->order_id)->with('failed', 'Failed, upload document');

            }

        } else {
            return redirect('/console/salesorder/detail/' . $request->order_id)->with('failed', 'Failed, Document not Found');
        }

    }

    public function download_documents($attachments)
    {

        return response()->streamDownload(function () use ($attachments) {
            $response = Http::withToken(env('BACKEND_TOKEN'))->withHeaders([
                'accept' => 'application/octet-stream',
            ])->get(env('BACKEND_URL') . '/image/private/get/ums/' . $attachments);
            echo $response->body();
        }, $attachments); // replace with actual name

    }


    public static function Get_ordernumber($orderid)
    {
        $number = UserOrder::query()->where('id', (int)$orderid)->first();
        if ($number != '') {
            $order_number = $number->order_number;
        } else {
            $order_number = $orderid;
        }
        return $order_number;
    }


    public function Detail($order_id)
    {
        $order = UserOrder::query()->where('user_order.id', $order_id)->join('site_status', 'site_status.id', '=', 'user_order.status_id')->first();
        if ($order == null || ($order->reseller_id != session('reseller_id') && session('company_id') != 1)) {
            return redirect('console/salesorder')->with('failed', 'Not Found');
        }

        $order_item_id = UserOrderItem::query()->where('order_id', (int)$order_id)->first()->id;
        $subscription = UserSubscription::query()->where('order_id', (int)$order_id)->first();

        if ($subscription) {
            $subscription_id = $subscription->id;
        } else {
            $subscription_id = '';
        }

        $customer_id = UserOrder::query()->where('id', (int)$order_id)->first()->customer_id;
        $customer_number = Customer::query()->where('id', (int)$customer_id)->first()->customer_number;

        $order_detail = UserOrderDetail::query()->where('order_id', $order_id)->first();
        // $order_item = UserOrderItem::query()->where('user_order_item.order_id', $order_id)->join('site_product', 'site_product.id', '=', 'user_order_item.product_id')->get();
        // $order_field = UserOrderField::query()->where('order_item_id', $order_item_id)->get();

        $order_item = UserOrderItem::query()
            ->leftJoin('site_product', 'site_product.id', '=', 'user_order_item.product_id')
            ->join('user_order_field', 'user_order_item.id', '=', 'user_order_field.order_item_id')
            ->select('user_order_item.id', 'user_order_item.order_id', 'user_order_item.unit_price', 'user_order_item.billing_cycle', 'user_order_item.quantity', 'user_order_item.promo', 'user_order_field.field', 'user_order_field.field_type', 'user_order_field.value', 'site_product.product_name', 'site_product.product_plan')
            ->where('user_order_item.order_id', $order_id)
            ->get()
            ->groupBy('id')
            ->map(function ($items, $orderId) {
                return [
                    'id' => $orderId,
                    'order_id' => $items->first()->order_id,
                    'unit_price' => $items->first()->unit_price,
                    'billing_cycle' => $items->first()->billing_cycle,
                    'quantity' => $items->first()->quantity,
                    'promo' => $items->first()->promo,
                    'product_name' => $items->first()->product_name,
                    'product_plan' => $items->first()->product_plan,
                    'fields' => $items->map(
                        fn($item) => ['field' => $item->field,
                        'value' => $item->value,
                        'field_type' => $item->field_type])->toArray()
                ];
            })
            ->values();
        // print_r($order_item);
        // die();

        $subscription = UserSubscription::query()->select(
            "user_subscription.id",
            "user_subscription.subscription_number",
            "user_subscription.billing_account",
            "user_subscription.subscription_date",
            "site_product.product_name",
            "site_product.product_plan",
            "site_product.product_desc",
            "user_subscription.billingcycle",
            "user_subscription.amount",
            "user_subscription.complete_date",
            "subscription_status.status_name",
            "site_product.product_scope"
        )
            ->where('user_subscription.order_id', $order_id)
            ->join('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id')
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->get();
                        // print_r($subscription);die();


        $subscription_field = UserSubscriptionField::query()->where('subscription_id', $subscription_id)->get();

        if ($order->sales_id != null) {
            $sales_pic = User::query()->where('id', (int)$order->sales_id)->first()->first_name;
        } else {
            $sales_pic = "-";
        }

        $reference = "-";
        if ($order->reference_id != null) {
            $reference = SiteEmployee::query()->where('id', (int)$order->reference_id)->first()->name;
        }

        $sales_activity = LogActivity::query()
            ->where('module', 'salesorder')
            ->where('module_id', (int)$order_id)
            ->orderByDesc('created_at')
            ->get();

        $subscription_activity = LogActivity::query()
            ->where('module', 'subscription')
            ->where('module_id', (int)$subscription_id)
            ->orderByDesc('created_at')
            ->get();

        $invoices = UserInvoices::query()
            ->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id')
            ->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
            ->where('user_invoices_item.order_id', (int)$order_id)
            ->get()->unique('invoice_id');

        $invoices_item = '';

        $finance_activity = '';

        if (!empty($invoices)) {
            foreach ($invoices as $inv) {

                $invoices_item = UserInvoicesitem::query()->where('invoice_id', (int)$inv->id)->get();

                $finance_activity = LogActivity::query()
                    ->where('module', 'invoices')
                    ->where('module_id', (int)$inv->id)
                    ->orderByDesc('created_at')
                    ->get();

            }
        }

        $order_project = OrderProject::query()->where('order_id', (int)$order_id)->first();
        $site_project = SiteProject::query()->where('status', '=', 'active')->get();

        $data_spk = UserOrderSpk::query()->where('order_id', (int)$order_id)->get();
        $document_spk = UserOrderDocument::query()->where('order_id', (int)$order_id)->where('document_type', 'spk')->get();
        $document_ba = UserOrderDocument::query()->where('order_id', (int)$order_id)->where('document_type', 'ba')->get();

        return view('page/salesorder-detail', [
            'order' => $order,
            'order_detail' => $order_detail,
            'order_item' => $order_item,
            // 'order_field' => $order_field,
            'subscription' => $subscription,
            'subscription_id' => $subscription_id,
            'subscription_field' => $subscription_field,
            'sales_activity' => $sales_activity,
            'subscription_activity' => $subscription_activity,
            'finance_activity' => $finance_activity,
            'customer_number' => $customer_number,
            'customer_id' => $customer_id,
            'invoices' => $invoices,
            'invoices_item' => $invoices_item,
            'sales_pic' => $sales_pic,
            'reference' => $reference,
            'order_project' => $order_project ? $order_project->project_id : "",
            'site_project' => $site_project,
            'data_spk' => $data_spk,
            'document_spk' => $document_spk,
            'document_ba' => $document_ba,
        ]);

    }


    public function Take_salesorder($order_id)
    {


        $Update = UserOrder::where('id', $order_id)->update([
            'sales_id' => auth()->user()->id,
            'order_section' => 'sales order',
        ]);

        // Log Activity
        // $LOG_ACTIVITY = LogActivity::create([
        //     'module' => 'order',
        //     'module_id' => $order_id,
        //     'log_label' => 'Sales Take Sales Order',
        //     'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been take Sales Order to follow up with number order :' . $order_id,
        //     'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
        //     'log_user_id' => auth()->user()->id,
        //     'log_user_ip' => request()->ip(),
        // ]);

        return redirect('/console/salesorder/detail/' . $order_id)->with('success', 'Success, Take Sales Order to follow up');

    }



    public function Update_status(Request $request)
    {

        $Update = UserOrder::where('id', $request->order_id)->update([
            'status_id' => $request->status_id,
        ]);

        $status_name = SiteStatus::query()->where('id', (int)$request->status_id)->first()->status_name;

        // if status cancel
        if ($request->status_id == 1008) {
            $subscribes = UserSubscription::query()->where('order_id', (int)$request->order_id)->get();
            foreach ($subscribes as $sub) {

                $Update = UserSubscription::where('id', $sub->id)->update([
                    'status_id' => 1008,
                    'cancel_date' => now(),
                ]);
            }
        }

        // if status deleted
        if ($request->status_id == 1009) {
            $subscribes = UserSubscription::query()->where('order_id', (int)$request->order_id)->get();
            foreach ($subscribes as $sub) {

                $Update = UserSubscription::where('id', $sub->id)->update([
                    'status_id' => 1009,
                    'cancel_date' => now(),
                ]);
            }
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Update Status Sales Order',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' telah merubah status pengajuan menjadi :' . $status_name,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, Salesorder status has been changed');

    }



    public function Statistic_perday(Request $request)
    {

        $now = Carbon::now();

        $start = "";
        $end = "";

        $filter = 0;

        if ($request->filter_day_start) {

            $start = $request->filter_day_start;
            $end = $request->filter_day_end;

            $total_sales_order = UserOrder::query()->where('order_section', 'sales order')->whereBetween('created_at', [$start, $end])->omniFilter()->count();
            $total_cancel = UserOrder::query()->where('status_id', '1008')->where('order_section', 'sales order')->whereBetween('created_at', [$start, $end])->omniFilter()->count();
            $total_pending = UserOrder::query()->where('status_id', '1005')->where('order_section', 'sales order')->whereBetween('created_at', [$start, $end])->omniFilter()->count();
            $total_on_progress = UserOrder::query()->whereNotIn('status_id', [1005, 1035, 1008])->where('order_section', 'sales order')->whereBetween('created_at', [$start, $end])->omniFilter()->count();
            $total_complete = UserOrder::query()->where('status_id', '1035')->where('order_section', 'sales order')->whereBetween('created_at', [$start, $end])->omniFilter()->count();
            $total_billing_account = UserSubscription::query()->where('status_id', '1001')->whereBetween('complete_date', [$start, $end])->omniFilter()->count();

            $filter = 1;

        } else {
            $total_sales_order = UserOrder::query()->whereDate('created_at', $now)->where('order_section', 'sales order')->omniFilter()->count();
            $total_cancel = UserOrder::query()->where('status_id', '1008')->where('order_section', 'sales order')->whereDate('created_at', $now)->omniFilter()->count();
            $total_pending = UserOrder::query()->where('status_id', '1005')->where('order_section', 'sales order')->whereDate('created_at', $now)->omniFilter()->count();
            $total_on_progress = UserOrder::query()->where('order_section', 'sales order')->whereNotIn('status_id', [1005, 1035, 1008])->whereDate('created_at', $now)->omniFilter()->count();
            $total_complete = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '1035')->whereDate('created_at', $now)->omniFilter()->count();
            $total_billing_account = UserSubscription::query()->where('status_id', '1001')->whereDate('complete_date', $now)->omniFilter()->count();
        }



        $sales = User::query()->where('user.is_active', 1)
            ->where('user_role.role_id', 1)
            ->where('user_company.company_id', session('company_id'))
            ->join('user_role', 'user_role.user_id', '=', 'user.id')
            ->join('user_company', 'user_company.user_id', '=', 'user.id')
            ->select('user.id', 'user.first_name', 'user.last_name')
            ->get();

        $total_per_person = [];

        foreach ($sales as $saless) {

            if ($filter == 0) {
                $total = self::Person_total_order($saless->id, $now);
            }

            if ($filter == 1) {
                $total = self::Person_total_order_filter($saless->id, $start, $end);
            }

            $total_per_person[] = [
                'user_id' => $saless->id,
                'person' => $saless->first_name . ' ' . $saless->last_name,
                'total' => $total,
            ];

        }

        return view('page/statistic/salesorder-persales', [
            'total_sales_order' => $total_sales_order,
            'total_cancel' => $total_cancel,
            'total_pending' => $total_pending,
            'total_on_progress' => $total_on_progress,
            'total_complete' => $total_complete,
            'total_billing_account' => $total_billing_account,
            'statistic_sales' => json_encode($total_per_person),
            'now' => $now,
            'start' => $start,
            'end' => $end,
        ]);

    }



    public function Statistic_permonth(Request $request)
    {

        $now = Carbon::now();

        if ($request->filter_month) {
            $month = $request->filter_month;
        } else {

            $month = $now->month;
        }

        if ($request->filter_year) {
            $year = $request->filter_year;
        } else {
            $year = $now->year;
        }

        if ($request->filter_day) {
            $now = $request->filter_day;
        }

        $total_sales_order = UserOrder::query()->whereMonth('created_at', $month)->where('order_section', 'sales order')->whereYear('created_at', $year)->omniFilter()->count();
        $total_cancel = UserOrder::query()->where('status_id', '1008')->where('order_section', 'sales order')->whereMonth('created_at', $month)->whereYear('created_at', $year)->omniFilter()->count();
        $total_pending = UserOrder::query()->where('status_id', '1005')->where('order_section', 'sales order')->whereMonth('created_at', $month)->whereYear('created_at', $year)->omniFilter()->count();
        $total_on_progress = UserOrder::query()->where('order_section', 'sales order')->whereNotIn('status_id', [1005, 1035, 1008])->whereMonth('created_at', $month)->whereYear('created_at', $year)->omniFilter()->count();
        $total_complete = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '1035')->whereMonth('created_at', $month)->whereYear('created_at', $year)->omniFilter()->count();
        $total_billing_account = UserSubscription::query()->where('status_id', '1001')->whereMonth('complete_date', $month)->whereYear('complete_date', $year)->omniFilter()->count();

        $statistic_perday = self::Getperday_salesorder($month, $year);

        $sales = User::query()->where('user.is_active', 1)
            ->where('user_role.role_id', 1)
            ->join('user_role', 'user_role.user_id', '=', 'user.id')
            ->select('user.id', 'user.first_name', 'user.last_name')
            ->get();

        $total_per_person = [];

        foreach ($sales as $saless) {

            $total_per_person[$saless->id] = [
                'user_id' => $saless->id,
                'person' => $saless->first_name . ' ' . $saless->last_name,
                'total' => self::Person_total_order($saless->id, $now),
            ];

        }


        return view('page/salesorder-statistic', [
            'total_sales_order' => $total_sales_order,
            'total_cancel' => $total_cancel,
            'total_pending' => $total_pending,
            'total_on_progress' => $total_on_progress,
            'total_complete' => $total_complete,
            'total_billing_account' => $total_billing_account,
            'statistic_perday' => $statistic_perday,
            'statistic_sales' => json_encode($total_per_person),
            'year' => $year,
            'month' => self::convert_month_name($month),
        ]);

    }


    function Person_total_order($pic_sales, $date)
    {
        return UserOrder::query()->where('sales_id', $pic_sales)->whereDate('created_at', $date)->count();
    }

    function Person_total_order_filter($pic_sales, $start, $end)
    {
        return UserOrder::query()->where('sales_id', $pic_sales)->whereBetween('created_at', [$start, $end])->count();
    }


    public function Statistic_peryear(Request $request)
    {


        if ($request->filter_year) {
            $year = $request->filter_year;
        } else {
            $now = Carbon::now();
            $year = $now->year;
        }

        $total_sales_order = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '!=', '1009')->whereYear('created_at', $year)->omniFilter()->count();
        $total_cancel = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '1008')->whereYear('created_at', $year)->omniFilter()->count();
        $total_pending = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '1005')->whereYear('created_at', $year)->omniFilter()->count();
        $total_on_progress = UserOrder::query()->where('order_section', 'sales order')->whereNotIn('status_id', [1005, 1035, 1008, 1009])->whereYear('created_at', $year)->omniFilter()->count();
        $total_complete = UserOrder::query()->where('order_section', 'sales order')->where('status_id', '1035')->whereYear('created_at', $year)->omniFilter()->count();
        $total_billing_account = UserSubscription::query()->where('status_id', '1001')->whereYear('complete_date', $year)->omniFilter()->count();

        $statistic_perday = self::Getpermonth_salesorder($year);

        return view('page/salesorder-statistic-permonth', [
            'total_sales_order' => $total_sales_order,
            'total_cancel' => $total_cancel,
            'total_pending' => $total_pending,
            'total_on_progress' => $total_on_progress,
            'total_complete' => $total_complete,
            'total_billing_account' => $total_billing_account,
            'statistic_perday' => $statistic_perday,
            'year' => $year,
        ]);

    }


    public function Getperday_salesorder($date, $year)
    {

        $begin = Carbon::create()->year($year)->month($date)->startOfMonth()->toDateString();
        $end = Carbon::create()->year($year)->month($date)->endOfMonth()->toDateString();

        $dateBegin = Carbon::createFromFormat('Y-m-d', $begin);
        $dateEnd = Carbon::createFromFormat('Y-m-d', $end);

        for ($i = $dateBegin; $i <= $dateEnd; $i->addDays(1)) {
            $days[] = array('days' => $i->format("d-M"), 'count' => self::perdays($i->format("Y-m-d")));
        }

        return json_encode($days);

    }


    public function Getpermonth_salesorder($year)
    {

        $month[] = array('month' => 'Januari', 'count' => self::permonth('01', $year));
        $month[] = array('month' => 'Februari', 'count' => self::permonth('02', $year));
        $month[] = array('month' => 'Maret', 'count' => self::permonth('03', $year));
        $month[] = array('month' => 'April', 'count' => self::permonth('04', $year));
        $month[] = array('month' => 'Mei', 'count' => self::permonth('05', $year));
        $month[] = array('month' => 'Juni', 'count' => self::permonth('06', $year));
        $month[] = array('month' => 'Juli', 'count' => self::permonth('07', $year));
        $month[] = array('month' => 'Agustus', 'count' => self::permonth('08', $year));
        $month[] = array('month' => 'September', 'count' => self::permonth('09', $year));
        $month[] = array('month' => 'Oktober', 'count' => self::permonth('10', $year));
        $month[] = array('month' => 'November', 'count' => self::permonth('11', $year));
        $month[] = array('month' => 'Desember', 'count' => self::permonth('12', $year));

        return json_encode($month);

    }


    function perdays($date)
    {
        return $query = UserOrder::query()->where('order_section', 'sales order')->whereDate('created_at', $date)->omniFilter()->count();
    }

    function permonth($month, $year)
    {
        return UserOrder::query()->where('order_section', 'sales order')->whereMonth('created_at', $month)->whereYear('created_at', $year)->omniFilter()->count();
    }


    public function Update_progress(Request $request)
    {

        $Update = UserOrder::where('id', $request->order_id)->update([
            'order_progress' => $request->order_progress,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Update Activity Info',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been changed new activity info to :' . $request->order_progress,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, Update information activity related salesorder');

    }


    public function Update_progress_order(Request $request)
    {

        $Update = UserOrder::where('id', $request->order_id)->update([
            'order_progress' => $request->order_progress,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'order',
            'module_id' => $request->order_id,
            'log_label' => 'Update Activity Info',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been changed new activity info to :' . $request->order_progress,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/order/detail/' . $request->order_id)->with('success', 'Success, Update information activity related order');

    }


    public function Create(Request $request)
    {

        $AUTHOR_ID = auth()->user()->id;
        $AUTHOR_COMPANY = 'PT. Uninet Media Sakti';
        $PREFIX = "UMS";

        $ORDER_NUMBER = IdGenerator::generate(['table' => 'user_order', 'field' => 'order_number', 'length' => 10, 'prefix' => $PREFIX]);

        // if personal order
        if ($request->customer_type == 'personal') {

            $pass = Str::random(10);

            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/customer/register', [
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_telp' => $request->customer_phone,
                    'customer_address' => $request["nama-jalan"] . ' RT ' . $request->rt . ' RW ' . $request->rw . ' Kel. ' . $request->kelurahan . ' Kec. ' . $request->kecamatan . ' Kab./Kota ' . $request->kabupaten,
                    'customer_company' => "",
                    'customer_password' => $pass,
                    'fromPipeline' => true,
                ]);

            $CUSTOMER_EXIST = Customer::query()->where('customer_email', $request->customer_email)->count();

            if ($CUSTOMER_EXIST == 0) {

                $CUSTOMER = Customer::create([
                    'reseller_id' => session('reseller_id'),
                    'customer_number' => '',
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_telp' => $request->customer_phone,
                    'customer_password' => $pass,
                    'is_verified' => 1,
                    'is_active' => 1,
                    'created_by' => $AUTHOR_ID,
                    'modified_by' => $AUTHOR_ID,
                ]);

            } else {
                $CUSTOMER = Customer::query()->where('customer_email', $request->customer_email)->orWhere('customer_name', $request->customer_name)->first();
            }
        
        // if corporate order
        } else {

            $CUSTOMER = Customer::query()->where('id', $request->personal_in_charge)->first();

        }

        if (!$CUSTOMER) {
            return redirect()->back()->with('failed', 'Gagal, data customer tidak ditemukan.');
        }

        $PRODUCT = SiteProduct::query()->where('id', (int)$request->product_plan)->first();
        $PRODUCT_GROUP = SiteProductGroup::query()->where('id', (int)$PRODUCT->product_group)->first();
        $BILLING_CYCLE = 'Monthly';

        // Resolve billing cycle based on product_id and price from site_product_price
        // Use numeric-safe price parsing to match DB value
        $priceValue = is_numeric($request->product_price)
            ? (float)$request->product_price
            : (float)preg_replace('/[^\d.]/', '', (string)$request->product_price);

        $resolvedBillingCycle = SiteProductPrice::query()
            ->where('product_id', (int)$PRODUCT->id)
            ->where('price', $priceValue)
            ->value('billing_cycle');

        // If found, override the default; otherwise keep existing value
        if (!empty($resolvedBillingCycle)) {
            $BILLING_CYCLE = $resolvedBillingCycle;
        }

        //Apabila order membership
        if ($PRODUCT->product_type == 'membership') {

            //Cek membership data
            $exist_membership = CustomerMembership::query()->where('customer_id', (int)$CUSTOMER->id)->count();

            if ($exist_membership == 0) {

                $referral = strtoupper(Str::random(10));

                // Mapping customer ke table membership
                $CUSTOMER_MEMBER = CustomerMembership::create([
                    'customer_id' => $CUSTOMER->id,
                    'product_order' => $PRODUCT->id,
                    'referral_code' => $referral,
                    'level' => 1,
                    'is_active' => 0,
                    'points' => 0,
                ]);

            } else {

                return redirect('/console/salesorder')->with('failed', 'Gagal, Customer sudah memiliki layanan membership sebelumnya');

            }

        }

        if ($request->promo == '3 Bulan disc 30%') {
            $BILLING_CYCLE = 'Monthly';
        }

        

        if ($request->network == 'Available') {
            $target_live = Carbon::now()->addDays('3')->format('Y-m-d H:i:s');
        } else {
            $target_live = Carbon::now()->addDays('14')->format('Y-m-d H:i:s');
        }

        $SALESORDER = UserOrder::create([
            'reseller_id' => session('reseller_id'),
            'order_number' => $ORDER_NUMBER,
            'order_section' => 'sales order',
            'customer_id' => $CUSTOMER->id,
            'sales_id' => $AUTHOR_ID,
            'reference_id' => $request->reference_id,
            'order_date' => $request->date_order,
            'target_to_live' => $target_live,
            'sub_total' => $request->product_price,
            'total' => $request->product_price,
            'order_notes' => $request->order_notes,
            'is_publish' => 1,
            'is_approve' => 1,
            'is_rejected' => 0,
            'status_id' => 1005,
        ]);

        $AUTHOR = User::query()->where('id', (int)$AUTHOR_ID)->first();

        $SALESORDER_DETAIL = UserOrderDetail::create([
            'order_id' => $SALESORDER->id,
            'customer_name' => $CUSTOMER->customer_name,
            'customer_phone' => $CUSTOMER->customer_telp,
            'customer_email' => $CUSTOMER->customer_email,
            'sales_name' => $AUTHOR->first_name . ' ' . $AUTHOR->last_name,
            'sales_company' => $AUTHOR_COMPANY,
            'sales_phone' => $AUTHOR->phone,
            'sales_email' => $AUTHOR->user_email
        ]);

        $SALESORDER_ITEM = UserOrderItem::create([
            'order_id' => $SALESORDER->id,
            'product_id' => $PRODUCT->id,
            'promo' => $request->promo,
            'billing_cycle' => $BILLING_CYCLE,
            'unit_price' => $request->product_price,
            'quantity' => 1,
        ]);

        $SUBSCRIPTION = UserSubscription::create([
            'reseller_id' => session('reseller_id'),
            'customer_id' => $CUSTOMER->id,
            'order_id' => $SALESORDER->id,
            'subscription_date' => $request->date_order,
            'product_id' => $PRODUCT->id,
            'billingcycle' => $BILLING_CYCLE,
            'amount' => $request->product_price,
            'is_publish' => 1,
            'status_id' => 1005,
        ]);

        $PRODUCT_FIELD = SiteProductField::query()->where('product_id', (int)$request->product_plan)->get();

        foreach ($PRODUCT_FIELD as $row) {

            $fieldname = $row->field_slug;

            $SUBSCRIPTION_FIELD = UserSubscriptionField::create([
                'subscription_id' => $SUBSCRIPTION->id,
                'field_type' => $row->field_type,
                'field' => $fieldname,
                'value' => $request->$fieldname,
            ]);

            $SALESORDER_FIELD = UserOrderField::create([
                'field_type' => $row->field_type,
                'product_id' => $request->product_plan,
                'subscription_id' => $SUBSCRIPTION->id,
                'order_item_id' => $SALESORDER_ITEM->id,
                'field' => $fieldname,
                'value' => $request->$fieldname,
            ]);
        }

        if ($request->project_id) {
            $op = OrderProject::create([
                'order_id' => $SALESORDER->id,
                'project_id' => $request->project_id,
            ]);
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $SALESORDER->id,
            'log_label' => 'Create Sales Order',
            'log_entry' => '' . $AUTHOR->first_name . ' ' . $AUTHOR->last_name . ' has been created new Sales Order Number :' . $ORDER_NUMBER,
            'log_user_name' => $AUTHOR->first_name . ' ' . $AUTHOR->last_name,
            'log_user_id' => $AUTHOR_ID,
            'log_user_ip' => request()->ip(),
        ]);

        if ($request->pipeline_id) {

            $Update = Pipeline::where('id', $request->pipeline_id)->update([
                'is_hidden' => 1,
            ]);

        }

        return redirect('/console/salesorder')->with('success', 'Success Create new sales order');

    }

    public function Create_corporate(Request $request)
    {
        // return json_encode(["productGroup" => $request['item'][0]['productGroup'], "company_id" => $request["form"]["company_id"]]);

        $AUTHOR_ID = auth()->user()->id;
        $AUTHOR_COMPANY = 'PT. Uninet Media Sakti';
        $PREFIX = "UMS";

        $ORDER_NUMBER = IdGenerator::generate(['table' => 'user_order', 'field' => 'order_number', 'length' => 10, 'prefix' => $PREFIX]);
        $CUSTOMER = Customer::query()->where('id', $request["form"]["personal_in_charge"])->first();
        $PRODUCT = SiteProduct::query()->where('id', (int)$request->product_id)->first();
        // $PRODUCT_GROUP = SiteProductGroup::query()->where('id', (int) $PRODUCT->product_group)->first();

        $target_live = Carbon::now()->addDays('14')->format('Y-m-d H:i:s');

        $total = 0;
        for ($count = 0; $count < collect($request['item'])->count(); $count++) {
            $total += $request['item'][$count]["price"] * 1;
        }

        $SALESORDER = UserOrder::create([
            'reseller_id' => session('reseller_id'),
            'order_number' => $ORDER_NUMBER,
            'order_section' => 'sales order',
            'order_date' => $request["form"]["date_order"],
            'customer_id' => $CUSTOMER->id,
            'sales_id' => $AUTHOR_ID,
            'reference_id' => $request["form"]['reference_id'],
            'order_date' => $request["form"]['date_order'],
            'target_to_live' => $target_live,
            'sub_total' => $total,
            'total' => $total,
            'order_notes' => $request["form"]['order_notes'],
            'is_publish' => 1,
            'is_approve' => 1,
            'is_rejected' => 0,
            'status_id' => 1005,
        ]);

        $AUTHOR = User::query()->where('id', (int)$AUTHOR_ID)->first();

        $SALESORDER_DETAIL = UserOrderDetail::create([
            'order_id' => $SALESORDER->id,
            'customer_name' => $CUSTOMER->customer_name,
            'customer_phone' => $CUSTOMER->customer_telp,
            'customer_email' => $CUSTOMER->customer_email,
            'sales_name' => $AUTHOR->first_name . ' ' . $AUTHOR->last_name,
            'sales_company' => $AUTHOR_COMPANY,
            'sales_phone' => $AUTHOR->phone,
            'sales_email' => $AUTHOR->user_email
        ]);

        $INVOICES = UserInvoices::create([
            'reseller_id' => session('reseller_id'),
            'invoice_type' => 'register',
            'customer_id' => $CUSTOMER->id,
            'order_id' => $SALESORDER->id,
            'invoice_date' => Carbon::now(),
            'invoice_duedate' => Carbon::now()->addDays(9),
            'payment_method' => 'Bank Transfer',
            'is_publish' => 0,
            'status_id' => 1037,
        ]);

        $subtotal = 0;
        for ($count = 0; $count < collect($request['item'])->count(); $count++) {
            $SALESORDER_ITEM = UserOrderItem::create([
                'order_id' => $SALESORDER->id,
                'product_id' => $request['item'][$count]["product"],
                'billing_cycle' => $request['item'][$count]["billingCycle"],
                'unit_price' => $request['item'][$count]["price"],
                'quantity' => 1,
            ]);

            $SUBSCRIPTION = UserSubscription::create([
                'reseller_id' => session('reseller_id'),
                'customer_id' => $CUSTOMER->id,
                'order_id' => $SALESORDER->id,
                'subscription_date' => $request["form"]["date_order"],
                'product_id' => $request['item'][$count]["product"],
                'billingcycle' => $request['item'][$count]["billingCycle"],
                'amount' => $request['item'][$count]["price"],
                'is_publish' => 1,
                'status_id' => 1005,
            ]);

            foreach ($request['item'][$count]["fieldList"] as $row) {
                $SUBSCRIPTION_FIELD = UserSubscriptionField::create([
                    'subscription_id' => $SUBSCRIPTION->id,
                    'field_type' => $row["field_type"],
                    'field' => $row["field_slug"],
                    'value' => $row["description"],
                ]);

                $SALESORDER_FIELD = UserOrderField::create([
                    'field_type' => $row["field_type"],
                    'product_id' => $request['item'][$count]["product"],
                    'subscription_id' => $SUBSCRIPTION->id,
                    'order_item_id' => $SALESORDER_ITEM->id,
                    'field' => $row["field_slug"],
                    'value' => $row["description"],
                ]);
            }

            $INVOICES_ITEM = UserInvoicesitem::create([
                'order_id' => $SALESORDER->id,
                'invoice_id' => $INVOICES->id,
                'product_id' => $request['item'][$count]["product"],
                'item_name' => "Setup Fee",
                'item_description' => $request['item'][$count]["productNameLabel"],
                'item_type' => "ISP",
                'payment_method' => 'Bank Transfer',
                'tax' => 0,
                'quantity' => 1,
                'amount' => $request['item'][$count]["setupFee"],
            ]);

            $subtotal = $subtotal + $request['item'][$count]["setupFee"];
        }

        $tax = 11;
        $price_tax = ($subtotal * $tax) / 100;
        $total = $subtotal + $price_tax;

        $update_invoices = UserInvoices::where('id', $INVOICES->id)->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);

        if ($request["form"]["project_id"]) {
            $op = OrderProject::create([
                'order_id' => $SALESORDER->id,
                'project_id' => $request["form"]["project_id"],
            ]);
        }


        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $SALESORDER->id,
            'log_label' => 'Create Sales Order Corporate',
            'log_entry' => '' . $AUTHOR->first_name . ' ' . $AUTHOR->last_name . ' has been created new Sales Order Corporate Number :' . $ORDER_NUMBER,
            'log_user_name' => $AUTHOR->first_name . ' ' . $AUTHOR->last_name,
            'log_user_id' => $AUTHOR_ID,
            'log_user_ip' => request()->ip(),
        ]);
        return json_encode(["productGroup" => $request['item'][0]['productGroup'], "company_id" => $request["form"]["company_id"]]);

        return redirect()->back()->with('success', 'Success Create new sales order corporate');

    }

    public function random_strings($length_of_string)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public function set_target_tolive(Request $request)
    {

        if ($request->network == 'Available') {
            $target_live = Carbon::now()->addDays('3')->format('Y-m-d H:i:s');
        } else {
            $target_live = Carbon::now()->addDays('14')->format('Y-m-d H:i:s');
        }

        $Update = UserOrder::where('id', $request->order_id)->update([
            'target_to_live' => $request->target_live,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Set Delivery Target',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set delivery target to ' . $request->target_live . ' with salesorder id :' . $request->order_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success update delivery target');

    }

    public function get_order_plan(Request $request)
    {

        $get = UserOrderItem::query()->where('product_name', $request->product_name)->select('product_plan')->distinct()->get();

        return $get;
    }


    public function Test(Request $request)
    {

        $invoices_items[0] = [
            "item_name" => "Setup Fee",
            "item_amount" => "250.000"
        ];

        $invoices_items[1] = [
            "item_name" => "Uninet Lite - 30 Mbps ( 2024/03/08 - 2024/03/25 )",
            "item_amount" => "123.000"
        ];

        $invoices_items[2] = [
            "item_name" => "Uninet Lite - 30 Mbps ( 2024/04/26 - 2024/05/25 ) - PROMO FREE 1 BULAN",
            "item_amount" => "250.000"
        ];

        $invoices_items[3] = [
            "item_name" => "Promo Free 1 Bulan + Setup",
            "item_amount" => "500.000"
        ];


        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/email/send', [
                'action' => 'Terbit Tagihan',
                'send_to' => 'fajarizaf@gmail.com',
                'name' => 'Fajar Riza Fauzi',
                'inv_number' => 'INV-2383434',
                'inv_due' => '12 November 2024',
                'inv_date' => '9 November 2024',
                'invoice_item' => $invoices_items,
                'subtotal' => '123.000',
                'tax' => '11',
                'total' => '144.000',

            ]);

        dd($response->object());

    }


    public function convert_month_name($month)
    {

        switch ($month) {
            case '01':
                $month_name = 'Januari';
                break;
            case '02':
                $month_name = 'Februari';
                break;
            case '03':
                $month_name = 'Maret';
                break;
            case '04':
                $month_name = 'April';
                break;
            case '05':
                $month_name = 'Mei';
                break;
            case '06':
                $month_name = 'Juni';
                break;
            case '07':
                $month_name = 'Juli';
                break;
            case '08':
                $month_name = 'Agustus';
                break;
            case '09':
                $month_name = 'September';
                break;
            case '10':
                $month_name = 'Oktober';
                break;
            case '11':
                $month_name = 'November';
                break;
            case '12':
                $month_name = 'Desember';
                break;
            default:
                # code...
                break;
        }

        return $month_name;
    }


    public function Update_project(Request $request)
    {
        $count = OrderProject::query()->where('order_id', $request->order_id)->count();
        if ($count > 0) {
            $Update = OrderProject::where('order_id', $request->order_id)->update([
                'order_id' => $request->order_id,
                'project_id' => $request->project_id,
            ]);
        } else {
            $Create = OrderProject::create([
                'order_id' => $request->order_id,
                'project_id' => $request->project_id,
            ]);
        }

        $project_name = SiteProject::query()->where('id', (int)$request->project_id)->first()->project_name;

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Update Project Sales Order',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' telah merubah project sales order menjadi :' . $project_name,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, Sales order Project has been changed');
    }

    public function List_commission(Request $request)
    {
    
        // (select subtotal from user_invoices where id=user_invoices_item.invoice_id order by invoice_datepaid desc limit 1) as
        // COUNT(user_invoices_item.order_id) AS jml
        // concat(product_name," ", product_plan, " ", "(", product_type, ")") as prod
        $invoices = UserOrder::query();
        $invoices->selectRaw('DATE(invoice_datepaid) as invoice_datepaid, user_order.id, product_name, product_plan, product_type, customer_number, user_order_detail.customer_name, user_order.total, COUNT(user_invoices_item.order_id) AS jml, site_employee.name, sales_name, payment_status');
        $invoices->join('user_invoices_item', 'user_order.id', '=', 'user_invoices_item.order_id');
        $invoices->join('user_invoices', 'user_invoices.id', '=', 'user_invoices_item.invoice_id');
        $invoices->leftJoin('user_order_detail', 'user_order_detail.order_id', '=', 'user_order.id');
        $invoices->leftJoin('user_order_item', 'user_order_item.order_id', '=', 'user_order.id');
        $invoices->leftJoin('site_product', 'user_order_item.product_id', '=', 'site_product.id');
        $invoices->leftJoin('customer', 'customer.id', '=', 'user_order.customer_id');
        $invoices->leftJoin('site_employee', 'site_employee.id', '=', 'user_order.reference_id');
        $invoices->where('user_invoices.status_id', '=', 1036);
        // $invoices->groupBy('user_order.id', 'prod', 'customer_number', 'user_order_detail.customer_name', 'user_order.total', 'site_employee.name', 'sales_name', 'payment_status');
        $invoices->groupByRaw('user_order.id');
        $invoices->orderByDesc('invoice_datepaid');

        if ($request->ready == "yes") {
            $invoices->havingRaw('jml > ?', [2]);
        } else if ($request->ready == "no") {
            $invoices->havingRaw('jml <= ?', [2]);
        }
        if ($request->payment_status) {
            $invoices->where('payment_status', '=', $request->payment_status);
        }
        if ($request->sales_name) {
            $invoices->where('sales_name', 'like', '%' . $request->sales_name . '%');
        }
        if ($request->datepaid) {
            $date = explode("-", $request->datepaid);
            $invoices->whereYear('invoice_datepaid', $date[0]);
            $invoices->whereMonth('invoice_datepaid', $date[1]);
        }

        $invoices->omniFilter();
        $invoices->distinct()->get();

        return view('page/commission', [
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

    }

    public function set_payment_status(Request $request)
    {
        $Update = UserOrder::where('id', $request->order_id)->update([
            'payment_status' => $request->p_status,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Update Payment Status Comission',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set : ' . $request->p_status . ' with order_id : ' . $request->order_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }

    public function create_spk(Request $request)
    {
        $add = UserOrderSpk::create([
            'order_id' => $request->order_id,
            'spk_type' => $request->type,
            'spk_number' => $request->spk_number,
            'spk_date' => $request->spk_date,
            'spk_to' => $request->spk_to,
            'spk_cc' => $request->spk_cc,
            'cust_bill_id' => $request->cust_bill_id,
            'subject' => $request->subject,
            'execution_date' => $request->execution_date,
            'working_list' => $request->working_list,
            'upgrade_date' => $request->upgrade_date,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Create SPK',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' create SPK ',
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, SPK created');

    }

    public function Upload_Signature(Request $request)
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        // Ambil Base64 dari request
        $signatureData = $request->input('signature');

        // Konversi Base64 menjadi file
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));

        // Simpan file di storage Laravel
        $fileName = 'signature_' . time() . '.png';
        $filePath = 'signatures/' . $fileName;
        // Storage::put($filePath, $imageData);

        // Kirim file ke Node.js
        $nodeResponse = Http::attach(
            'upload',              // Nama field
            $imageData,          // Data binary
            $fileName            // Nama file
        )->post(env('BACKEND_URL') . '/upload/image', [
            'type' => 'ums',                // Data tambahan
            'privacy' => 'public'
        ]);

        $now = Carbon::now();

        // Cek respons dari Node.js
        if ($nodeResponse->successful()) {
            $res = $nodeResponse->json();

            // BA
            if (session('role_id') == '5') {
                $Update_status = UserOrderSpk::where('id', $request->id)->update([
                    'signature_ba' => $res['data'],
                    'name_ba' => auth()->user()->first_name . ' ' . auth()->user()->last_name
                ]);
            } else {
                $Update_status = UserOrderSpk::where('id', $request->id)->update([
                    'signature_acknowledge' => $res['data'],
                    'name_acknowledge' => auth()->user()->first_name . ' ' . auth()->user()->last_name
                ]);
            }


            return response()->json([
                'message' => 'Tanda tangan berhasil disimpan dan dikirim ke Node.js!',
                'file_path' => $filePath,
                'node_response' => $res,
                'img' => $res['data'],
            ]);
        }

        return response()->json(['message' => 'Gagal mengirim ke Node.js'], 500);

    }


}
