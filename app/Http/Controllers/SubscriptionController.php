<?php

namespace App\Http\Controllers;

use App\Jobs\AutosuspendJob;
use App\Jobs\AutoactiveJob;
use App\Jobs\AutodeactiveJob;
use App\Models\SiteRouter;
use App\Models\UserNotif;

use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\LogActivity;
use App\Models\SiteProduct;
use App\Models\SiteProductField;
use App\Models\SiteProductPrice;
use App\Models\UserInvoices;
use App\Models\UserInvoicesitem;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserSubscription;
use App\Models\OrderProject;
use App\Models\SiteProject;
use App\Models\UserRole;
use App\Models\Promo;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Http;
use App\Models\UserInvoicestransaction;
use App\Models\UserSubscriptionField;

use App\Helpers\DepositHelper;
use App\Helpers\SubscriptionHelper;

// lib mikrotik api
use App\Library\RouterosAPI;

class SubscriptionController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function get_detail(Request $request)
    {
        $subscription = UserSubscription::query()->select(
            "user_subscription.id",
            "user_subscription.subscription_number",
            "user_subscription.billing_account",
            "user_subscription.subscription_date",
            "user_subscription.expired_date",
            "site_product.product_name",
            "user_subscription.created_at",
            "user_subscription.amount",
            "user_subscription.progress_date",
            "user_subscription.suspend_reason",
            "site_product.product_plan",
            "site_product.product_desc",
            "user_subscription.billingcycle",
            "user_subscription.amount",
            "user_subscription.complete_date",
            "user_subscription.expired_date",
            "subscription_status.status_name",
            "site_product.product_scope",
            "user_subscription.complete_date",
            "user_subscription.is_free"
        )
            ->where('user_subscription.id', $request->subscription_id)
            ->join('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id')
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->first();

        $subscription_field = UserSubscriptionField::query()->where('subscription_id', $request->subscription_id)->get();

        $subscription_activity = LogActivity::query()
            ->where('module', 'subscription')
            ->where('module_id', (int)$request->subscription_id)
            ->orderByDesc('created_at')
            ->get();

        return json_encode(["subs" => $subscription, "subs_field" => $subscription_field, "subs_activity" => $subscription_activity]);

    }

    public function auto_active(Request $request)
    {
        $subs = UserSubscription::query()->where('id', $request->subscription_id)->first();
        if ($subs->status_id == 2) {
            $subs->update(['status_id' => 1]);
        }
    }

    public function set_update(Request $request)
    {

        $data = [
            'is_free' => $request->is_free,
            'amount' => $request->amount,
            'next_due_date' => $request->next_year . '-' . $request->next_month . '-01',
        ];

        $Update = UserSubscription::where('id', $request->subscription_id)->update($data);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Update Data Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been update data subscription, with subscribtion id :' . $request->subscription_id . ' to :' . json_encode($data),
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Data Subscription has been updated');

    }


    public function set_active(Request $request)
    {
        
        $subs = UserSubscription::query()
            ->select("customer_id", "complete_date", "user_subscription.order_id", "subscription_number", "product_scope","site_product.deposit_payment", "user_subscription.product_id")
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.id', (int)$request->subscription_id)->first();
        
        // cek pembelian produk ambil dari deposit atau tidak
        if($subs->deposit_payment == 1) {

            //cek saldo deposit
            $deposit = DepositHelper::getBalance($subs->customer_id);
            $amount_order = UserOrder::where('id', $request->order_id)->value('total');
            $invoices_id = UserInvoicesItem::where('order_id', $request->order_id)->value('invoice_id');
            $amount_invoices = UserInvoices::where('id', $invoices_id)->value('total');

            // cek apakah saldo deposit cukup
            if($deposit < $amount_order) {
                $stats = 'failed';
                $message = 'Saldo deposit tidak cukup, silahkan arahkan pelanggan untuk melakukan topup deposit';
                return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);
            }

        }

        if ($subs->product_scope == "retail") {

            $api = new RouterosAPI();

            $AREA_ID = OrderProject::query()->where('order_id', $request->order_id)->first();

            if ($AREA_ID != null) {

                $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                if ($ROUTER_ID->router_id != '') {

                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();

                    // connect to mikrotik
                    if ($api->connect($router->ipaddress, $router->username, $router->password)) {

                        $SUBSCRIPTION_NUMBER = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->subscription_number;
                        
                            // jika product onetime
                            $is_product_onetime = SiteProductPrice::where('product_id', $subs->product_id)
                                                ->where('payment_type', 'onetime')
                                                ->exists();

                            $CUSTOMER = Customer::query()->where('id', $subs->customer_id)->first();
                                                
                            // jika product onetime, daftarkan CID ke mikrotik
                            // jika product bukan onetime, daftarkan CSID ke mikrotik
                            if($is_product_onetime) {

                                // panggil fungsi deactiveAllSubscription
                                SubscriptionHelper::deactiveAllSubscription($subs->customer_id);

                                $SUBSCRIPTION_NUMBER = $CUSTOMER->customer_number;
                            } else {
                                $SUBSCRIPTION_NUMBER = $SUBSCRIPTION_NUMBER;
                            }

                        // get secret
                        $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER]));

                        if (!empty($secret)) {

                            $package_id = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->product_id;
                            $profile_name = SiteProduct::query()->where('id', $package_id)->first()->product_profile;

                            // set active secret, change profile
                            $params = array_merge(['password' => $secret['0']['password']], [
                                '.id' => $secret['0']['.id'],
                                'name' => $secret['0']['name'],
                                'service' => $secret['0']['service'],
                                'profile' => $profile_name,
                                'disabled' => 'false',
                            ]);

                            $api->comm('/ppp/secret/set', $params);

                            $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER]));

                            if ($crosscek[0]['profile'] != 'profile-isolir') {

                                // get connection
                                $arrID = $api->comm("/ppp/active/getall", array(".proplist" => ".id", "?name" => $SUBSCRIPTION_NUMBER));

                                if (!empty($arrID)) { 

                                    // reset connection
                                    $api->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"], ));

                                }

                                $stats = 'success';
                                $message = 'Subscription has been activated, profile secret has been change on mikrotik';

                            } else {

                                $stats = 'failed';
                                $message = 'Failed deactive subscription, profile secret not set';

                            }

                            $api->disconnect();

                            if ($stats == 'success') {

                                $CUSTOMER_ID = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->customer_id;
                                $COMPLETE_DATE = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->complete_date;

                                $is_product_onetime = SiteProductPrice::where('product_id', $subs->product_id)
                                    ->where('payment_type', 'onetime')
                                    ->exists(); 

                                if (empty($COMPLETE_DATE)) {

                                    $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                        'complete_date' => $request->date_live,
                                    ]);

                                    if($is_product_onetime) {
                                        $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                            'expired_date' => Carbon::now()->addHours(24),
                                        ]);
                                    }

                                } else {

                                    $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                        'reactive_date' => $request->date_live,
                                    ]);

                                }

                                $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();

                                $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                    'status_id' => 1001
                                ]);

                                // get billing account
                                $NEW_BILLING_NUMBER = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->billing_account;
                                
                                $COUNT_INVOICES = UserInvoicesitem::query()->where('billing_account', $NEW_BILLING_NUMBER)->count();
                                    
                                // apabila belum ada invoices // generate invoices register
                                if ($COUNT_INVOICES == 0) {
                                    if($is_product_onetime == true) {
                                        // generate invoices auto terbit send to customer
                                        $GENERATE_INVOICES = self::Generate_invoices_ondemand($request->subscription_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'new');   
                                    } else {
                                        // generate invoices auto terbit send to customer
                                        $GENERATE_INVOICES = self::Generate_invoices($request->subscription_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'new');
                                    }

                                    // cek apabila pembelian produk harus menggunakan deposit
                                    if($subs->deposit_payment == 1) {
                                        
                                        // auto potong dari saldo deposit dan update invoices menjadi paid dan create transaction
                                        UserInvoices::where('id', $GENERATE_INVOICES)
                                            ->update([
                                                'status_id' => 1036,
                                                'payment_method' => 'Deposit'
                                            ]);

                                        $TRANSACTION_NUMBER = IdGenerator::generate(['table' => 'user_invoices_transaction', 'field' => 'trx_number', 'length' => 9, 'prefix' => 'TRX-']);

                                        $invoices_id = UserInvoicesItem::where('order_id', $request->order_id)->value('invoice_id');
                                        $amount_invoices = UserInvoices::where('id', $invoices_id)->value('total');

                                        // Create transaction ke user_invoices_transaction
                                        UserInvoicestransaction::create([
                                            'trx_number' => $TRANSACTION_NUMBER,
                                            'invoice_id' => $GENERATE_INVOICES,
                                            'currency' => 'IDR',
                                            'amount_in' => $amount_invoices,
                                            'gateway' => 'Deposit',
                                            'payment_status' => 'Paid',
                                            'reseller_id' => 1,
                                            'trx_date' => now(),
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]);
                                    }

                                    // SEND EMAIL To Customer
                                    self::Send_Invoices_Email($GENERATE_INVOICES, $CUSTOMER);

                                } else {

                                    // apabila ingin terbit tagihan
                                    if ($request->terbit_invoices) {

                                        if($is_product_onetime) {
                                            // generate invoices auto terbit send to customer
                                            $GENERATE_INVOICES = self::Generate_invoices_ondemand($request->subscription_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'renew');
                                            
                                        } else {
                                            // generate invoices auto terbit send to customer
                                            $GENERATE_INVOICES = self::Generate_invoices($request->subscription_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'renew');
                                        }
                                        
                                        // cek apabila pembelian produk harus menggunakan deposit
                                        if($subs->deposit_payment == 1) {
                                            
                                            // auto potong dari saldo deposit dan update invoices menjadi paid dan create transaction
                                            UserInvoices::where('id', $GENERATE_INVOICES)
                                                ->update([
                                                    'status_id' => 1036,
                                                    'payment_method' => 'Deposit'
                                                ]);

                                            $TRANSACTION_NUMBER = IdGenerator::generate(['table' => 'user_invoices_transaction', 'field' => 'trx_number', 'length' => 9, 'prefix' => 'TRX-']);
                                                
                                            $invoices_id = UserInvoicesItem::where('order_id', $request->order_id)->value('invoice_id');
                                            $amount_invoices = UserInvoices::where('id', $invoices_id)->value('total');

                                            // Create transaction ke user_invoices_transaction
                                            UserInvoicestransaction::create([
                                                'trx_number' => $TRANSACTION_NUMBER,
                                                'invoice_id' => $GENERATE_INVOICES,
                                                'currency' => 'IDR',
                                                'amount_in' => $amount_invoices,
                                                'gateway' => 'Deposit',
                                                'payment_status' => 'Paid',
                                                'reseller_id' => 1,
                                                'trx_date' => now(),
                                                'created_at' => now(),
                                                'updated_at' => now()
                                            ]);
                                        }

                                        // SEND EMAIL To Customer
                                        self::Send_Invoices_Email($GENERATE_INVOICES, $CUSTOMER);

                                    }

                                }

                                    
                                    
                                // Set Notification
                                $params_notif = [
                                    "subject" => "Set Active Subscription",
                                    "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan aktivasi layanan dengan nomor layanan ' . $SUBSCRIPTION_NUMBER,
                                    "group_id" => "1"
                                ];
                                    
                                // notif to finance
                                $notif_finance = app(AdminController::class)->Create_notification('4', $params_notif);

                                // notif to noc
                                $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);

                            }


                        } else {
                            $stats = 'failed';
                            $message = 'CSID Not registerd on mikrotik';
                        }

                    } else {
                        $stats = 'failed';
                        $message = 'Failed set active subscription, can not connect to mikrotik';
                    }

                } else {
                    $stats = 'failed';
                    $message = 'Failed set active subscription, router not set in project area';
                }

            } else {
                $stats = 'failed';
                $message = 'Failed set active subscription, project area not set';
            }

        } else {
            $CUSTOMER_ID = $subs->customer_id;
            $COMPLETE_DATE = $subs->complete_date;
            $SUBSCRIPTION_NUMBER = $subs->subscription_number;

            if (empty($COMPLETE_DATE)) {

                $Update = UserSubscription::where('id', $request->subscription_id)->update([
                    'complete_date' => $request->date_live,
                ]);

            } else {

                $Update = UserSubscription::where('id', $request->subscription_id)->update([
                    'reactive_date' => $request->date_live,
                ]);

            }

            $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();

            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                'status_id' => 1001
            ]);

            // get billing account
            $NEW_BILLING_NUMBER = UserSubscription::query()->where('id', (int)$request->subscription_id)->first()->billing_account;

            $COUNT_INVOICES = UserInvoicesitem::query()->where('billing_account', $NEW_BILLING_NUMBER)->count();
                
            // apabila belum ada invoices // generate invoices register
            if ($COUNT_INVOICES == 0) {

                // generate invoices auto terbit send to customer
                $GENERATE_INVOICES = self::Generate_invoices_Corporate($subs->order_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'new');

                // jika layanan semuanya sudah aktif
                if ($GENERATE_INVOICES > 0) {
                    // SEND EMAIL To Customer
                    self::Send_Invoices_Email($GENERATE_INVOICES, $CUSTOMER);
                }

            } else {

                // apabila ingin terbit tagihan
                if ($request->terbit_invoices) {

                    // generate invoices auto terbit send to customer
                    $GENERATE_INVOICES = self::Generate_invoices_Corporate($subs->order_id, $CUSTOMER_ID, $request->date_live, $NEW_BILLING_NUMBER, 'renew');

                    // jika layanan semuanya sudah aktif
                    if ($GENERATE_INVOICES > 0) {
                        // SEND EMAIL To Customer
                        self::Send_Invoices_Email($GENERATE_INVOICES, $CUSTOMER);
                    }

                }

            }

            $stats = 'success';
            $message = 'Subscription has been activated';
            
            // Set Notification
            $params_notif = [
                "subject" => "Set Active Subscription",
                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan aktivasi layanan dengan nomor layanan ' . $SUBSCRIPTION_NUMBER,
                "group_id" => "1"
            ];
                
            // notif to finance
            $notif_finance = app(AdminController::class)->Create_notification('4', $params_notif);

            // notif to noc
            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set Active Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to ' . $request->date_live . ' with status active subscription, with subscribtion id :' . $request->subscription_id . ', response: ' . $message,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);

    }


    public function set_deactive(Request $request)
    {

        $subs = UserSubscription::query()
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.id', (int)$request->subscription_id)->first();

        $CUSTOMER = Customer::query()->where('id', $subs->customer_id)->first();
        if ($subs->product_scope == "retail") {
            $api = new RouterosAPI();

            $SUBSCRIPTION = UserSubscription::query()->where('id', (int)$request->subscription_id)->first();
            $AREA_ID = OrderProject::query()->where('order_id', $request->order_id)->first();

            if ($AREA_ID != null) {

                $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                if ($ROUTER_ID->router_id != '') {

                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();

                    // connect ot mikrotik
                    if ($api->connect($router->ipaddress, $router->username, $router->password)) {

                        // jika product onetime
                            $is_product_onetime = SiteProductPrice::where('product_id', $subs->product_id)
                                                ->where('payment_type', 'onetime')
                                                ->exists();
              
                            // jika product onetime, daftarkan CID ke mikrotik
                            // jika product bukan onetime, daftarkan CSID ke mikrotik
                            if($is_product_onetime) {
                                $SUBSCRIPTION_NUMBER = $CUSTOMER->customer_number;
                            } else {
                                $SUBSCRIPTION_NUMBER = $SUBSCRIPTION->subscription_number;
                            }
                        
                        // get secret
                        $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER]));

                        if (!empty($secret)) {

                            // deactive secret, change profile to isolir
                            $params = array_merge(['password' => $secret['0']['password']], [
                                '.id' => $secret['0']['.id'],
                                'name' => $secret['0']['name'],
                                'service' => $secret['0']['service'],
                                'profile' => 'profile-isolir',
                                'disabled' => 'false',
                            ]);

                            $api->comm('/ppp/secret/set', $params);

                            $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER]));

                            if ($crosscek[0]['profile'] == 'profile-isolir') {

                                // get connection
                                $arrID = $api->comm("/ppp/active/getall", array(".proplist" => ".id", "?name" => $SUBSCRIPTION_NUMBER));

                                if (!empty($arrID)) { 
                                    
                                    // reset connection
                                    $api->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"], ));

                                }

                                $stats = 'success';
                                $message = 'Subscription has been deactivated, secret has been change profile isolir on mikrotik';

                                $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                    'status_id' => 1002,
                                    'suspend_reason' => $request->deactive_reason,
                                    'deactive_date' => now(),
                                ]);
        
                                // notif email
                                $response = Http::withToken(env('BACKEND_TOKEN'))
                                    ->post(env('BACKEND_URL') . '/email/send', [
                                        'action' => 'Deactive Subscription',
                                        'send_to' => $CUSTOMER->customer_email,
                                        'name' => $CUSTOMER->customer_name,
                                    ]);
        
                                // Set Notification
                                $params_notif = [
                                    "subject" => "Set Deactive Subscription",
                                    "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan deaktivasi layanan dengan nomor layanan ' . $SUBSCRIPTION->subscription_number,
                                    "group_id" => "1"
                                ];
                                        
                                // notif to noc
                                $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);
                                
                                // notif to billing
                                $notif_billing = app(AdminController::class)->Create_notification('4', $params_notif);

                            } else {

                                $stats = 'failed';
                                $message = 'Failed deactive subscription, profile secret not set';

                            }

                            $api->disconnect();

                        } else {
                            $stats = 'failed';
                            $message = 'CSID Not registerd on mikrotik';
                        }

                    } else {
                        $stats = 'failed';
                        $message = 'Failed set deactive subscription, can not connect to mikrotik';
                    }

                } else {
                    $stats = 'failed';
                    $message = 'Failed set deactive subscription, router not set in project area';
                }

            } else {
                $stats = 'failed';
                $message = 'Failed set deactive subscription, project area not set';
            }

        } else {
            $stats = 'success';
            $message = 'Subscription has been deactivated, secret has been change profile isolir on mikrotik';

            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                'status_id' => 1002,
                'suspend_reason' => $request->deactive_reason,
                'deactive_date' => now(),
            ]);

            // notif email
            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/email/send', [
                    'action' => 'Deactive Subscription',
                    'send_to' => $CUSTOMER->customer_email,
                    'name' => $CUSTOMER->customer_name,
                ]);

            // Set Notification
            $params_notif = [
                "subject" => "Set Deactive Subscription",
                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan deaktivasi layanan dengan nomor layanan ' . $subs->subscription_number,
                "group_id" => "1"
            ];
                    
            // notif to noc
            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);
            
            // notif to billing
            $notif_billing = app(AdminController::class)->Create_notification('4', $params_notif);

        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set Deactive Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to deactivated subscription, with subscribtion id :' . $request->subscription_id . ', reason: ' . $request->deactive_reason . ', response: ' . $message,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);

    }


    public function set_inprogress(Request $request)
    {

        $subs = UserSubscription::query()
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.id', (int)$request->subscription_id)->first();

        // cek pembelian produk ambil dari deposit atau tidak
        if($subs->deposit_payment == 1) {

            //cek saldo deposit
            $deposit = DepositHelper::getBalance($subs->customer_id);
            $amount_order = UserOrder::where('id', $request->order_id)->value('total');

            // cek apakah saldo deposit cukup
            if($deposit < $amount_order) {
                $stats = 'failed';
                $message = 'Saldo deposit tidak cukup, silahkan arahkan pelanggan untuk melakukan topup deposit';
                return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);
            }

        }

        $CUSTOMER_ID = $subs->customer_id;
        $SUBSCRIPTION_NUMBER = $subs->subscription_number;
        $package_id = $subs->product_id;

        $CUSTOMER = Customer::query()->where('id', (int)$CUSTOMER_ID)->first();

        // Generate CID Customer
        if ($CUSTOMER->customer_number == '') {

            $NEW_CUSTOMER_NUMBER = IdGenerator::generate(['table' => 'customer', 'field' => 'customer_number', 'length' => 11, 'prefix' => 'CID-']);

            $GENERATE = Customer::where('id', $CUSTOMER_ID)->update([
                'customer_number' => $NEW_CUSTOMER_NUMBER
            ]);

        } else {
            $NEW_CUSTOMER_NUMBER = $CUSTOMER->customer_number;
        }

        // apabila baru aktivasi pertama kali
        if ($SUBSCRIPTION_NUMBER == '') {

            $NEW_SUBSCRIPTION_NUMBER = IdGenerator::generate(['table' => 'user_subscription', 'field' => 'subscription_number', 'length' => 12, 'prefix' => 'CSID-']);
            $NEW_BILLING_NUMBER = IdGenerator::generate(['table' => 'user_subscription', 'field' => 'billing_account', 'length' => 11, 'prefix' => 'BID-']);

            // set nomor subscription and billing account
            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                'subscription_number' => $NEW_SUBSCRIPTION_NUMBER,
                'billing_account' => $NEW_BILLING_NUMBER,
                'complete_date' => $request->date_live,
            ]);

        } else {

            $NEW_SUBSCRIPTION_NUMBER = $SUBSCRIPTION_NUMBER;

        }

        // communicate to mikrotik
        if ($subs->product_scope == "retail") {
            // $package_id = UserSubscription::query()->where('id', (int) $request->subscription_id)->first()->product_id;
            $profile_name = SiteProduct::query()->where('id', $package_id)->first()->product_profile;

            if ($profile_name != '') {

                $AREA_ID = OrderProject::query()->where('order_id', $request->order_id)->first();

                if ($AREA_ID != null) {

                    $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                    if ($ROUTER_ID->router_id != '') {

                        // comm integration
                        $api = new RouterosAPI();

                        $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();
                        
                        // connect to mikrotik
                        if ($api->connect($router->ipaddress, $router->username, $router->password)) {

                            $split_number = explode('-', $NEW_SUBSCRIPTION_NUMBER);
                            $password = substr($CUSTOMER->customer_name, 0, 3) . $split_number[1];

                            // jika product onetime
                            $is_product_onetime = SiteProductPrice::where('product_id', $subs->product_id)
                                                ->where('payment_type', 'onetime')
                                                ->exists();
                                                
                            // jika product onetime, daftarkan CID ke mikrotik
                            // jika product bukan onetime, daftarkan CSID ke mikrotik
                            if($is_product_onetime) {
                                $NEW_SUBSCRIPTION_NUMBER = $NEW_CUSTOMER_NUMBER;
                            } else {
                                $NEW_SUBSCRIPTION_NUMBER = $NEW_SUBSCRIPTION_NUMBER;
                            }

                            // create new secret ( new subscription to mikrotik)
                            $params = array_filter([
                                'name' => $NEW_SUBSCRIPTION_NUMBER,
                                'password' => $password,
                                'service' => "pppoe",
                                'profile' => $profile_name,
                                'disabled' => "no",
                                'comment' => $request->comment,
                            ]);

                            $save = $api->comm('/ppp/secret/add', $params);
                            
                            // Tangani error dari Mikrotik (response !trap)
                            if (is_array($save) && isset($save['!trap'])) {
                                $stats = 'failed';
                                $message = 'Failed add new secret on mikrotik: ' . (isset($save['!trap'][0]['message']) ? $save['!trap'][0]['message'] : json_encode($save));
                            } else {
                                $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $NEW_SUBSCRIPTION_NUMBER]));
                                
                                if ($crosscek == []) {

                                    $stats = 'failed';
                                    $message = 'Failed add new secret on mikrotik';

                                } else {

                                    $stats = 'success';
                                    $message = 'Success set in progress, new secret has been add to mikrotik';

                                    $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                        'suspend_reason' => $request->catatan,
                                        'progress_date' => now(),
                                        'status_id' => 1013,
                                    ]);

                                    // Set Notification
                                    $params_notif = [
                                        "subject" => "Set In Progress Subscription",
                                        "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' mengubah status layanan menjadi In Progress dengan nomor layanan ' . $NEW_SUBSCRIPTION_NUMBER,
                                        "group_id" => "1"
                                    ];
                                        
                                    // notif to sales
                                    $notif_sales = app(AdminController::class)->Create_notification('1', $params_notif);

                                }
                            }

                            $api->disconnect();

                        } else {

                            $stats = 'failed';
                            $message = 'Failed set in progress, can not connect to mikrotik';

                        }

                    } else {
                        $stats = 'failed';
                        $message = 'Failed set inprogress subscription, router not set in project area';
                    }

                } else {
                    $stats = 'failed';
                    $message = 'Failed set inprogress subscription, project area not set';
                }

            } else {

                $stats = 'failed';
                $message = 'Failed set in progress, product profile is not set on master product';

            }
        } else {

            $stats = 'success';
            $message = 'Success set in progress';

            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                'suspend_reason' => $request->catatan,
                'progress_date' => now(),
                'status_id' => 1013,
            ]);

            // Set Notification
            $params_notif = [
                "subject" => "Set In Progress Subscription",
                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' mengubah status layanan menjadi In Progress dengan nomor layanan ' . $NEW_SUBSCRIPTION_NUMBER,
                "group_id" => "1"
            ];
                
            // notif to sales
            $notif_sales = app(AdminController::class)->Create_notification('1', $params_notif);
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set In Progress Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to In Progress subscription, with subscribtion id :' . $request->subscription_id . ', response: ' . $message,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);

    }


    public function set_dismentle(Request $request)
    {

        $subs = UserSubscription::query()
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.id', (int)$request->subscription_id)->first();

        if ($subs->product_scope == "retail") {

            $api = new RouterosAPI();

            $SUBSCRIPTION = UserSubscription::query()->where('id', (int)$request->subscription_id)->first();
            $AREA_ID = OrderProject::query()->where('order_id', $request->order_id)->first();


            if ($AREA_ID != null) {

                $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                if ($ROUTER_ID->router_id != '') {

                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();

                    // connect ot mikrotik
                    if ($api->connect($router->ipaddress, $router->username, $router->password)) {
                        
                        // get secret
                        $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION->subscription_number]));

                        if (!empty($secret)) {

                            // deactive secret, change profile to isolir
                            $params = array_merge(['password' => $secret['0']['password']], [
                                '.id' => $secret['0']['.id'],
                                'name' => $secret['0']['name'],
                                'service' => $secret['0']['service'],
                                'profile' => 'profile-isolir',
                                'disabled' => 'true',
                            ]);

                            $api->comm('/ppp/secret/set', $params);

                            $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION->subscription_number]));

                            if ($crosscek['0']['disabled'] == "false") {
                                $stats = 'failed';
                                $message = 'Failed deactive secret on mikrotik';
                            } else {
                                $stats = 'success';
                                $message = 'Subscription has been deactivated, secret has been change profile isolir on mikrotik';
                            }

                            $api->disconnect();

                            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                                'suspend_reason' => $request->catatan,
                                'dismentle_date' => now(),
                                'status_id' => 1012,
                            ]);

                            // Set Notification
                            $params_notif = [
                                "subject" => "Set Deactive Subscription",
                                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan deaktivasi layanan dengan nomor layanan ' . $SUBSCRIPTION->subscription_number,
                                "group_id" => "1"
                            ];
                                
                            // notif to noc
                            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);

                        } else {
                            $stats = 'failed';
                            $message = 'CSID Not registerd on mikrotik';
                        }

                    } else {
                        $stats = 'failed';
                        $message = 'Failed set deactive subscription, can not connect to mikrotik';
                    }

                } else {
                    $stats = 'failed';
                    $message = 'Failed set deactive subscription, router not set in project area';
                }

            } else {
                $stats = 'failed';
                $message = 'Failed set deactive subscription, project area not set';
            }
        } else {
            $Update = UserSubscription::where('id', $request->subscription_id)->update([
                'suspend_reason' => $request->catatan,
                'dismentle_date' => now(),
                'status_id' => 1012,
            ]);

            // Set Notification
            $params_notif = [
                "subject" => "Set Deactive Subscription",
                "message" => auth()->user()->first_name . " " . auth()->user()->last_name . ' baru saja melakukan deaktivasi layanan dengan nomor layanan ' . $SUBSCRIPTION->subscription_number,
                "group_id" => "1"
            ];
                
            // notif to noc
            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);
        }

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set Dismentle Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set status dismentle subscription, with subscribtion id :' . $request->subscription_id,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with($stats, $message);
    }

    // versi 2
    public function Generate_invoices_Corporate($order_id, $customer_id, $date_live, $billing_account, $flag)
    {
        $COUNT_SUBSCRIPTION = UserSubscription::query()->where('order_id', $order_id)->count();
        $COUNT_ACTIVE_SUBSCRIPTION = UserSubscription::query()->where('order_id', $order_id)->where('status_id', "1001")->count();

        // jika semuanya layanan sudah aktif
        if ($COUNT_SUBSCRIPTION == $COUNT_ACTIVE_SUBSCRIPTION) {

            $tax = 11;

            if ($flag == 'new') {
                // $PROMO = UserOrderItem::query()->where('order_id', (int) $SUBSCRIPTION->order_id)->first()->promo;
                $invoice_type = 'register';
            } else {
                // $PROMO = '';
                $invoice_type = 'renew';
            }

            $INVOICES = UserInvoices::create([
                'reseller_id' => session('reseller_id'),
                'invoice_type' => $invoice_type,
                'customer_id' => $customer_id,
                'invoice_date' => Carbon::now(),
                'invoice_duedate' => Carbon::now()->addDays(10),
                'payment_method' => 'Bank Transfer',
                'tax' => $tax,
                'is_publish' => 1,
                'status_id' => 1037,
            ]);

            $sub = UserSubscription::query()->where('order_id', (int)$order_id)->get();

            $free_month = 0;
            $calculation = 0;
            foreach ($sub as $SUBSCRIPTION) {
                $PRODUCT = SiteProduct::query()->where('id', (int)$SUBSCRIPTION->product_id)->first();

                $amount_sub = self::Prorate_calculations($SUBSCRIPTION->amount, $date_live);

                // ITEM PRORATE LAYANAN
                $INVOICES_ITEM = UserInvoicesitem::create([
                    'order_id' => $SUBSCRIPTION->order_id,
                    'billing_account' => $SUBSCRIPTION->billing_account,
                    'invoice_id' => $INVOICES->id,
                    'product_id' => $PRODUCT->id,
                    'item_name' => $PRODUCT->product_name . ' - ' . $PRODUCT->product_plan . ' ' . self::Prorate_period($date_live),
                    'item_type' => $PRODUCT->product_type,
                    'payment_method' => 'Bank Transfer',
                    'tax' => 0,
                    'quantity' => 1,
                    'amount' => $amount_sub,
                ]);

                $calculation = $calculation + $amount_sub;

                // SET NEXT INVOICES
                $Update = UserSubscription::where('id', $SUBSCRIPTION->id)->update([
                    'next_due_date' => self::Next_invoices($SUBSCRIPTION->billingcycle, $date_live, $free_month),
                ]);

            }

            $price_taxs = ($calculation * $tax) / 100;

            // UPDATE SUBTOTAL INVOICES TANPA POTONGAN PROMO
            $Update = UserInvoices::where('id', $INVOICES->id)->update([
                'subtotal' => $calculation,
                'total' => $calculation + $price_taxs,
            ]);

            // PUSH notification
            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/notif/create', [
                    "user" => "customer",
                    "template_id" => 5,
                    "id" => $INVOICES->id,
                    "user_id" => [$customer_id]
                ]);

            return $INVOICES->id;
        } else {
            return 0;
        }

    }

    public function Generate_invoices($subscription_id, $customer_id, $date_live, $billing_account, $flag)
    {

        $SUBSCRIPTION = UserSubscription::query()->where('id', (int)$subscription_id)->first();
        $PRODUCT = SiteProduct::query()->where('id', (int)$SUBSCRIPTION->product_id)->first();
        $PROJECT_AREA = OrderProject::query()->where('order_id', (int)$SUBSCRIPTION->order_id)->first();

        if ($flag == 'new') {
            $PROMO = UserOrderItem::query()->where('order_id', (int)$SUBSCRIPTION->order_id)->first()->promo;
            $invoice_type = 'register';
        } else {
            $PROMO = '';
            $invoice_type = 'renew';
        }

        $FEE = SiteProductPrice::query()->where('product_id', (int)$SUBSCRIPTION->product_id)->first()->setup_fee;
        $PAYMENT_TYPE = SiteProductPrice::query()->where('product_id', (int)$SUBSCRIPTION->product_id)->first()->payment_type;
        $free_month = 0;

        if($PAYMENT_TYPE == 'recurring') {
            $tax = 11;
            $amount_sub = self::Prorate_calculations($SUBSCRIPTION->amount, $date_live);
            $calculation = 0;
            $price_tax = ($amount_sub * $tax) / 100;
            $total = $amount_sub + $price_tax;
        } else {
            $tax = 11;
            $amount_sub = $SUBSCRIPTION->amount;
            $calculation = 0;
            $price_tax = ($amount_sub * $tax) / 100;
            $total = $amount_sub + $price_tax;
        }
        

        $INVOICES = UserInvoices::create([
            'reseller_id' => session('reseller_id'),
            'invoice_type' => $invoice_type,
            'customer_id' => $customer_id,
            'invoice_date' => Carbon::now(),
            'invoice_duedate' => Carbon::now()->addDays(10),
            'payment_method' => 'Bank Transfer',
            'tax' => $tax,
            'subtotal' => $amount_sub,
            'total' => $total,
            'is_publish' => 1,
            'status_id' => 1037,
        ]);

        // FEE ITEM INVOICES


        $INVOICES_ITEM_FEE = UserInvoicesitem::create([
            'invoice_id' => $INVOICES->id,
            'product_id' => $PRODUCT->id,
            'item_name' => 'Setup Fee',
            'item_type' => $PRODUCT->product_type,
            'payment_method' => 'Bank Transfer',
            'tax' => 0,
            'quantity' => 1,
            'amount' => $FEE,
        ]);

        $setup = ' ';
        $calculation = $calculation + $FEE;


        // ITEM PRORATE LAYANAN

        $INVOICES_ITEM = UserInvoicesitem::create([
            'order_id' => $SUBSCRIPTION->order_id,
            'billing_account' => $billing_account,
            'invoice_id' => $INVOICES->id,
            'product_id' => $PRODUCT->id,
            'item_name' => $PRODUCT->product_name . ' - ' . $PRODUCT->product_plan . ' ' . self::Prorate_period($date_live),
            'item_type' => $PRODUCT->product_type,
            'payment_method' => 'Bank Transfer',
            'tax' => 0,
            'quantity' => 1,
            'amount' => $amount_sub,
        ]);

        $calculation = $calculation + $amount_sub;

        // PROMO ITEM INVOICES

        if ($PROMO != '') {

            $promo_config = Promo::query()->where('promotion_label', $PROMO)->first();

            // if enable free setup
            if ($promo_config->setup_free == 1) {

                $fee_promo = SiteProductPrice::query()->where('product_id', (int)$SUBSCRIPTION->product_id)->first()->setup_fee;

                $setup = '+ Setup';

                $amount_sub = 0;
                $amount_promo = $fee_promo;
                $total_promo = 'Potongan / Discount ( Promo Free Setup )';

            } else {
                $FEE = 0;
            }

            // if promo type "Free Month"
            if ($promo_config->type == 'Free Month') {

                $free_month = $promo_config->subscription_month;
                $amount_sub = $SUBSCRIPTION->amount * $promo_config->subscription_month;
                $amount_promo = $SUBSCRIPTION->amount * $promo_config->value + $FEE;
                $total_promo = 'Potongan / Discount ( Promo Free ' . $promo_config->value . ' Bulan ' . $setup . ')';
                $period_free = $promo_config->period_free;

                $calculation = $calculation + $SUBSCRIPTION->amount * $promo_config->value;

            }

            // if promo type "Percentage"
            if ($promo_config->type == 'Percentage') {
                $free_month = $promo_config->subscription_month;
                $amount_sub = $SUBSCRIPTION->amount * $promo_config->subscription_month;
                $potongan = $amount_sub * $promo_config->value / 100;
                $total_disc = $potongan;
                $amount_promo = $total_disc + $FEE;
                $total_promo = 'Potongan / Discount ( Disc ' . $promo_config->value . ' ' . $setup . ')';
                $period_free = $promo_config->subscription_month;
            }


            // if promo type "Fixed Amount"
            if ($promo_config->type == 'Fixed Amount') {
                $free_month = $promo_config->subscription_month;
                $amount_sub = $SUBSCRIPTION->amount * $promo_config->subscription_month;
                $potongan = $promo_config->value;
                $total_disc = $potongan;
                $amount_promo = $total_disc + $FEE;
                $total_promo = 'Potongan / Discount ( IDR. ' . $amount_promo . ' ' . $setup . ')';
                $period_free = $promo_config->subscription_month;
            }


            // perhitungan period
            if ($promo_config->subscription_month != 0) {

                $INVOICES_ITEM_PROMO = UserInvoicesitem::create([
                    'invoice_id' => $INVOICES->id,
                    'product_id' => $PRODUCT->id,
                    'item_name' => $PRODUCT->product_name . ' - ' . $PRODUCT->product_plan . ' ' . self::Subscription_period($free_month, $date_live),
                    'item_type' => $PRODUCT->product_type,
                    'payment_method' => 'Bank Transfer',
                    'tax' => 0,
                    'quantity' => 1,
                    'amount' => $amount_sub,
                ]);

            }


            // perhitungan promo period
            if ($promo_config->type == 'Free Month') {

                $INVOICES_ITEM_PROMO = UserInvoicesitem::create([
                    'invoice_id' => $INVOICES->id,
                    'product_id' => $PRODUCT->id,
                    'item_name' => $PRODUCT->product_name . ' - ' . $PRODUCT->product_plan . ' Period Free ' . self::Promo_period($period_free, $promo_config->value, $date_live),
                    'item_type' => $PRODUCT->product_type,
                    'payment_method' => 'Bank Transfer',
                    'tax' => 0,
                    'quantity' => 1,
                    'amount' => $SUBSCRIPTION->amount * $promo_config->value,
                ]);

            }
            

            // potongan discount
            $INVOICES_ITEM_PROMO = UserInvoicesitem::create([
                'invoice_id' => $INVOICES->id,
                'product_id' => $PRODUCT->id,
                'item_name' => $total_promo,
                'item_type' => $PRODUCT->product_type,
                'payment_method' => 'Bank Transfer',
                'tax' => 0,
                'quantity' => 1,
                'amount' => $amount_promo,
            ]);

            $calculation = $calculation + $amount_sub;
            $subtotals = $calculation - $amount_promo;
            $price_taxs = ($subtotals * $tax) / 100;

            // UPDATE SUBTOTAL INVOICES TERKAIT POTONGAN PROMO
            $Update = UserInvoices::where('id', $INVOICES->id)->update([
                'subtotal' => $calculation - $amount_promo,
                'total' => $calculation - $amount_promo + $price_taxs,
            ]);

        } else {

            $price_taxs = ($calculation * $tax) / 100;

            // UPDATE SUBTOTAL INVOICES TANPA POTONGAN PROMO
            $Update = UserInvoices::where('id', $INVOICES->id)->update([
                'subtotal' => $calculation,
                'total' => $calculation + $price_taxs,
            ]);

        }
        
        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/notif/create', [
                "user" => "customer",
                "template_id" => 5,
                "id" => $INVOICES->id,
                "user_id" => [$customer_id]
            ]);

        // SET NEXT INVOICES
        $Update = UserSubscription::where('id', $subscription_id)->update([
            'next_due_date' => self::Next_invoices($SUBSCRIPTION->billingcycle, $date_live, $free_month),
        ]);

        return $INVOICES->id;

    }


    public function Generate_invoices_ondemand($subscription_id, $customer_id, $date_live, $billing_account, $flag)
    {

        $SUBSCRIPTION = UserSubscription::query()->where('id', (int)$subscription_id)->first();
        $PRODUCT = SiteProduct::query()->where('id', (int)$SUBSCRIPTION->product_id)->first();
        $PROJECT_AREA = OrderProject::query()->where('order_id', (int)$SUBSCRIPTION->order_id)->first();

        if ($flag == 'new') {
            $PROMO = UserOrderItem::query()->where('order_id', (int)$SUBSCRIPTION->order_id)->first()->promo;
            $invoice_type = 'register';
        } else {
            $PROMO = '';
            $invoice_type = 'renew';
        }
        
        $PAYMENT_TYPE = SiteProductPrice::query()->where('product_id', (int)$SUBSCRIPTION->product_id)->first()->payment_type;
        $free_month = 0;

        if($PAYMENT_TYPE == 'recurring') {
            $tax = 11;
            $total = self::Prorate_calculations($SUBSCRIPTION->amount, $date_live);
            $calculation = 0;
        } else {
            $tax = 11;
            $total = $SUBSCRIPTION->amount;
            $calculation = 0;
        }
        

        $INVOICES = UserInvoices::create([
            'reseller_id' => session('reseller_id'),
            'invoice_type' => $invoice_type,
            'customer_id' => $customer_id,
            'invoice_date' => Carbon::now(),
            'invoice_duedate' => Carbon::now()->addDays(10),
            'payment_method' => 'Deposit',
            'tax' => $tax,
            'subtotal' => $total,
            'total' => $total,
            'is_publish' => 1,
            'status_id' => 1037,
        ]);

        // ITEM LAYANAN INVOICES
            $INVOICES_ITEM = UserInvoicesitem::create([
                'order_id' => $SUBSCRIPTION->order_id,
                'billing_account' => $billing_account,
                'invoice_id' => $INVOICES->id,
                'product_id' => $PRODUCT->id,
                'item_name' => $PRODUCT->product_name . ' - ' . $PRODUCT->product_plan ,
                'item_type' => $PRODUCT->product_type,
                'payment_method' => 'Bank Transfer',
                'tax' => 0,
                'quantity' => 1,
                'amount' => $total,
            ]);

            $calculation = $calculation + $total;

        $price_taxs = ($calculation * $tax) / 100;

        // UPDATE SUBTOTAL INVOICES TANPA POTONGAN PROMO
        $Update = UserInvoices::where('id', $INVOICES->id)->update([
            'subtotal' => $calculation,
            'total' => $calculation + $price_taxs,
        ]);
        
        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/notif/create', [
                "user" => "customer",
                "template_id" => 5,
                "id" => $INVOICES->id,
                "user_id" => [$customer_id]
            ]);

        // SET NEXT INVOICES
        $Update = UserSubscription::where('id', $subscription_id)->update([
            'next_due_date' => self::Next_invoices($SUBSCRIPTION->billingcycle, $date_live, $free_month),
        ]);

        return $INVOICES->id;

    }


    // versi 2 terkait perubahan kebijakan
    public function Prorate_calculations($amount_subscription, $date_live)
    {

        $now = Carbon::parse($date_live);

        $current_month = $now->month;
        $current_year = $now->year;

        $totalDayInMonth = $now->daysInMonth;

        $day_remaining = $now->diffInDays($current_year . '-' . $current_month . '-' . $totalDayInMonth) + 1;

        $cost_per_day = $amount_subscription / $totalDayInMonth;

        $prorate = $day_remaining * $cost_per_day;

        return $prorate;

    }


    // Versi 2 terkait perubahan kebijakan perhitungan prorate
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

    // versi 2
    public function Subscription_period($free_month, $date_live)
    {

        $now = Carbon::parse($date_live);

        if ($now->month == 12) {
            $current_year = $now->year + 1;
        } else {
            $current_year = $now->year;
        }

        $current_month = $now->addMonths(1);

        $next = Carbon::parse($date_live);
        $next_month = $next->addMonths($free_month);

        if ($next->month == 12) {
            $next_year = $next->year + 1;
        } else {
            $next_year = $next->year;
        }

        $totalDayInMonth = $next->daysInMonth;

        $period_start = $current_year . '/' . $current_month->month . '/01';

        $period_end = $next_year . '/' . $next_month->month . '/' . $totalDayInMonth;

        $period = '( ' . $period_start . ' - ' . $period_end . ' )';

        return $period;

    }


    // versi 2
    public function Promo_period($period_free, $free_month, $date_live)
    {

        $now = Carbon::parse($date_live)->addMonths($period_free);

        if ($now->month == 12) {
            $current_year = $now->year + 1;
        } else {
            $current_year = $now->year;
        }

        $current_month = $now->month;

        $next = $now->addMonths($free_month);

        if ($next->month == 12) {
            $next_year = $next->year + 1;
        } else {
            $next_year = $next->year;
        }

        $totalDayInMonth = $next->daysInMonth;

        $period_start = $current_year . '/' . $current_month . '/01';

        $period_end = $next_year . '/' . $next->month . '/' . $totalDayInMonth;

        $period = '( ' . $period_start . ' - ' . $period_end . ' )';

        return $period;

    }


    // versi 2
    public function Next_invoices($billing_cycle, $date_live, $free_month)
    {


        $now = Carbon::parse($date_live);
        $next_month = '';
        // echo $billing_cycle;
        // echo $date_live;
        // die($free_month);

        // tidak ada promo
        if ($free_month == 0 || !$free_month) {

            if ($billing_cycle == 'Daily' || $billing_cycle == 'daily') {
                $now = $now->addHours(24);
            }

            if ($billing_cycle == 'Monthly' || $billing_cycle == 'monthly') {
                $now = $now->addMonths(1);
            }

            if ($billing_cycle == 'Quarterly' || $billing_cycle == 'quarterly') {
                $now = $now->addMonths(3);
            }

            if ($billing_cycle == 'Yearly' || $billing_cycle == 'yearly') {
                $now = $now->addYears(1);
            }

        } else {
            $next_M = $free_month + 1;
            $now = $now->addMonths($next_M);
        }

        if ($now->month == 12) {
            $current_year = $now->year + 1;
        } else {
            $current_year = $now->year;
        }

        // $month = $next_month->month; // kosong, gak keambil bulannya
        $month = $now->format('m');

        $next_invoices = $current_year . '-' . $month . '-01';

        return $next_invoices;

    }





    public function Send_Invoices_Email($invoices_id, $customer)
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

        $invoices_items_promo = null;

        if (!empty($INVOICES_ITEM_PROMO)) {
            foreach ($INVOICES_ITEM_PROMO as $itemd) {

                $invoices_items_promo[$itemd->id] = [
                    "item_name" => $itemd->item_name,
                    "item_amount" => 'IDR. - ' . number_format($itemd->amount, 0)
                ];

            }
        }

        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/email/send', [
                'action' => 'Terbit Tagihan',
                'send_to' => $customer->customer_email,
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



    public function set_canceled(Request $request)
    {

        $Update = UserSubscription::where('id', $request->subscription_id)->update([
            'status_id' => 1008,
            'suspend_reason' => $request->cancel_reason . ' Catatan : ' . $request->catatan,
            'cancel_date' => now(),
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set Active Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to canceled subscription, with subscribtion id :' . $request->subscription_id . 'reason: ' . $request->cancel_reason,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Subscription has been canceled');

    }


    public function set_terminated(Request $request)
    {

        $Update = UserSubscription::where('id', $request->subscription_id)->update([
            'status_id' => 1011,
            'suspend_reason' => $request->terminate_reason,
            'termination_date' => now(),
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'subscription',
            'module_id' => $request->subscription_id,
            'log_label' => 'Set Terminate Subscription',
            'log_entry' => auth()->user()->first_name . ' ' . auth()->user()->last_name . ' has been set to terminate subscription, with subscribtion id :' . $request->subscription_id . 'reason: ' . $request->terminate_reason,
            'log_user_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return redirect('/console/salesorder/detail/' . $request->order_id)->with('success', 'Subscription has been terminated');

    }



    public function Statistic_perday(Request $request)
    {

        if ($request->filter_day) {
            $day = $request->filter_day;
        } else {
            $day = now();
        }

        $products = SiteProduct::query()
            ->where('site_product.is_hidden', 0)
            ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
            ->select('site_product.id', 'site_product_group.product_group_headline', 'site_product.product_name', 'site_product.product_plan')
            ->get();

        $stats_perday = [];

        foreach ($products as $product) {

            $stats_perday[$product->id] = [
                'product_group' => $product->product_group_headline,
                'product_name' => $product->product_name,
                'product_plan' => $product->product_plan,
                'product_pending' => self::Perday_pending($product->id, $day),
                'product_activated' => self::Perday_activated($product->id, $day),
                'product_cancel' => self::Perday_canceled($product->id, $day),
                'product_terminated' => self::Perday_terminated($product->id, $day),
                'product_dismentle' => self::Perday_dismentle($product->id, $day),
            ];

        }

        return view('page/statistic/subscription-perday', [
            'stats_perday' => $stats_perday
        ]);

    }



    public function Perday_pending($product_id, $date)
    {

        $count = UserSubscription::query()->where('product_id', $product_id)->whereDate('subscription_date', $date)->omniFilter()->count();
        return $count;
    }

    public function Perday_activated($product_id, $date)
    {

        $count = UserSubscription::query()->where('product_id', $product_id)->whereDate('complete_date', $date)->omniFilter()->count();
        return $count;
    }

    public function Perday_canceled($product_id, $date)
    {

        $count = UserSubscription::query()->where('product_id', $product_id)->whereDate('cancel_date', $date)->omniFilter()->count();
        return $count;
    }

    public function Perday_terminated($product_id, $date)
    {

        $count = UserSubscription::query()->where('product_id', $product_id)->whereDate('termination_date', $date)->omniFilter()->count();
        return $count;
    }

    public function Perday_dismentle($product_id, $date)
    {

        $count = UserSubscription::query()->where('product_id', $product_id)->whereDate('dismentle_date', $date)->omniFilter()->count();
        return $count;
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

        $products = SiteProduct::query()
            ->where('site_product.is_hidden', 0)
            ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
            ->select('site_product.id', 'site_product_group.product_group_headline', 'site_product.product_name', 'site_product.product_plan')
            ->get();

        $stats_permonth = [];

        foreach ($products as $product) {

            $stats_permonth[$product->id] = [
                'product_group' => $product->product_group_headline,
                'product_name' => $product->product_name,
                'product_plan' => $product->product_plan,
                'product_pending' => self::Permonth_pending($product->id, $month, $year),
                'product_activated' => self::Permonth_activated($product->id, $month, $year),
                'product_cancel' => self::Permonth_canceled($product->id, $month, $year),
                'product_terminated' => self::Permonth_terminated($product->id, $month, $year),
                'product_dismentle' => self::Permonth_dismentle($product->id, $month, $year),
            ];

        }

        return view('page/statistic/subscription-permonth', [
            'stats_permonth' => $stats_permonth,
            'month' => self::convert_month_name($month),
            'year' => $year
        ]);

    }


    public function Permonth_pending($product_id, $date, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereMonth('subscription_date', $date)
            ->whereYear('subscription_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Permonth_activated($product_id, $date, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereMonth('complete_date', $date)
            ->whereYear('complete_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Permonth_canceled($product_id, $date, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereMonth('cancel_date', $date)
            ->whereYear('cancel_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }


    public function Permonth_terminated($product_id, $date, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereMonth('termination_date', $date)
            ->whereYear('termination_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Permonth_dismentle($product_id, $date, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereMonth('dismentle_date', $date)
            ->whereYear('dismentle_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }



    public function Statistic_peryear(Request $request)
    {

        $now = Carbon::now();

        if ($request->filter_year) {
            $year = $request->filter_year;
        } else {
            $year = $now->year;
        }

        $products = SiteProduct::query()
            ->where('site_product.is_hidden', 0)
            ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
            ->select('site_product.id', 'site_product_group.product_group_headline', 'site_product.product_name', 'site_product.product_plan')
            ->get();

        $stats_peryear = [];

        foreach ($products as $product) {

            $stats_peryear[$product->id] = [
                'product_group' => $product->product_group_headline,
                'product_name' => $product->product_name,
                'product_plan' => $product->product_plan,
                'product_pending' => self::Peryear_pending($product->id, $year),
                'product_activated' => self::Peryear_activated($product->id, $year),
                'product_cancel' => self::Peryear_canceled($product->id, $year),
                'product_terminated' => self::Peryear_terminated($product->id, $year),
                'product_dismentle' => self::Peryear_dismentle($product->id, $year),
            ];

        }

        return view('page/statistic/subscription-peryear', [
            'stats_peryear' => $stats_peryear,
            'year' => $year
        ]);

    }


    public function Peryear_pending($product_id, $year)
    {

        $count = UserSubscription::query()
            ->where('product_id', $product_id)
            ->whereYear('subscription_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Peryear_activated($product_id, $year)
    {

        $count = UserSubscription::query()->where('status_id', 1001)
            ->where('product_id', $product_id)
            ->whereYear('complete_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Peryear_canceled($product_id, $year)
    {

        $count = UserSubscription::query()->where('status_id', 1008)
            ->where('product_id', $product_id)
            ->whereYear('cancel_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Peryear_terminated($product_id, $year)
    {

        $count = UserSubscription::query()->where('status_id', 1011)
            ->where('product_id', $product_id)
            ->whereYear('termination_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Peryear_dismentle($product_id, $year)
    {

        $count = UserSubscription::query()->where('status_id', 1012)
            ->where('product_id', $product_id)
            ->whereYear('dismentle_date', $year)
            ->omniFilter()
            ->count();
        return $count;
    }




    public function Statistic_status(Request $request)
    {

        $products = SiteProduct::query()
            ->where('site_product.is_hidden', 0)
            ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
            ->select('site_product.id', 'site_product_group.product_group_headline', 'site_product.product_name', 'site_product.product_plan')
            ->get();

        $stats_status = [];

        foreach ($products as $product) {

            $stats_status[$product->id] = [
                'product_group' => $product->product_group_headline,
                'product_name' => $product->product_name,
                'product_plan' => $product->product_plan,
                'product_pending' => self::Status_pending($product->id),
                'product_activated' => self::Status_activated($product->id),
                'product_cancel' => self::Status_canceled($product->id),
                'product_terminated' => self::Status_terminated($product->id),
                'product_inprogress' => self::Status_inprogress($product->id),
                'product_dismentle' => self::Status_dismentle($product->id),
            ];

        }

        return view('page/statistic/subscription-status', [
            'stats_status' => $stats_status
        ]);

    }

    public function Status_pending($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1005)
            ->where('product_id', $product_id)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Status_activated($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1001)
            ->where('product_id', $product_id)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Status_canceled($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1008)
            ->where('product_id', $product_id)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Status_terminated($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1011)
            ->where('product_id', $product_id)
            ->count();
        return $count;
    }

    public function Status_inprogress($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1013)
            ->where('product_id', $product_id)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Status_dismentle($product_id)
    {

        $count = UserSubscription::query()->where('status_id', 1012)
            ->where('product_id', $product_id)
            ->omniFilter()
            ->count();
        return $count;
    }

    public function Auto_suspend()
    {

        $subscription = UserInvoices::query()
            ->join('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
            ->join('user_subscription', 'user_subscription.order_id', '=', 'user_invoices_item.order_id')
            ->where('user_invoices.status_id', '1037')
            ->where('user_invoices.is_publish', '1')
            ->whereMonth('user_invoices.invoice_duedate', Carbon::now()->month)
            ->whereYear('user_invoices.invoice_duedate', Carbon::now()->year)
            ->whereDay('user_invoices.invoice_duedate', Carbon::now()->subDays(1))
            ->where('user_subscription.status_id', '1001')
            ->select('user_subscription.id as subscription_id')
            ->get();

        foreach ($subscription as $sub) {
            AutosuspendJob::dispatch($sub->subscription_id)->onQueue('default');
        }

        return 'success';

    }

    public function Auto_deactivated()
    {

        // Cron berjalan tiap jam: cek subscription dengan expired_date jatuh pada jam berjalan (window startOfHour–endOfHour) dan hanya product dengan deposit_payment = 1
        $now = Carbon::now(config('app.timezone'));
        $start = $now->copy()->startOfHour();
        $end   = $now->copy()->endOfHour();

        $subscription = UserSubscription::query()
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.status_id', '1001') // hanya yang aktif
            ->where('site_product.deposit_payment', '1')
            ->whereNotNull('user_subscription.expired_date')
            ->whereBetween('user_subscription.expired_date', [$start, $end])
            ->select('user_subscription.id as subscription_id')
            ->orderBy('user_subscription.expired_date') // proses yang paling dekat dulu
            ->get();

        foreach ($subscription as $sub) {
            echo $sub->subscription_id . '<br>';
            AutodeactiveJob::dispatch($sub->subscription_id)->onQueue('default');
        }

        return 'success';

    }

    public function Auto_activated()
    {
        $subscription = UserSubscription::query()
            ->join('user_order', 'user_order.id', '=', 'user_subscription.order_id')
            ->join('user_order_item', 'user_order_item.order_id', '=', 'user_order.id')
            ->join('user_order_field as tanggal_field', function($join) {
                $join->on('tanggal_field.order_item_id', '=', 'user_order_item.id')
                     ->where('tanggal_field.field', '=', 'tanggal-aktivasi');
            })
            ->join('user_order_field as jam_field', function($join) {
                $join->on('jam_field.order_item_id', '=', 'user_order_item.id')
                     ->where('jam_field.field', '=', 'jam-aktivasi');
            })
            ->join('site_product', 'site_product.id', '=', 'user_subscription.product_id')
            ->where('user_subscription.status_id', '1005')
            ->where('site_product.deposit_payment', '1')
            ->where('tanggal_field.value', '=', Carbon::now()->format('Y-m-d'))
            ->whereRaw('CAST(jam_field.value AS UNSIGNED) = ?', [Carbon::now(config('app.timezone'))->hour])
            ->select('user_subscription.id as subscription_id')
            ->get();

        foreach ($subscription as $sub) {
            echo $sub->subscription_id . '<br>';
            AutoactiveJob::dispatch($sub->subscription_id)->onQueue('default');
        }
        return 'success';
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

    public function List_subs(Request $request)
    {
        $count_subs = UserSubscription::query()->where('status_id', '!=', '1009')->omniFilter()->count();
        $count_activated = UserSubscription::query()->where('status_id', '1001')->omniFilter()->count();
        $count_deactivated = UserSubscription::query()->where('status_id', '1002')->omniFilter()->count();
        $count_pending = UserSubscription::query()->where('status_id', '1005')->omniFilter()->count();
        $count_inprogress = UserSubscription::query()->where('status_id', '1013')->omniFilter()->count();
        $count_canceled = UserSubscription::query()->where('status_id', '1008')->omniFilter()->count();
        // $count_deleted = UserSubscription::query()->where('status_id', '1009')->count();
        $count_terminated = UserSubscription::query()->where('status_id', '1011')->omniFilter()->count();

        $subs = UserSubscription::latest();
        $subs->select('customer.customer_name', 'user_subscription.billing_account', 'subscription_status.status_name', 'user_subscription.order_id', 'user_subscription.id', 'user_subscription.subscription_number', 'user_subscription.billingcycle', 'user_subscription.amount', DB::raw('DATE(user_subscription.complete_date) AS complete_date'), 'site_product.product_name', 'site_product.product_plan', 'site_product.product_type', 'user_subscription.created_at');
        $subs->leftJoin('site_product', 'site_product.id', '=', 'user_subscription.product_id');
        $subs->leftJoin('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id');
        $subs->leftJoin('customer', 'customer.id', '=', 'user_subscription.customer_id');
        $subs->where('user_subscription.status_id', '!=', '1009');

        if ($request->year) {
            $subs->whereYear('user_subscription.created_at', $request->year);
        }
        if ($request->month) {
            $subs->whereMonth('user_subscription.created_at', $request->month);
        }
        if ($request->filter_area) {
            $subs->where('user_subscription.status_id', '1001');
            $subs->join('order_project', 'user_subscription.order_id', '=', 'order_project.order_id');
            $subs->where('project_id', $request->filter_area);
            $subs->whereNotNull('order_project.id');
        }

        if ($request->subscription_status != '') {
            $subs->where('user_subscription.status_id', $request->subscription_status);
        }

        if ($request->product != '') {
            $subs->where('user_subscription.product_id', $request->product);
        }

        if ($request->activation_date != '') {
            $subs->whereDate('user_subscription.complete_date', $request->activation_date);
        }

        if ($request->subscription_number != '') {
            $subs->where('user_subscription.subscription_number', $request->subscription_number);
        }

        if ($request->customer_name != '') {
            $subs->where('customer.customer_name', 'LIKE', '%' . $request->customer_name . '%');
        }

        if ($request->sales_pic) {
            $subs->join('user_order', 'user_subscription.order_id', '=', 'user_order.id');
            $subs->where('user_order.sales_id', $request->sales_pic);
        }

        $subs->omniFilter();

        $products = SiteProduct::query()
            ->where('site_product.is_hidden', 0)
            ->join('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
            ->select('site_product.id', 'site_product_group.product_group_headline', 'site_product.product_name', 'site_product.product_plan')
            ->get();

        $sales_pic = UserRole::query()->select('user.id', 'user.first_name', 'user.last_name')->where('user_role.role_id', (int)1)->where('user.is_active', (int)1)->join('user', 'user.id', '=', 'user_role.user_id')->get();

        return view('page/subscription', [
            'count_subs' => $count_subs,
            'count_activated' => $count_activated,
            'count_deactivated' => $count_deactivated,
            'count_pending' => $count_pending,
            'count_inprogress' => $count_inprogress,
            'count_canceled' => $count_canceled,
            // 'count_deleted' => $count_deleted,
            'count_terminated' => $count_terminated,
            'products' => $products,
            'sales_pic' => $sales_pic,
            'data' => $subs->paginate(30)->withQueryString(),
        ]);
    }

    public function StatisticArea_peryear(Request $request)
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

            $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(user_subscription.id) as `data`'), DB::raw('YEAR(user_subscription.created_at) year, MONTH(user_subscription.created_at) month'))
                ->leftJoin('user_subscription', 'user_subscription.order_id', '=', 'order_project.order_id')
                ->where('user_subscription.status_id', '1001')->whereYear('user_subscription.created_at', $year)
                ->where('project_id', $request->filter_area)
                ->omniFilter()
                ->groupby('year', 'month')
                ->get(); //->toArray();

        } else {

            $total_cust_group_by_month = OrderProject::query()
                ->select(DB::raw('count(user_subscription.id) as `data`'), DB::raw('YEAR(user_subscription.created_at) year, MONTH(user_subscription.created_at) month'))
                ->leftJoin('user_subscription', 'user_subscription.order_id', '=', 'order_project.order_id')
                ->where('user_subscription.status_id', '1001')->whereYear('user_subscription.created_at', $year)
                ->omniFilter()
                ->groupby('year', 'month')
                ->get(); //->toArray();

        }

        $month = array(array('month' => 'Januari'), array('month' => 'Februari'), array('month' => 'Maret'), array('month' => 'April'), array('month' => 'Mei'), array('month' => 'Juni'), array('month' => 'Juli'), array('month' => 'Agustus'), array('month' => 'September'), array('month' => 'Oktober'), array('month' => 'November'), array('month' => 'Desember'));

        foreach ($total_cust_group_by_month as $dat) {
            $dataQuery[$dat->month] = array('total' => $dat->data, 'bln' => $dat->month);
        }

        $total_per_year = 0;
        $month_list = array();
        foreach ($month as $key => $d) {
            $a = 0;
            if (isset($dataQuery[$key + 1]['bln'])) {
                $a = $dataQuery[$key + 1]['total'];
            }
            $month_map[] = array('month' => $d['month'], 'count' => $a);
            if ($a > 0) {
                $month_list[] = array('number' => $key + 1, 'month' => $d['month'], 'count' => $a);
            }

            $total_per_year += $a;
        }

        return view('page/stat-byarea-subs', [
            'total_paid' => $total_per_year,
            'statistic_perday' => json_encode($month_map),
            'month_list' => $month_list,
            'year' => $year,
            'filter_area' => $request->filter_area,
            'initProj' => $initProj,
            'initYear' => $initYear,
        ]);

    }

    public function StatisticRev_peryear(Request $request)
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
            // total revenue renewal
            // $total_cust_group_by_month = OrderProject::query()
            $total_rev_renew_group_by_month = OrderProject::query()
            // ->select('order_project.order_id', 'user_invoices_item.invoice_id', 'user_invoices_item.amount')
                ->select(DB::raw('sum(user_invoices_item.amount) as `data`'), DB::raw('YEAR(trx_date) year, MONTH(trx_date) month'))
                ->leftJoin('user_invoices_item', 'user_invoices_item.order_id', '=', 'order_project.order_id')
                ->leftJoin('user_invoices', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
                ->leftJoin('user_invoices_transaction', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
                ->where('user_invoices.status_id', '1036')->whereYear('user_invoices_transaction.trx_date', $year)
                ->where('user_invoices.invoice_type', 'renew')
                ->where('project_id', $request->filter_area)
                ->groupby('year', 'month')
                ->get(); //->toArray();

            // total revenue register
            // $total_cust_group_by_month = OrderProject::query()
            $total_rev_reg_group_by_month = OrderProject::query()
            // ->select('order_project.order_id', 'user_invoices_item.invoice_id', 'user_invoices_transaction.amount_in')
                ->select(DB::raw('sum(user_invoices_transaction.amount_in) as `data`'), DB::raw('YEAR(trx_date) year, MONTH(trx_date) month'))
                ->leftJoin('user_invoices_item', 'user_invoices_item.order_id', '=', 'order_project.order_id')
                ->leftJoin('user_invoices', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
                ->leftJoin('user_invoices_transaction', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
                ->where('user_invoices.status_id', '1036')->whereYear('user_invoices_transaction.trx_date', $year)
                ->where('user_invoices.invoice_type', 'register')
                ->where('project_id', $request->filter_area)
                ->groupby('year', 'month')
                ->get(); //->toArray();

            // dd($total_rev_reg_group_by_month);
        } else {
            // total revenue renewal
            $total_rev_renew_group_by_month = UserInvoices::query()
                ->select(DB::raw('sum(user_invoices_item.amount) as `data`'), DB::raw('YEAR(trx_date) year, MONTH(trx_date) month'))
                ->leftJoin('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
                ->leftJoin('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id')
                ->leftJoin('user_invoices_transaction', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
                ->where('user_invoices.status_id', '1036')->whereYear('user_invoices_transaction.trx_date', $year)
                ->where('user_invoices.invoice_type', 'renew')
                ->groupby('year', 'month')
                ->omniFilter()
            // ->where('user_invoices.reseller_id', session('reseller_id'))
                ->get(); //->toArray();

            // total revenue register
            $total_rev_reg_group_by_month = UserInvoices::query()
                ->select(DB::raw('sum(user_invoices_transaction.amount_in) as `data`'), DB::raw('YEAR(trx_date) year, MONTH(trx_date) month'))
                ->leftJoin('user_invoices_item', 'user_invoices_item.invoice_id', '=', 'user_invoices.id')
                ->leftJoin('order_project', 'user_invoices_item.order_id', '=', 'order_project.order_id')
                ->leftJoin('user_invoices_transaction', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
                ->where('user_invoices.status_id', '1036')->whereYear('user_invoices_transaction.trx_date', $year)
                ->where('user_invoices.invoice_type', 'register')
                ->groupby('year', 'month')
                ->omniFilter()
            // ->where('user_invoices.reseller_id', session('reseller_id'))
                ->get(); //->toArray();
        }

        $month = array(array('month' => 'Januari'), array('month' => 'Februari'), array('month' => 'Maret'), array('month' => 'April'), array('month' => 'Mei'), array('month' => 'Juni'), array('month' => 'Juli'), array('month' => 'Agustus'), array('month' => 'September'), array('month' => 'Oktober'), array('month' => 'November'), array('month' => 'Desember'));

        foreach ($total_rev_renew_group_by_month as $dat) {
            $dataQueryRenew[$dat->month] = array('total' => $dat->data, 'bln' => $dat->month);
        }

        foreach ($total_rev_reg_group_by_month as $dat) {
            $dataQueryReg[$dat->month] = array('total' => $dat->data, 'bln' => $dat->month);
        }

        $total_per_year = 0;
        $month_list = array();
        foreach ($month as $key => $d) {
            $totalRenew = 0;
            $totalReg = 0;
            if (isset($dataQueryRenew[$key + 1]['bln'])) {
                $totalRenew = $dataQueryRenew[$key + 1]['total'];
            }
            if (isset($dataQueryReg[$key + 1]['bln'])) {
                $totalReg = $dataQueryReg[$key + 1]['total'];
            }
            $month_map[] = array('month' => $d['month'], 'count' => $totalRenew + $totalReg);

            if ($totalRenew > 0 || $totalReg > 0) {
                $month_list[] = array('number' => $key + 1, 'month' => $d['month'], 'count' => $totalRenew + $totalReg);
            }

            $total_per_year += $totalRenew + $totalReg;
        }

        return view('page/stat-byarea-rev', [
            'total_paid' => number_format($total_per_year, 0),
            'statistic_perday' => json_encode($month_map),
            'month_list' => $month_list,
            'year' => $year,
            'filter_area' => $request->filter_area,
            'initProj' => $initProj,
            'initYear' => $initYear,
        ]);

    }

}