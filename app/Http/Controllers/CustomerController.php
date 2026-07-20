<?php

namespace App\Http\Controllers;

use DB;
use App\Models\CustomerCreditPoint;
use App\Models\CustomerRedem;
use App\Models\LogActivity;
use App\Models\SiteExpedition;
use App\Models\SiteReward;
use App\Models\Customer;
use App\Models\CustomerCompany;
use App\Models\UserInvoices;
use App\Models\UserSubscription;
use App\Models\OrderProject;
use App\Models\UserOrder;
use App\Models\SiteProject;
use App\Models\SiteCompany;
use App\Models\UserInvoicestransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Helpers\DepositHelper;

class CustomerController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function List_active(Request $request)
    {

        $customer = Customer::latest();

        $count_active = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
            ->whereNull('customer_membership.customer_id')
            ->where('customer.is_active', 1)
            ->omniFilter()
            ->count();
        $count_deactive = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
            ->whereNull('customer_membership.customer_id')
            ->where('customer.is_active', 0)
            ->omniFilter()
            ->count();
        $count_customer = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
            ->whereNull('customer_membership.customer_id')
            ->omniFilter()
            ->count();

        $customer->select('customer.id', 'customer_name', 'customer_number', 'customer_email', 'customer_telp', 'customer.is_active', 'customer.created_at');
        $customer->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id');
        $customer->leftJoin('customer_company', 'customer_company.user_id', '=', 'customer.id');
        $customer->whereNull('customer_company.user_id');
        $customer->whereNull('customer_membership.customer_id');
        // $customer->where('customer.is_active', 1);

        if ($request->year) {
            $customer->whereYear('customer.created_at', $request->year);
        }
        if ($request->month) {
            $customer->whereMonth('customer.created_at', $request->month);
        }
        if ($request->filter_area) {
            $customer->join('user_order', 'user_order.customer_id', '=', 'customer.id');
            $customer->join('order_project', 'user_order.id', '=', 'order_project.order_id');
            $customer->where('project_id', $request->filter_area);
            $customer->whereNotNull('order_project.id');
        }

        if(session('role_id') == 1) {
            $customer->leftJoin('user_order', 'user_order.customer_id', '=', 'customer.id');
            $customer->where('user_order.sales_id', auth()->user()->id);
        }

        if ($request->customer_name) {
            $customer->where('customer.customer_name', 'LIKE', "%$request->customer_name%" );
        }
        if ($request->customer_status != '') {
            $customer->where('customer.is_active', $request->customer_status);
        }
        if ($request->customer_number != '') {
            $customer->where('customer.customer_number', $request->customer_number);
        }
        $customer->omniFilter();

        return view('page/customer-list', [
            'count_active' => $count_active,
            'count_deactive' => $count_deactive,
            'count_customer' => $count_customer,
            'data' => $customer->paginate(30)->withQueryString(),
        ]);

    }

    public function List_corporate(Request $request)
    {

        $customer = Customer::latest();

        $count_active = Customer::query()->Join('customer_company', 'customer_company.user_id', '=', 'customer.id')
            ->where('customer.is_active', 1)
            ->omniFilter()
            ->count();
        $count_deactive = Customer::query()->Join('customer_company', 'customer_company.user_id', '=', 'customer.id')
            ->where('customer.is_active', 0)
            ->omniFilter()
            ->count();
        $count_customer = Customer::query()->Join('customer_company', 'customer_company.user_id', '=', 'customer.id')
            ->omniFilter()
            ->count();

        $customer->Join('customer_company', 'customer_company.user_id', '=', 'customer.id');
        $customer->Join('site_company', 'site_company.id', '=', 'customer_company.company_id');
        $customer->select('customer.id', 'customer_name', 'customer_number', 'customer_email', 'customer_telp', 'customer.is_active', 'customer.created_at','site_company.company_name');
        
        // $customer->where('customer.is_active', 1);

        if ($request->year) {
            $customer->whereYear('customer.created_at', $request->year);
        }
        if ($request->month) {
            $customer->whereMonth('customer.created_at', $request->month);
        }
        if ($request->filter_area) {
            $customer->join('user_order', 'user_order.customer_id', '=', 'customer.id');
            $customer->join('order_project', 'user_order.id', '=', 'order_project.order_id');
            $customer->where('project_id', $request->filter_area);
            $customer->whereNotNull('order_project.id');
        }

        if(session('role_id') == 1) {
            $customer->leftJoin('user_order', 'user_order.customer_id', '=', 'customer.id');
            $customer->where('user_order.sales_id', auth()->user()->id);
        }

        if ($request->company_name) {
            $customer->where('site_company.company_name', 'LIKE', "%$request->company_name%" );
        }

        if ($request->customer_name) {
            $customer->where('customer.customer_name', 'LIKE', "%$request->customer_name%" );
        }

        if ($request->customer_status != '') {
            $customer->where('customer.is_active', $request->customer_status);
        }

        if ($request->customer_number != '') {
            $customer->where('customer.customer_number', $request->customer_number);
        }

        $customer->omniFilter();

        $site_company = SiteCompany::query()->where('parentid', session('company_id'))->get();

        return view('page/customer-company-list', [
            'count_active' => $count_active,
            'count_deactive' => $count_deactive,
            'count_customer' => $count_customer,
            'data' => $customer->paginate(30)->withQueryString(),
            'site_company' => $site_company
        ]);

    }

    public function List_membership(Request $request)
    {

        $count_active = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
        ->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id')
        ->whereNotNull('customer_membership.customer_id')
        ->where('customer_membership.is_active', 1)
        ->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10'])
        ->omniFilter()
        ->count();
        
        $count_deactive = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
        ->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id')
        ->whereNotNull('customer_membership.customer_id')
        ->where('customer_membership.is_active', 0)
        ->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10'])
        ->omniFilter()
        ->count();
        
        $count_customer = Customer::query()->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
        ->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id')
        ->whereNotNull('customer_membership.customer_id')
        ->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10'])
        ->omniFilter()
        ->count();

        $customer = Customer::latest();
        $customer->select(DB::raw("(SELECT COUNT(*) AS result FROM customer_membership as a where a.referral_id=customer_membership.id AND a.is_active = 1) as count_downline"), //salah, harusnya customer_membership.referral_id=customer_membership.id
        DB::raw("(SELECT COUNT(*) AS result FROM user_order where user_order.customer_id=customer.id) as count_order"),
        'site_product.product_name', 'customer_membership.points', 'customer.id', 'customer.customer_name', 'customer.customer_number', 'customer.is_active', 'customer.created_at', 'customer.customer_photo', DB::raw('(CASE WHEN customer_membership.is_active = 1 THEN "Active" ELSE "Deactive" END) AS status'));
        $customer->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id');
        $customer->leftJoin('site_product', 'site_product.id', '=', 'customer_membership.product_order');
        $customer->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id');
        // $customer->join('user_subscription', function ($join) {
        //     $join->on('customer.id', '=', 'user_subscription.customer_id')
        //         // ->where('user_mobile.is_primary',1)
        //         ->limit(1);
        // });
        $customer->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10']);
        $customer->whereNotNull('customer_membership.customer_id');

        if(session('role_id') == 1) {
            $customer->leftJoin('user_order', 'user_order.customer_id', '=', 'customer.id');
            $customer->where('user_order.sales_id', auth()->user()->id);
        }

        if ($request->member_name) {
            $customer->where('customer.customer_name', 'LIKE', "%$request->member_name%" );
        }
        if ($request->member_status != '') {
            $customer->where('customer_membership.is_active', $request->member_status);
        }
        if ($request->customer_number != '') {
            $customer->where('customer.customer_number', $request->customer_number);
        }

        $customer->omniFilter();
        // $sql = $customer->toSql();
        // dd($sql);
        // dd($customer->paginate(30)->withQueryString());

        return view('page/membership-list', [
            'count_active' => $count_active,
            'count_deactive' => $count_deactive,
            'count_customer' => $count_customer,
            'data' => $customer->paginate(30)->withQueryString(),
        ]);

    }

    public function Detail_membership($customer_id)
    {
        $count_subs = DB::table('user_subscription')->where('customer_id', $customer_id)->count(); //->where('status_id', '1001')
        $count_inv = DB::table('user_invoices')->where('customer_id', $customer_id)->count(); 
        $count_trx = DB::table('user_invoices')->where('customer_id', $customer_id)->where('status_id', '1036')->count(); 

        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();

        // jika member
        if ($checkCustMember) {
            $customer = DB::table('customer')
            ->select('user_subscription.complete_date', 'user_subscription.subscription_date', 'site_product.product_name', 'site_product.product_plan', 'customer_membership.points', 'customer_membership.referral_code', 'customer.id', 'customer.customer_name', 'customer.customer_number', 'customer.customer_email', 'customer.customer_telp', 'customer.customer_company', 'customer.is_active', 'customer_membership.is_active as is_active_subs', 'customer.created_at', 'customer.customer_photo', DB::raw('(CASE WHEN customer.is_active = 1 THEN "Active" ELSE "Deactive" END) AS status'), DB::raw('(CASE WHEN customer_membership.is_active = 1 THEN "Active" ELSE "Deactive" END) AS status_subs'))
            ->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id')
            ->leftJoin('site_product', 'site_product.id', '=', 'customer_membership.product_order')
            ->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id')
            ->where('customer.id', $customer_id)
            ->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10'])
            ->first();

            $count_company = DB::table('site_company')
            ->join('customer_company', 'customer_company.company_id', '=','site_company.id')
            ->where('customer_company.user_id',$customer_id)
            ->count();

            $company = DB::table('site_company')
            ->join('customer_company', 'customer_company.company_id', '=','site_company.id')
            ->where('customer_company.user_id',$customer_id)
            ->first();
        
            $redem = CustomerRedem::latest()
            ->select('customer_redem.id','site_reward.reward_name','site_status.status_name','customer_redem.created_at','site_reward.reward_point','site_reward.reward_cover')
            ->join('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id')
            ->join('site_status', 'site_status.id', '=', 'customer_redem.redem_status')
            ->where('customer_redem.redem_status','!=', 1035)
            ->where('customer_redem.customer_id', $customer_id);
            $redem = $redem->paginate(5)->withQueryString();
    
    
            $curl = curl_init();
            $params = array('limit'=> '10','page' => '0','mode' => 'downline');
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('BACKEND_URL').'/membership/getMember/'.$customer_id . '?' . http_build_query($params),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.env('BACKEND_TOKEN').''
                ),
            ));
    
            $response = curl_exec($curl);
            $response = json_decode($response);
            curl_close($curl);

            $tipe = 'member';

        } else {
            $customer = DB::table('customer')
            ->select('customer.id', 'customer.customer_name', 'customer.customer_number', 'customer.customer_email', 'customer.customer_telp', 'customer.customer_company', 'customer.is_active', 'customer.created_at', 'customer.customer_photo', DB::raw('(CASE WHEN customer.is_active = 1 THEN "Active" ELSE "Deactive" END) AS status'))
            ->where('customer.id', $customer_id)
            ->first();

            $count_company = DB::table('site_company')
            ->join('customer_company', 'customer_company.company_id', '=','site_company.id')
            ->where('customer_company.user_id',$customer_id)
            ->count();

            $company = DB::table('site_company')
            ->join('customer_company', 'customer_company.company_id', '=','site_company.id')
            ->where('customer_company.user_id',$customer_id)
            ->first();
    
            $redem = "";
            $response = "";
            $tipe = 'customer';
    
        }
        
        $invoices = UserInvoices::latest()
        ->select('user_invoices.id','user_invoices.is_publish','user_invoices.invoice_number','user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name')
        ->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id')
        ->where('user_invoices.customer_id', $customer_id);

        $subs = UserSubscription::latest()
        ->select('user_subscription.complete_date', 'user_subscription.subscription_date', 'site_product.product_name', 'site_product.product_plan', 'site_product.product_type', 'subscription_status.status_name', 'user_subscription.created_at')
        ->leftJoin('site_product', 'site_product.id', '=', 'user_subscription.product_id')
        ->join('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id')
        ->where('user_subscription.customer_id', $customer_id);

        // Get customer balance
        $customer_balance = DepositHelper::getBalance($customer_id);

        return view('page/membership-detail', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'count_company' => $count_company,
            'company' => $company,
            'count_subs' => $count_subs,
            'count_inv' => $count_inv,
            'count_trx' => $count_trx,
            'data' => $customer,
            'dataInv' => $invoices->paginate(5)->withQueryString(),
            'dataSubs' => $subs->paginate(5)->withQueryString(),
            'dataRedem' => $redem,
            'dataDownline' => $response,
            'customer_balance' => $customer_balance,
        ]);

    }

    public function List_invoices($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        $invoices = UserInvoices::latest();

        $count_invoices_paid = UserInvoices::query()->where('status_id', 1036)->where('is_publish', 1)->where('customer_id', $customer_id)->count();
        $count_invoices_unpaid = UserInvoices::query()->where('status_id', 1037)->where('is_publish', 1)->where('customer_id', $customer_id)->count();
        $count_invoices_cancel = UserInvoices::query()->where('status_id', 1008)->where('customer_id', $customer_id)->count();

        $invoices->where('is_publish', (int) 1)->where('customer_id', $customer_id);
        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->select('user_invoices.id','user_invoices.is_publish','user_invoices.invoice_number','user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name');
       
       
        return view('page/customer_invoices', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
           'count_paid' => $count_invoices_paid,
           'count_unpaid' => $count_invoices_unpaid,
           'count_cancel' => $count_invoices_cancel,
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);

   }

   public function List_redem($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }
 
        $redem = CustomerRedem::latest();

        $count_redem_pending = CustomerRedem::query()->where('redem_status', 1036)->where('customer_id', $customer_id)->count();
        $count_redem_process = CustomerRedem::query()->where('redem_status', 1037)->where('customer_id', $customer_id)->count();
        $count_redem_shipment = CustomerRedem::query()->where('redem_status', 1049)->where('customer_id', $customer_id)->count();
        $count_redem_complete = CustomerRedem::query()->where('redem_status', 1035)->where('customer_id', $customer_id)->count();
        $count_redem_reject = CustomerRedem::query()->where('redem_status', 1050)->where('customer_id', $customer_id)->count();

        $count_redem = CustomerRedem::query()->where('customer_id', $customer_id)->count(); //->whereIn('redem_status', array(1036,1037,1049))

        // $redem->where('customer_redem.redem_status','!=', 1035);
        $redem->where('customer.id', $customer_id);
        $redem->join('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id');
        $redem->join('customer', 'customer.id', '=', 'customer_redem.customer_id');
        $redem->join('site_status', 'site_status.id', '=', 'customer_redem.redem_status');

        $redem->select('customer_redem.id','customer.customer_name','site_reward.reward_name','site_status.status_name','customer_redem.created_at','site_reward.reward_point','site_reward.reward_cover');

        return view('page/customer_redem', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'count_redem' => $count_redem,
            'count_redem_pending' => $count_redem_pending,
            'count_redem_process' => $count_redem_process,
            'count_redem_shipment' => $count_redem_shipment,
            'count_redem_complete' => $count_redem_complete,
            'count_redem_reject' => $count_redem_reject,
            'data' => $redem->paginate(30)->withQueryString(),
        ]);

    }

    public function List_downline($customer_id)
    {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        $customer = Customer::latest();
        $customer->select(DB::raw("(SELECT COUNT(*) AS result FROM customer_membership as a where a.referral_id=customer_membership.id AND a.is_active = 1) as count_downline"), //salah, harusnya customer_membership.referral_id=customer_membership.id
        DB::raw("(SELECT COUNT(*) AS result FROM user_order where user_order.customer_id=customer.id) as count_order"),
        'site_product.product_name', 'site_product.product_plan', 'customer_membership.points', 'customer.id', 'customer.customer_name', 'customer.customer_number', 'customer_membership.is_active as status_member', 'customer.is_active', 'customer.created_at', 'customer.customer_photo', DB::raw('(CASE WHEN customer_membership.is_active = 1 THEN "Active" ELSE "Deactive" END) AS status'));
        $customer->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id');
        $customer->leftJoin('site_product', 'site_product.id', '=', 'customer_membership.product_order');
        $customer->leftJoin('user_subscription', 'user_subscription.customer_id', '=', 'customer.id');
        $customer->whereIn('user_subscription.product_id', ['5','6','7', '8', '9', '10']);

        $customer->whereNotNull('customer_membership.customer_id');
        // $customer->where('customer.id', $customer_id);
        $customer->whereRaw(DB::raw('customer_membership.referral_id = (select id from customer_membership where customer_id = '.$customer_id.')'));
        

        // $sql = $customer->toSql();
        // dd($sql);
        // dd($customer->paginate(30)->withQueryString());

        return view('page/customer-downline', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'data' => $customer->paginate(30)->withQueryString(),
        ]);

    }

    public function List_point($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        $point = CustomerCreditPoint::latest()
        ->select( 'customer_credit_point.amount_in', 'customer_credit_point.amount_out', 'customer_credit_point.credit_type', 'customer_credit_point.created_at')
        // ->select('customer.customer_name', 'site_reward.reward_name', 'customer_credit_point.amount_in', 'customer_credit_point.amount_out', 'customer_credit_point.credit_type', 'customer_credit_point.created_at')
        // ->leftJoin('customer', 'customer.id', '=', 'customer_credit_point.from_customer')
        // ->leftJoin('customer_redem', 'customer_redem.id', '=', 'customer_credit_point.redem_id')
        // ->leftJoin('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id')
        ->where('customer_credit_point.customer_id', $customer_id);

        return view('page/customer-point', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'data' => $point->paginate(30)->withQueryString(),
        ]);
    }

    public function List_transaction($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        $invoices = UserInvoices::latest();

        $count_invoices_paid = UserInvoices::query()->where('status_id', 1036)->where('is_publish', 1)->where('customer_id', $customer_id)->count();

        $invoices->where('is_publish', (int) 1)->where('customer_id', $customer_id)->where('status_id', 1036);
        $invoices->join('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');
        $invoices->join('user_invoices_transaction', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id');
        $invoices->select('user_invoices_transaction.trx_number', 'user_invoices_transaction.trx_date', 'user_invoices.id','user_invoices.is_publish','user_invoices.invoice_number','user_invoices.invoice_date', 'user_invoices.invoice_duedate', 'user_invoices.total', 'invoices_status.status_name', 'user_invoices_transaction.created_at');
       
       
        return view('page/customer-trx', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
           'count_paid' => $count_invoices_paid,
            'data' => $invoices->paginate(30)->withQueryString(),
        ]);
    }

    public function List_subs($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        $count_subs = UserSubscription::query()->where('customer_id', $customer_id)->count();

        $subs = UserSubscription::latest()
        ->select('site_status.status_name', 'user_subscription.order_id', 'user_subscription.id','user_subscription.subscription_number','user_subscription.billingcycle','user_subscription.amount', 'user_subscription.complete_date', 'site_product.product_name', 'site_product.product_plan', 'site_product.product_type', 'user_subscription.created_at')
        ->leftJoin('site_product', 'site_product.id', '=', 'user_subscription.product_id')
        ->leftJoin('site_status', 'site_status.id', '=', 'user_subscription.status_id')
        ->where('user_subscription.customer_id', $customer_id);

        return view('page/customer-subs', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'count_subs' => $count_subs,
            'data' => $subs->paginate(30)->withQueryString(),
        ]);
    }

    public function Balance_history($customer_id) {
        $checkCustMember = DB::table('customer_membership')
        ->select('id')
        ->where('customer_membership.customer_id', $customer_id)
        ->first();
        // jika member
        if ($checkCustMember) {
            $tipe = 'member';
        }else{
            $tipe = 'customer';
        }

        // Query untuk mengambil riwayat saldo
        $balance_history = UserInvoicestransaction::latest()
        ->select(
            'user_invoices_transaction.id',
            'user_invoices_transaction.invoice_id',
            'user_invoices_transaction.trx_number',
            'user_invoices_transaction.trx_date',
            'user_invoices_transaction.amount_in',
            'user_invoices_transaction.is_deposit',
            'user_invoices.payment_method',
            'user_invoices.status_id',
            'user_invoices.invoice_number',
            'user_invoices_transaction.created_at',
            DB::raw('CASE 
                WHEN user_invoices_transaction.is_deposit = 1 THEN "Deposit" 
                WHEN user_invoices_transaction.is_deposit = 0 AND user_invoices.payment_method = "deposit" AND user_invoices.status_id = 1036 THEN "Penggunaan" 
                ELSE "Lainnya" 
            END as transaction_type')
        )
        ->leftJoin('user_invoices', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id')
        ->where('user_invoices.customer_id', $customer_id)
        ->where(function($query) {
            $query->where('user_invoices_transaction.is_deposit', 1)
                  ->orWhere(function($subQuery) {
                      $subQuery->where('user_invoices_transaction.is_deposit', 0)
                               ->where('user_invoices.payment_method', 'deposit')
                               ->where('user_invoices.status_id', 1036);
                  });
        });

        $count_deposit = UserInvoicestransaction::query()
        ->leftJoin('user_invoices', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id')
        ->where('user_invoices.customer_id', $customer_id)
        ->where('user_invoices_transaction.is_deposit', 1)
        ->count();

        $count_usage = UserInvoicestransaction::query()
        ->leftJoin('user_invoices', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id')
        ->where('user_invoices.customer_id', $customer_id)
        ->where('user_invoices_transaction.is_deposit', 0)
        ->where('user_invoices.payment_method', 'deposit')
        ->where('user_invoices.status_id', 1036)
        ->count();

        return view('page/customer-balance-history', [
            'tipe' => $tipe,
            'customer_id' => $customer_id,
            'count_deposit' => $count_deposit,
            'count_usage' => $count_usage,
            'data' => $balance_history->paginate(30)->withQueryString(),
        ]);
    }

    public function Detail(Request $request)
    {
        $get = Customer::query()->where('customer.id', $request->customer_id)
        ->first();
        return $get;
    }

    public function CompanyDetail(Request $request)
    {
        $get = SiteCompany::query()->where('id', $request->company_id)->first();
        return $get;
    }

    public function CompanyUpdate(Request $request) {
       
        $Update = SiteCompany::where('id',$request->company_id)->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_telp' => $request->company_telp,
            'company_address' => $request->company_address,
        ]);

        if (!$Update) {
            return redirect('/console/customer/detail/'.$request->customer_id)->with('failed', $res->message);
        } else {

            $LOG_ACTIVITY = LogActivity::create([
                'module' => 'company',
                'module_id' => $request->customer_id,
                'log_label' => 'Update Data Company',
                'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been update data Company, with Company id :'.$request->company_id,
                'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
                'log_user_id' => auth()->user()->id,
                'log_user_ip' => request()->ip(),
            ]);

            return redirect('/console/customer/detail/'.$request->customer_id)->with('success','Success, Update Company');
        }
    }

    public function Update(Request $request) {
        
        if($request->contact_type) {
            $Update = CustomerCompany::where('user_id',$request->customer_id)->update([
                'contact_type' => $request->contact_type
            ]);
        }

        if($request->customer_password) {
            $data = array('custId' => $request->customer_id, 'is_verified' => $request->is_verified, 'is_active' => $request->status, 'customer_email' => $request->customer_email, 'customer_name' => $request->customer_name,'customer_company' => $request->customer_company,'customer_telp' => $request->customer_telp,'customer_address' => $request->customer_address,'customer_password' => $request->customer_password);
        }else{
            $data = array('custId' => $request->customer_id, 'is_verified' => $request->is_verified, 'is_active' => $request->status, 'customer_email' => $request->customer_email, 'customer_name' => $request->customer_name,'customer_company' => $request->customer_company,'customer_telp' => $request->customer_telp,'customer_address' => $request->customer_address);
        }

        $response = Http::withToken(env('BACKEND_TOKEN'))
        ->post(env('BACKEND_URL').'/customer/update', $data);
        $res = json_decode($response->body());
        // dd($res);

        if ($res->status == "500") {
            return redirect('/console/customer/detail/'.$request->customer_id)->with('failed', $res->message);
        } else {
            $LOG_ACTIVITY = LogActivity::create([
                'module' => 'customer',
                'module_id' => $request->customer_id,
                'log_label' => 'Update Data Customer',
                'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been update data Customer, with Customer id :'.$request->customer_id.' to :'.json_encode($data),
                'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
                'log_user_id' => auth()->user()->id,
                'log_user_ip' => request()->ip(),
            ]);

            return redirect('/console/customer/detail/'.$request->customer_id)->with('success','Success, Update profile customer');
        }
    }

    public function set_deactive(Request $request) {
        $Update = Customer::where('id',$request->user_id)->update([
            'is_active' => 0,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'customer',
            'module_id' => $request->user_id,
            'log_label' => 'Update Data Customer',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_deactive data Customer, with Customer id :'.$request->user_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }


    public function set_active(Request $request) {
        $Update = Customer::where('id',$request->user_id)->update([
            'is_active' => 1,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'customer',
            'module_id' => $request->user_id,
            'log_label' => 'Update Data Customer',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_active data Customer, with Customer id :'.$request->user_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }

    public function set_status(Request $request) {
        $Update = DB::table('customer_membership')->where('customer_id',$request->member_id)->update([
            'is_active' => $request->is_active,
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'customer',
            'module_id' => $request->member_id,
            'log_label' => 'Update Data Customer',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_status membership Customer, with Customer id :'.$request->member_id.', to : is_active = '.$request->is_active,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }

    public function Statistic_peryear(Request $request)
    {
        if ($request->filter_year) {
            $year = $request->filter_year;
        } else {
            $now = Carbon::now();
            $year = $now->year;
        }

        $initProj = SiteProject::query()
        ->select('id', 'project_name')
        ->where('status', '=', 'active')
        ->get(); //->toArray();

        $initYear = UserInvoicestransaction::query()
        ->select(DB::raw('YEAR(trx_date) year'))
        ->groupby('year')
        ->get(); //->toArray();

        if ($request->filter_area) {
            if (session('company_id') != 1) {
                $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(customer.id) as `data`'),  DB::raw('YEAR(customer.created_at) year, MONTH(customer.created_at) month'))
                ->leftJoin('user_order', 'user_order.id', '=', 'order_project.order_id')
                ->leftJoin('customer', 'customer.id', '=', 'user_order.customer_id')
                ->where('is_active', '1')->whereYear('customer.created_at', $year)
                ->where('project_id', $request->filter_area)
                ->where('customer.reseller_id', session('reseller_id'))
                ->groupby('year','month')
                ->get(); //->toArray();
            } else {
                $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(customer.id) as `data`'),  DB::raw('YEAR(customer.created_at) year, MONTH(customer.created_at) month'))
                ->leftJoin('user_order', 'user_order.id', '=', 'order_project.order_id')
                ->leftJoin('customer', 'customer.id', '=', 'user_order.customer_id')
                ->where('is_active', '1')->whereYear('customer.created_at', $year)
                ->where('project_id', $request->filter_area)
                ->groupby('year','month')
                ->get(); //->toArray();
            }            
        } else {
            if (session('company_id') != 1) {
                $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(customer.id) as `data`'),  DB::raw('YEAR(customer.created_at) year, MONTH(customer.created_at) month'))
                ->leftJoin('user_order', 'user_order.id', '=', 'order_project.order_id')
                ->leftJoin('customer', 'customer.id', '=', 'user_order.customer_id')
                ->where('is_active', '1')->whereYear('customer.created_at', $year)
                ->where('customer.reseller_id', session('reseller_id'))
                ->groupby('year','month')
                ->get(); //->toArray();
            } else {
                $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(customer.id) as `data`'),  DB::raw('YEAR(customer.created_at) year, MONTH(customer.created_at) month'))
                ->leftJoin('user_order', 'user_order.id', '=', 'order_project.order_id')
                ->leftJoin('customer', 'customer.id', '=', 'user_order.customer_id')
                ->where('is_active', '1')->whereYear('customer.created_at', $year)
                ->groupby('year','month')
                ->get(); //->toArray();
            }
        }

        $month = array(array('month' => 'Januari'), array('month' => 'Februari'), array('month' => 'Maret'), array('month' => 'April'), array('month' => 'Mei'), array('month' => 'Juni'), array('month' => 'Juli'), array('month' => 'Agustus'), array('month' => 'September'), array('month' => 'Oktober'), array('month' => 'November'), array('month' => 'Desember'));

        foreach($total_cust_group_by_month as $dat){
            $dataQuery[$dat->month] = array('total' => $dat->data, 'bln' => $dat->month);
        }

        $total_per_year = 0;
        $month_list = array();
        foreach($month as $key=>$d){
            $a = 0;
            if (isset($dataQuery[$key+1]['bln'])) {
                $a = $dataQuery[$key+1]['total'];
            }
            $month_map[] = array('month' => $d['month'], 'count' => $a);
            if ($a > 0 ) {
                $month_list[] = array('number' => $key+1, 'month' => $d['month'], 'count' => $a);
            }

            $total_per_year += $a;
        }

        return view('page/stat-byarea-cust', [
            'total_paid' => $total_per_year,
            'statistic_perday' => json_encode($month_map),
            'month_list' => $month_list,
            'year' => $year,
            'filter_area' => $request->filter_area,
            'initProj' => $initProj,
            'initYear' => $initYear,
        ]);

    }

    public function Corporate_pic(Request $request)
    {
        $get = CustomerCompany::query()->where('customer_company.company_id', $request->company_id)
        ->join('customer','customer.id','=','customer_company.user_id')
        ->where('customer_company.is_pic', 1)
        ->get();
        
        return response()->json($get);

    }

    public function create_company(Request $request)
    {
        
        $COMPANY = SiteCompany::create([
            'parentid' => session('company_id'),
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_telp' => $request->company_telp,
            'status_id' => 1001,
            'is_active' => 1,
        ]);

        $CUSTOMER = Http::withToken(env('BACKEND_TOKEN'))
        ->post(env('BACKEND_URL').'/customer/register', [
            'reseller_id' => session('reseller_id'),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_telp' => $request->customer_telp,
            'customer_company' => "",
            'customer_password' => $request->password,
            'fromPipeline' => true,
        ]);

        $customer_id = $CUSTOMER['data']['id'];

        $CUSTOMER_EXIST = Customer::query()->where('customer_email', $request->customer_email)->count();

        if ($CUSTOMER_EXIST == 0) {

            $CUSTOMER = Customer::create([
                'reseller_id' => session('reseller_id'),
                'customer_number' => '',
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_telp' => $request->customer_telp,
                'is_verified' => 1,
                'is_active' => 1,
                'created_by' => auth()->user()->id,
                'modified_by' => auth()->user()->id,
            ]);

            $customer_id = $CUSTOMER->id;

        }

        // Mapping Customer Company
        $CUSTOMER_COMPANY = CustomerCompany::create([
            'user_id' => $customer_id,
            'company_id' => $COMPANY->id,
            'contact_type' => 'Account Manager',
            'is_pic' => 1,
        ]);

        return redirect('/console/customer/corporate')->with('success','Success, Create new customer company');

    }


    public function create_contact(Request $request)
    {
        
        $CUSTOMER = Http::withToken(env('BACKEND_TOKEN'))
        ->post(env('BACKEND_URL').'/customer/register', [
            'reseller_id' => session('reseller_id'),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_telp' => $request->customer_telp,
            'customer_company' => "",
            'customer_password' => $request->password,
            'fromPipeline' => true,
        ]);

        $customer_id = $CUSTOMER['data']['id'];

        $CUSTOMER_EXIST = Customer::query()->where('customer_email', $request->customer_email)->count();

        if ($CUSTOMER_EXIST == 0) {

            $CUSTOMER = Customer::create([
                'reseller_id' => session('reseller_id'),
                'customer_number' => '',
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_telp' => $request->customer_telp,
                'is_verified' => 1,
                'is_active' => 1,
                'created_by' => auth()->user()->id,
                'modified_by' => auth()->user()->id,
            ]);

            $customer_id = $CUSTOMER->id;

        }

        // Mapping Customer Company
        $CUSTOMER_COMPANY = CustomerCompany::create([
            'user_id' => $customer_id,
            'company_id' => $request->company_id,
            'contact_type' => $request->contact_type,
            'is_pic' => 0,
        ]);

        return redirect('/console/customer/corporate')->with('success','Success, Create new contact customer');

    }

}
