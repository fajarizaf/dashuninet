<?php

namespace App\Jobs;

use App\Http\Controllers\AdminController;
use App\Library\RouterosAPI;
use App\Models\Customer;
use App\Models\LogActivity;
use App\Models\OrderProject;
use App\Models\SiteProject;
use App\Models\SiteRouter;
use App\Models\UserSubscription;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutodeactiveJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $uniqueFor = 3600;

    // Retry configuration to handle transient failures gracefully
    public $tries = 5; // total attempts including the first run

    /**
     * Backoff intervals (in seconds) between retries.
     * Using progressive backoff helps reduce load on external systems like Mikrotik.
     */
    public function backoff()
    {
        return [60, 300, 900, 1800]; // 1m, 5m, 15m, 30m before the final attempt
    }

    protected $subscription_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subscription_id)
    {
        $this->subscription_id = $subscription_id;
    }

    public function uniqueId()
    {
        return (string) $this->subscription_id;
    }

    /**
     * Execute the job.
     *
     * @return void
    */

    public function handle()
    {
      $stats = null; $message = null;

            $api = new RouterosAPI();

            $SUBSCRIPTION = UserSubscription::query()->where('id', (int) $this->subscription_id)->first();
            if (!$SUBSCRIPTION) {
                $stats = 'failed'; $message = 'Failed set deactive subscription, subscription not found';
                LogActivity::create([
                    'module' => 'subscription',
                    'module_id' => $this->subscription_id,
                    'log_label' => 'Auto Deactive Subscription',
                    'log_entry' => 'Auto Deactivated subscription, with subscribtion id :'.$this->subscription_id.', reason: subscription not found, response: '. $message,
                    'log_user_name' => 'System',
                    'log_user_id' => '1',
                    'log_user_ip' => '192.8.45.3',
                ]);
                throw new Exception('subscription_id : '.$this->subscription_id.', message :'.$message);
                return;
            }

            // Idempotency guard: skip if already deactivated
            if ((int)$SUBSCRIPTION->status_id === 1002) {
                LogActivity::create([
                    'module' => 'subscription',
                    'module_id' => $this->subscription_id,
                    'log_label' => 'Auto Deactive Subscription',
                    'log_entry' => 'Skip deactivation, subscription already deactivated. subscription id :'.$this->subscription_id,
                    'log_user_name' => 'System',
                    'log_user_id' => '1',
                    'log_user_ip' => '192.8.45.3',
                ]);
                return;
            }

            $AREA_ID = OrderProject::query()->where('order_id', $SUBSCRIPTION->order_id)->first();
            $CUSTOMER = Customer::query()->where('id', $SUBSCRIPTION->customer_id)->first();

            if (!$CUSTOMER) {
                $stats = 'failed'; $message = 'Failed set deactive subscription, customer not found';
                LogActivity::create([
                    'module' => 'subscription',
                    'module_id' => $this->subscription_id,
                    'log_label' => 'Auto Deactive Subscription',
                    'log_entry' => 'Auto Deactivated subscription, with subscribtion id :'.$this->subscription_id.', reason: customer not found, response: '. $message,
                    'log_user_name' => 'System',
                    'log_user_id' => '1',
                    'log_user_ip' => '192.8.45.3',
                ]);
                throw new Exception('subscription_id : '.$this->subscription_id.', message :'.$message);
                return;
            }

            if($AREA_ID != null) {

                $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                if($ROUTER_ID && $ROUTER_ID->router_id != '') {

                    $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();

                    // connect to mikrotik
                    if($router && $api->connect($router->ipaddress, $router->username, $router->password)) {
                        
                        // get secret
                        $secret = $api->comm('/ppp/secret/getall', array_filter(['?name' => $CUSTOMER->customer_number ]));
                       
                        if(!empty($secret)) {

                            // deactive secret, change profile to isolir
                            $params = array_merge(['password' => $secret['0']['password']], [
                                '.id' => $secret['0']['.id'],
                                'name' => $secret['0']['name'],
                                'service' => $secret['0']['service'],
                                'profile' => 'profile-isolir',
                                'disabled' => 'false',
                            ]);
                            
                            $api->comm('/ppp/secret/set', $params);

                            $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $CUSTOMER->customer_number ]));

                            if(!empty($crosscek) && isset($crosscek[0]['profile']) && $crosscek[0]['profile'] == 'profile-isolir') {

                                // remove connection
                                $arrID = $api->comm("/ppp/active/getall", array(".proplist"=> ".id", "?name" => $CUSTOMER->customer_number));

                                if(!empty($arrID)) { 

                                    $api->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
                                    
                                }

                                $stats = 'success'; $message = 'Subscription has been deactivated, secret has been change profile isolir on mikrotik';

                                $Update = UserSubscription::where('id',$this->subscription_id)->update([
                                    'status_id' => 1002,
                                    'suspend_reason' => 'Auto deactive layanan , karena layanan sudah expired',
                                    'deactive_date' =>  now(),
                                ]);
        
                                // notif email
                                $response = Http::withToken(env('BACKEND_TOKEN'))
                                ->post(env('BACKEND_URL').'/email/send', [
                                    'action' => 'Deactive Subscription',
                                    'send_to' => $CUSTOMER->customer_email,
                                    'name' => $CUSTOMER->customer_name, 
                                ]);
        
                                // Set Notification
                                $params_notif = [
                                    "subject" => "Set Deactive Subscription",
                                    "message" => 'Auto deactive layanan dari sistem dengan nomor layanan '.$SUBSCRIPTION->subscription_number.' karena layanan sudah expired',
                                    "group_id" => "1"
                                ];
                                        
                                // notif to noc
                                $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);
        
                                // notif to billing
                                $notif_billing = app(AdminController::class)->Create_notification('4', $params_notif);
                                
                            } else {
                                $stats = 'failed'; $message = 'Failed set secret to profile isolir on mikrotik';
                            }

                            $api->disconnect();

                        } else {
                            $stats = 'failed'; $message = 'CSID Not registerd on mikrotik';
                        }

                    } else {
                        $stats = 'failed'; $message = 'Failed set deactive subscription, cannot connect to mikrotik';
                    }

                } else {
                    $stats = 'failed'; $message = 'Failed set deactive subscription, router not set in project area';
                }

            } else {
                $stats = 'failed'; $message = 'Failed set deactive subscription, project area not set';
            }

            $LOG_ACTIVITY = LogActivity::create([
                'module' => 'subscription',
                'module_id' => $this->subscription_id,
                'log_label' => 'Auto Deactive Subscription',
                'log_entry' => 'Auto Deactivated subscription, with subscribtion id :'.$this->subscription_id.', reason: karena layanan sudah expired, response: '. $message,
                'log_user_name' => 'System',
                'log_user_id' => '1',
                'log_user_ip' => '192.8.45.3',
            ]);

            if($stats == 'failed') {
                throw new Exception('subscription_id : '.$this->subscription_id.', message :'.$message);
            }

            print($stats.':'.$message);

    }
}
