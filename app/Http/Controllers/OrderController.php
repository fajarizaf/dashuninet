<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LogActivity;
use App\Models\Pipeline;
use App\Models\SiteProduct;
use App\Models\SiteProductField;
use App\Models\SiteProductGroup;
use App\Models\SiteProductPrice;
use App\Models\SiteStatus;
use App\Models\User;
use App\Models\UserInvoices;
use App\Models\UserInvoicesitem;
use App\Models\UserInvoicestransaction;
use App\Models\UserOrderDetail;
use App\Models\UserOrderField;
use App\Models\UserOrderItem;
use App\Models\UserRole;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionField;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use Faker\Provider\DateTime;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

   

    public function List_order(Request $request)
    {


        $salesorder = UserOrder::latest();

        if ($request->salesorder_number) {
            $salesorder->where('user_order.id', $request->salesorder_number);
        }

        if ($request->sales_pic) {
            $salesorder->where('user_order.sales_id', $request->sales_pic);
        }

        if ($request->customer_name) {
            $salesorder->where('user_order_detail.customer_name', $request->customer_name);
        }

        if ($request->status_id) {
            $salesorder->where('user_order.status_id', $request->status_id);
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

        $salesorder->select('user_order.id as order_id', 'user_order.order_date', 'user_order.target_to_live', 'user_order.order_number', 'user_order_detail.sales_name', 'user_order_detail.customer_name', 'site_product.product_name', 'site_product.product_plan', 'site_product.product_type', 'site_product.product_desc', 'site_status.status_name', 'site_status.updated_at', 'site_status.created_at');
        $salesorder->orderBy('user_order.target_to_live','desc');
        $salesorder->where('user_order.status_id', 1005);
        $salesorder->where('user_order.order_section','order');

        $product_group = SiteProductGroup::query()->where('is_hidden', (int) 0)->get();
        $distinct_order_item = SiteProduct::query()->where('is_hidden', 0)->get();
        $sales_pic = UserRole::query()->select('user.id', 'user.first_name', 'user.last_name')->where('user_role.role_id', (int) 1)->where('user.is_active', (int) 1)->join('user', 'user.id', '=', 'user_role.user_id')->get();
        
        $pending_order = UserOrder::query()->join('user_order_item', 'user_order_item.order_id', '=', 'user_order.id')->join('site_product', 'site_product.id', '=', 'user_order_item.product_id')->where('order_section', 'order')->where('status_id', '1005')->count();
        $rejected_order = UserOrder::query()->where('order_section', 'order')->where('status_id', '1050')->count();

        return view('page/order', [
            'product_group' => $product_group,
            'sales_pic' => $sales_pic,
            'product_filter' => $distinct_order_item,
            'pending' => $pending_order,
            'rejected' => $rejected_order, 
            'data' => $salesorder->paginate(30)->withQueryString(),
        ]);

    }



    public function Detail_order($order_id)
    {

        $order_item_id = UserOrderItem::query()->where('order_id', (int) $order_id)->first()->id;
        $subscription = UserSubscription::query()->where('order_id', (int) $order_id)->first();

        if($subscription) {
            $subscription_id = $subscription->id;
        } else {
            $subscription_id = '';
        }

        $customer_id = UserOrder::query()->where('id', (int) $order_id)->first()->customer_id;
        $customer_number = Customer::query()->where('id', (int) $customer_id)->first()->customer_number;

        $order = UserOrder::query()->where('user_order.id', $order_id)->join('site_status', 'site_status.id', '=', 'user_order.status_id')->first();
        $order_detail = UserOrderDetail::query()->where('order_id', $order_id)->first();
        $order_item = UserOrderItem::query()->where('user_order_item.order_id', $order_id)->join('site_product', 'site_product.id', '=', 'user_order_item.product_id')->get();
        $order_field = UserOrderField::query()->where('order_item_id', $order_item_id)->get();

        $subscription = UserSubscription::query()->where('user_subscription.order_id', $order_id)
                        ->join('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id')
                        ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
                        ->get();

        $subscription_field = UserSubscriptionField::query()->where('subscription_id', $subscription_id)->get();

        $sales_activity = LogActivity::query()
        ->where('module', 'order')
        ->where('module_id', (int) $order_id)
        ->orderByDesc('created_at')
        ->get();

        $subscription_activity = LogActivity::query()
        ->where('module', 'subscription')
        ->where('module_id', (int) $subscription_id)
        ->orderByDesc('created_at')
        ->get();

        $invoices = UserInvoices::query()
        ->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id')
        ->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
        ->where('user_invoices_item.order_id', (int) $order_id)
        ->select('user_invoices.id', 'user_invoices.invoice_number', 'user_invoices.invoice_date','user_invoices.tax','user_invoices.subtotal','user_invoices.invoice_duedate','user_invoices.total','user_invoices.is_publish','invoices_status.status_name')
        ->get();

        $invoices_item = '';

        $finance_activity = '';

        if(!empty($invoices)) {
            foreach ($invoices as $inv) {

                $invoices_item = UserInvoicesitem::query()->where('invoice_id', (int) $inv->id)->get();

                $finance_activity = LogActivity::query()
                ->where('module', 'invoices')
                ->where('module_id', (int) $inv->id)
                ->orderByDesc('created_at')
                ->get();

            }
        }


        return view('page/order-detail', [
            'order' => $order,
            'order_detail' => $order_detail,
            'order_item' => $order_item,
            'order_field' => $order_field,
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
        ]);

    }


    public function Generate_salesorder($order_id) {

        $customer_id = UserOrder::query()->where('id', (int) $order_id)->first()->customer_id;
        $PREFIX = "UMS";

        $ORDER_NUMBER = IdGenerator::generate(['table' => 'user_order', 'field' => 'order_number', 'length' => 10, 'prefix' => $PREFIX]);

        $Update = UserOrder::where('id', $order_id)->update([
            'order_number' => $ORDER_NUMBER,
            'order_section' => 'sales order',
        ]);

        // Log Activity
        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'order',
            'module_id' => $order_id,
            'log_label' => 'Update Status Sales Order',
            'log_entry' => 'Pengajuan anda dengan nomor pengajuan '.$order_id.' telah diterima, dan tunggu info selanjutnya dari team sales kami untuk di hubungi',
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
        ->post(env('BACKEND_URL').'/notif/create', [
            "user" => "customer", 
            "template_id" => 19,
            "id" => $order_id,
            "user_id" => $customer_id
        ]);

        return redirect('/console/salesorder/detail/' . $order_id)->with('success', 'Success, Generate and move order to Sales Order');

    }


    public function Rejected_salesorder($order_id) {

        $customer_id = UserOrder::query()->where('id', (int) $order_id)->first()->customer_id;
        $PREFIX = "UMS";

        $ORDER_NUMBER = IdGenerator::generate(['table' => 'user_order', 'field' => 'order_number', 'length' => 10, 'prefix' => $PREFIX]);

        $Update = UserOrder::where('id', $order_id)->update([
            'status_id' => '1050',
        ]);

        // Log Activity
        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'order',
            'module_id' => $order_id,
            'log_label' => 'Update Status Sales Order',
            'log_entry' => 'Pengajuan anda dengan nomor pengajuan '.$order_id.' telah ditolak, untuk info lebih lanjut silahkan open ticket atau hubungi customer services center',
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);
        
        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
        ->post(env('BACKEND_URL').'/notif/create', [
            "user" => "customer", 
            "template_id" => 20,
            "id" => $order_id,
            "user_id" => $customer_id
        ]);

        return redirect('/console/order/detail/' . $order_id)->with('success', 'Success, Reject Order');

    }


    public function Update_status(Request $request)
    {

        $Update = UserOrder::where('id', $request->order_id)->update([
            'status_id' => $request->status_id,
        ]);

        $status_name = SiteStatus::query()->where('id', (int) $request->status_id)->first()->status_name;

        // if status cancel
        if($request->status_id == 1008) {
            $subscribes = UserSubscription::query()->where('order_id', (int) $request->order_id)->get();
            foreach($subscribes as $sub) {
                
                $Update = UserSubscription::where('id',$sub->id)->update([
                    'status_id' => 1008,
                    'cancel_date' =>  now(),
                ]);
            }
        }

        // if status deleted
        if($request->status_id == 1009) {
            $subscribes = UserSubscription::query()->where('order_id', (int) $request->order_id)->get();
            foreach($subscribes as $sub) {
                
                $Update = UserSubscription::where('id',$sub->id)->update([
                    'status_id' => 1009,
                    'cancel_date' =>  now(),
                ]);
            }
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'salesorder',
            'module_id' => $request->order_id,
            'log_label' => 'Update Status Sales Order',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been changed new status Sales Order to :' . $status_name,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Success, Salesorder status has been changed');

    }




}