<?php

namespace App\Jobs;


// Pastikan tidak terjadi resolusi namespace ke App\Jobs\DepositHelper.
// Gunakan FQCN saat memanggil helper untuk menghindari error "Class App\\Jobs\\DepositHelper not found".
use App\Models\UserOrder;

use App\Http\Controllers\AdminController;
use App\Library\RouterosAPI;
use App\Models\Customer;
use App\Models\LogActivity;
use App\Models\OrderProject;
use App\Models\SiteProject;
use App\Models\SiteProduct;
use App\Models\SiteProductPrice;
use App\Models\SiteRouter;
use App\Models\UserInvoicesitem;
use App\Models\UserInvoicestransaction;
use App\Models\UserInvoices;
use Carbon\Carbon;
use App\Models\UserSubscription;
use Exception;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class AutoactiveJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * Backoff (delay) between retries in seconds.
     * Use an array for progressive backoff.
     */
    public $backoff = [60, 300];

    /**
     * Max execution time for the job in seconds.
     */
    public $timeout = 120;

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

    /**
     * Execute the job.
     *
     * @return void
    */

    public function handle()
    {
        
            $api = new RouterosAPI();

            // Initialize status and message to avoid undefined variable issues
            $stats = null;
            $message = null;

            $SUBSCRIPTION = UserSubscription::query()->where('id', (int) $this->subscription_id)->first();
            if (!$SUBSCRIPTION) {
                throw new \RuntimeException('Subscription tidak ditemukan untuk id: '.$this->subscription_id);
            }
            $AREA_ID = OrderProject::query()->where('order_id', $SUBSCRIPTION->order_id)->first();

            // Idempotency guard: skip if already active
            if ((int) $SUBSCRIPTION->status_id === 1001) {
                $stats = 'success';
                $message = 'Subscription already active, skipping.';
                print($stats.':'.$message);
                return;
            }
            $CUSTOMER = Customer::query()->where('id', $SUBSCRIPTION->customer_id)->first();
            // Pastikan resolusi class SiteProduct tidak mengarah ke App\Jobs\SiteProduct
            if (!class_exists(\App\Models\SiteProduct::class)) {
                throw new \RuntimeException('Model App\\Models\\SiteProduct tidak ditemukan. Periksa namespace dan autoload.');
            }
            $PRODUCT = \App\Models\SiteProduct::query()->where('id', $SUBSCRIPTION->product_id)->first();


            // cek balance customer
            // Gunakan FQCN dan tambahkan guard agar tidak fatal saat helper tidak ter-load
            if (!class_exists(\App\Helpers\DepositHelper::class)) {
                throw new \RuntimeException('Helper class App\\Helpers\\DepositHelper tidak ditemukan. Periksa file app/Helpers/DepositHelper.php dan namespace-nya.');
            }
            $deposit = \App\Helpers\DepositHelper::getBalance((int) $SUBSCRIPTION->customer_id);
            $amount_order = UserOrder::where('id', $SUBSCRIPTION->order_id)->value('total');

            // cek apakah saldo deposit cukup
            if($deposit < $amount_order) {
                $stats = 'failed';
                $message = 'Auto aktivasi gagal, saldo deposit tidak cukup';
            } else {

                // Generate CID Customer
                if ($CUSTOMER->customer_number == '') {
                    $NEW_CUSTOMER_NUMBER = IdGenerator::generate(['table' => 'customer', 'field' => 'customer_number', 'length' => 11, 'prefix' => 'CID-']);
                    $GENERATE = Customer::where('id', $CUSTOMER->id)->update([
                        'customer_number' => $NEW_CUSTOMER_NUMBER
                ]);

                } else {
                    $NEW_CUSTOMER_NUMBER = $CUSTOMER->customer_number;
                }

                // apabila baru aktivasi pertama kali
                if ($SUBSCRIPTION->subscription_number == '') {
                    $NEW_SUBSCRIPTION_NUMBER = IdGenerator::generate(['table' => 'user_subscription', 'field' => 'subscription_number', 'length' => 12, 'prefix' => 'CSID-']);
                    $NEW_BILLING_NUMBER = IdGenerator::generate(['table' => 'user_subscription', 'field' => 'billing_account', 'length' => 11, 'prefix' => 'BID-']);
                    // set nomor subscription and billing account
                    $Update = UserSubscription::where('id', $this->subscription_id)->update([
                        'subscription_number' => $NEW_SUBSCRIPTION_NUMBER,
                        'billing_account' => $NEW_BILLING_NUMBER,
                    ]);
                } else {
                    $NEW_SUBSCRIPTION_NUMBER = $SUBSCRIPTION->subscription_number;
                }

                if($AREA_ID != null) {

                    $ROUTER_ID = SiteProject::query()->where('id', $AREA_ID->project_id)->first();

                    if($ROUTER_ID && !empty($ROUTER_ID->router_id)) {

                        $router = SiteRouter::query()->where('id', $ROUTER_ID->router_id)->first();
                        
                        // connect to mikrotik
                        if($router && $api->connect($router->ipaddress, $router->username, $router->password)) {

                                $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $NEW_CUSTOMER_NUMBER]));

                                if ($crosscek == []) {

                                    $stats = 'failed';
                                    $message = 'Failed add new secret on mikrotik';

                                } else {

                                    // apabila secret berhasil didaftarkan
                                    $profile_name = $PRODUCT->product_profile;

                                        // set active secret, change profile
                                        $params = array_merge(['password' => $crosscek['0']['password']], [
                                            '.id' => $crosscek['0']['.id'],
                                            'name' => $crosscek['0']['name'],
                                            'service' => $crosscek['0']['service'],
                                            'profile' => $profile_name,
                                            'disabled' => 'false',
                                        ]);

                                        $api->comm('/ppp/secret/set', $params);

                                        $crosscek = $api->comm('/ppp/secret/getall', array_filter(['?name' => $NEW_CUSTOMER_NUMBER]));

                                        if ($crosscek[0]['profile'] != 'profile-isolir') {

                                            // get connection
                                            $arrID = $api->comm("/ppp/active/getall", array(".proplist" => ".id", "?name" => $NEW_CUSTOMER_NUMBER));

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

                                        // APABILA PENDAFTARAN KE MIKROTIK BERHASIL
                                        if ($stats == 'success') {

                                            // panggil fungsi deactiveAllSubscription
                                            \App\Helpers\SubscriptionHelper::deactiveAllSubscription($SUBSCRIPTION->customer_id);

                                            $COMPLETE_DATE = UserSubscription::query()->where('id', (int)$this->subscription_id)->first()->complete_date;

                                            if (empty($COMPLETE_DATE)) {

                                                $is_product_recurring = SiteProductPrice::where('product_id', $SUBSCRIPTION->product_id)
                                                    ->where('payment_type', 'recurring')
                                                    ->exists(); 

                                                $is_product_onetime = SiteProductPrice::where('product_id', $SUBSCRIPTION->product_id)
                                                    ->where('payment_type', 'onetime')
                                                    ->exists(); 

                                                $Update = UserSubscription::where('id', $this->subscription_id)->update([
                                                    'complete_date' => Carbon::now(),
                                                ]);
                            

                                                if($is_product_onetime) {
                                                    $Update = UserSubscription::where('id', $this->subscription_id)->update([
                                                        'expired_date' => Carbon::now()->addHours(24),
                                                    ]);
                                                }

                                            } else {

                                                $Update = UserSubscription::where('id', $this->subscription_id)->update([
                                                    'reactive_date' => Carbon::now(),
                                                ]);

                                            }

                                            $CUSTOMER = Customer::query()->where('id', (int)$SUBSCRIPTION->customer_id)->first();
                                            $Update = UserSubscription::where('id', $this->subscription_id)->update([
                                                'status_id' => 1001
                                            ]);

                                            // Update status pada order terkait menjadi 1035
                                            if (!empty($SUBSCRIPTION->order_id)) {
                                                UserOrder::where('id', $SUBSCRIPTION->order_id)->update([
                                                    'status_id' => 1035,
                                                ]);
                                            }

                                            // get billing account
                                            $NEW_BILLING_NUMBER = UserSubscription::query()->where('id', (int)$this->subscription_id)->first()->billing_account;

                                            $COUNT_INVOICES = UserInvoicesitem::query()->where('billing_account', $NEW_BILLING_NUMBER)->count();
                                            
                                            // Use SubscriptionController methods for invoice generation and emailing
                                            $subscriptionController = new \App\Http\Controllers\SubscriptionController();
                                                
                                                // generate invoices auto terbit send to customer
                                                // Alternative: gunakan helper now() agar tidak bergantung pada import Carbon
                                                $GENERATE_INVOICES = app(\App\Http\Controllers\SubscriptionController::class)->Generate_invoices_ondemand($this->subscription_id, $SUBSCRIPTION->customer_id, now(), $NEW_BILLING_NUMBER, 'renew');

                                                // SEND EMAIL To Customer
                                                app(\App\Http\Controllers\SubscriptionController::class)->Send_Invoices_Email($GENERATE_INVOICES, $CUSTOMER);

                                                // AUTO POTONG DEPOSIT
                                                // cek apabila pembelian produk harus menggunakan deposit
                                                if($PRODUCT->deposit_payment == 1) {
                                                    
                                                    // auto potong dari saldo deposit dan update invoices menjadi paid dan create transaction
                                                    DB::transaction(function() use ($GENERATE_INVOICES) {
                                                        UserInvoices::where('id', $GENERATE_INVOICES)
                                                            ->update([
                                                                'status_id' => 1036,
                                                                'payment_method' => 'Deposit'
                                                            ]);
                                                        
                                                        $amount_invoices = UserInvoices::where('id', $GENERATE_INVOICES)->value('total');
    
                                                        $TRANSACTION_NUMBER = IdGenerator::generate(['table' => 'user_invoices_transaction', 'field' => 'trx_number', 'length' => 9, 'prefix' => 'TRX-']);
    
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
                                                    });
                                                }
                                                
                                            // Set Notification
                                            $params_notif = [
                                                "subject" => "Set Active Subscription",
                                                "message" =>  'auto aktivasi layanan by sistem dengan nomor layanan ' . $NEW_SUBSCRIPTION_NUMBER,
                                                "group_id" => "1"
                                            ];
                                                
                                            // notif to finance
                                            $notif_finance = app(AdminController::class)->Create_notification('4', $params_notif);

                                            // notif to noc
                                            $notif_noc = app(AdminController::class)->Create_notification('2', $params_notif);

                                        }

                                }

                        } else {
                            $stats = 'failed'; $message = 'Failed activate subscription, can not connect to mikrotik';
                        }

                    } else {
                        $stats = 'failed'; $message = 'Failed activate subscription, router not set in project area';
                    }

                } else {
                    $stats = 'failed'; $message = 'Failed activate subscription, project area not set';
                }
            }

            $LOG_ACTIVITY = LogActivity::create([
                'module' => 'subscription',
                'module_id' => $this->subscription_id,
                'log_label' => 'Auto Activated Subscription',
                'log_entry' => 'Auto Activated subscription, with subscribtion id :'.$this->subscription_id.', reason: potong deposit, response: '. $message,
                'log_user_name' => 'System',
                'log_user_id' => '1',
                'log_user_ip' => '192.8.45.3',
            ]);

            if($stats == 'failed') {
                throw new Exception('subscription_id : '.$this->subscription_id.', message :'.$message);
            }

            print($stats.':'.$message);

    }

    /**
     * Handle a job failure event after all retries.
     */
    public function failed(Exception $e): void
    {
        // Log failure to activity for easier diagnosis
        try {
            LogActivity::create([
                'module' => 'subscription',
                'module_id' => $this->subscription_id,
                'log_label' => 'Auto Activated Subscription Failed',
                'log_entry' => 'Job gagal setelah retry. subscription_id: '.$this->subscription_id.', error: '.$e->getMessage(),
                'log_user_name' => 'System',
                'log_user_id' => '1',
                'log_user_ip' => 'system',
            ]);
        } catch (\Throwable $t) {
            // Ignore logging errors in failed() to prevent cascading failures
        }
    }
    /**
     * The number of seconds the job should be unique.
     * Prevents duplicate execution when scheduled every minute.
     */
    public $uniqueFor = 60;
    public function uniqueId(): string
    {
        return 'autoactive:' . (string) $this->subscription_id;
    }
}
