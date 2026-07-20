<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Library\RouterosAPI;
use App\Models\Customer;
use App\Models\OrderProject;
use App\Models\SiteProduct;
use App\Models\SiteProject;
use App\Models\LogActivity;
use App\Models\SiteRouter;
use App\Models\User;
use App\Models\UserInvoicesitem;
use App\Models\UserSubscription;
use Auth;
use Illuminate\Http\Request;

class ServicesController extends Controller
{


    function reactivated($order_id) {

        try {
            
            $subs = UserSubscription::where('order_id', (int) $order_id)->first();
               
                if($subs->status_id == 1002) {

                    $api = new RouterosAPI();

                    $AREA_ID = OrderProject::query()->where('order_id', $order_id)->first();
                    $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();
                    
                    // connect to mikrotik
                    if($api->connect($router->ipaddress, $router->username, $router->password)) {

                        $SUBSCRIPTION_NUMBER = UserSubscription::query()->where('id', (int) $subs->id)->first()->subscription_number;
                            
                            // get secret
                            $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER ]));

                            if(!empty($secret)) {

                                $package_id = UserSubscription::query()->where('id', (int) $subs->id)->first()->product_id;
                                $profile_name = SiteProduct::query()->where('id',$package_id)->first()->product_profile;

                                // set active secret, change profile
                                $params = array_merge(['password' => $secret['0']['password']], [
                                    '.id' => $secret['0']['.id'],
                                    'name' => $secret['0']['name'],
                                    'service' => $secret['0']['service'],
                                    'profile' => $profile_name,
                                    'disabled' => 'false',
                                ]);
                                    
                                $api->comm('/ppp/secret/set', $params);

                                $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $SUBSCRIPTION_NUMBER ]));

                                if($crosscek[0]['profile'] != 'profile-isolir') {

                                    // get connection
                                    $arrID = $api->comm("/ppp/active/getall", array(".proplist"=> ".id", "?name" => $SUBSCRIPTION_NUMBER));

                                    if(!empty($arrID)) { 

                                        // reset connection
                                        $api->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
                                    
                                    }
                                    
                                    $stats = 'success'; $message = 'Subscription has been activated, profile secret has been change on mikrotik';

                                } else {

                                    $stats = 'failed'; $message = 'Failed deactive subscription, profile secret not set';

                                }

                                $api->disconnect();

                                if($stats == 'success') {

                                    $CUSTOMER_ID = UserSubscription::query()->where('id', (int) $subs->id)->first()->customer_id;
                                    $COMPLETE_DATE = UserSubscription::query()->where('id', (int) $subs->id)->first()->complete_date;

                                    $Update = UserSubscription::where('id',$subs->id)->update([
                                            'reactive_date' => now(),
                                    ]);

                                    $CUSTOMER  = Customer::query()->where('id', (int) $CUSTOMER_ID)->first();

                                    $Update = UserSubscription::where('id',$subs->id)->update([
                                        'status_id' => 1001
                                    ]);

                                    // Set Notification
                                    $params_notif = [
                                        "subject" => "Auto Active Subscription",
                                        "message" => 'customer baru saja melakukan pembayaran via instant payment dengan nomor layanan '.$SUBSCRIPTION_NUMBER,
                                        "group_id" => "1"
                                    ];
                                        
                                    // notif to finance
                                    $notif_finance = app(AdminController::class)->Create_notification('4', $params_notif);

                                    // notif to noc
                                    $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);

                                    LogActivity::create([
                                        'module' => 'subscription',
                                        'module_id' => $subs->id,
                                        'log_label' => 'Auto Reactive Subscription',
                                        'log_entry' => 'customer baru saja melakukan pembayaran via instant payment dengan nomor layanan '.$SUBSCRIPTION_NUMBER,
                                        'log_user_name' => 'System',
                                        'log_user_id' => 1,
                                        'log_user_ip' => '127.0.0.1',
                                    ]);

                                }


                            } else {
                                $stats = 'failed'; $message = 'CSID Not registerd on mikrotik';
                            } 

                    } else {

                        return response()->json(['status' => 'failed', 'response' => 'connect to microtik'], 400);

                        LogActivity::create([
                            'module' => 'subscription',
                            'module_id' => $subs->id,
                            'log_label' => 'Auto Reactive Subscription',
                            'log_entry' => 'gagal melakukan reactivate, alasan tidak dapat terhubung ke mikrotik dengan nomor layanan : '.$SUBSCRIPTION_NUMBER,
                            'log_user_name' => 'System',
                            'log_user_id' => 1,
                            'log_user_ip' => '127.0.0.1',
                        ]);

                    }

                } else {

                    return response()->json(['status' => 'success', 'response' => 'layanan memang sudah aktif sebelumnya'], 200);
                    

                } 


        } catch (\Throwable $th) {
            
            return response()->json(['status' => 'failed', 'response' => $th->getMessage()], 200);

        }

    }
}
