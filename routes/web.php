<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RedemController;
use App\Http\Controllers\SalesorderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SiteRouterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ResellerController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/.well-known/{name?}', function () {
//     $file = include public_path() . '/assets/static/assetlinks.json';

//     header('Accept: application/json');

//     return response()->json($file, 200);

// });



Route::get('/', [AuthController::class, 'index'])->name('index');

Route::get('/login', [AuthController::class, 'login'])->name('login');


// Authenticate Routes
Route::post('/console/auth/login', [AuthController::class, 'auth_login'])->name('auth_login');
Route::post('/console/api/login', [ServicesController::class]);
Route::get('/console/auth/logout', [AuthController::class, 'auth_logout'])->name('auth_logout');

Route::group(['middleware' => 'auth'], function () {
    //Dashboard Routes
    Route::get('/console/dashboard', function () {
        return view('page.dashboard');
    });
    Route::get('/console/dashboard/revenue', function () {
        return view('page.dashboard-revenue');
    });
    Route::get('/console/dashboard/subscription', function () {
        return view('page.dashboard-subscription');
    });
    Route::get('/console/dashboard/sales_order', function () {
        return view('page.dashboard-sales_order');
    });

    //Sales Order Routes
    Route::get('/console/salesorder', [SalesorderController::class, 'List']);
    Route::get('/console/salesorder/incoming', [SalesorderController::class, 'List_incoming']);
    Route::get('/console/salesorder/take/{order_id}', [SalesorderController::class, 'Take_salesorder']);
    Route::get('/console/salesorder/statistic/perday', [SalesorderController::class, 'Statistic_perday']);
    Route::get('/console/salesorder/statistic/permonth', [SalesorderController::class, 'Statistic_permonth']);
    Route::get('/console/salesorder/statistic/peryear', [SalesorderController::class, 'Statistic_peryear']);
    Route::get('/console/salesorder/detail/{order_id}', [SalesorderController::class, 'Detail']);
    Route::post('/console/salesorder/create', [SalesorderController::class, 'Create'])->name('create_salesorder');
    Route::post('/console/salesorder/update_status', [SalesorderController::class, 'Update_status'])->name('update_status_salesorder');
    Route::post('/console/salesorder/update_project', [SalesorderController::class, 'Update_project'])->name('update_project_salesorder');
    Route::post('/console/salesorder/update_progress', [SalesorderController::class, 'Update_progress'])->name('update_progress_salesorder');
    Route::post('/product/salesorder/get_order_plan', [SalesorderController::class, 'get_order_plan'])->name('get_order_plan');
    Route::post('/console/salesorder/set_targettolive', [SalesorderController::class, 'set_target_tolive'])->name('set_target_tolive');
    Route::get('/console/salesorder/list/commission', [SalesorderController::class, 'List_commission']);
    Route::post('/console/salesorder/set_payment_status', [SalesorderController::class, 'set_payment_status'])->name('set_payment_status');
    Route::post('/console/salesorder/upload/document', [SalesorderController::class, 'Upload_Document']);
    Route::get('/console/salesorder/document_spk/{order_id}', [SalesorderController::class, 'Document_spk']);
    Route::get('/console/salesorder/document_ba/{order_id}', [SalesorderController::class, 'Document_ba']);
    Route::get('/console/salesorder/download_document/{attachments}', [SalesorderController::class, 'download_documents']);
    Route::post('/console/salesorder/create_corporate', [SalesorderController::class, 'Create_corporate'])->name('create_corporate');
    Route::get('/console/salesorder/add_so_corporate', [SalesorderController::class, 'add_so_corporate']);
    Route::post('/console/salesorder/create_spk', [SalesorderController::class, 'create_spk'])->name('create_spk');
    Route::get('/console/salesorder/spk/{spk_id}', [SalesorderController::class, 'Detail_spk']);
    Route::post('/console/salesorder/upload/signature', [SalesorderController::class, 'Upload_Signature'])->name('upload_signature');;

    //Order Routes
    Route::get('/console/order', [OrderController::class, 'List_order']);
    Route::get('/console/order/detail/{order_id}', [OrderController::class, 'Detail_order']);
    Route::post('/console/order/update_progress', [OrderController::class, 'Update_progress_order'])->name('update_progress_order');
    Route::get('/console/order/approve/{order_id}', [OrderController::class, 'Generate_salesorder']);
    Route::get('/console/order/reject/{order_id}', [OrderController::class, 'Rejected_salesorder']);

    //Product Routes
    Route::get('/console/product', [ProductController::class, 'List']);
    Route::post('/console/product/detail', [ProductController::class, 'Detail'])->name('product_detail');
    Route::post('/console/product/create', [ProductController::class, 'Create']);
    Route::post('/console/product/update', [ProductController::class, 'Update']);
    Route::post('/product/get_plan', [ProductController::class, 'get_product_plan'])->name('get_product_plan');
    Route::post('/product/get_price', [ProductController::class, 'get_product_price'])->name('get_product_price');
    Route::post('/product/get_field', [ProductController::class, 'get_product_field'])->name('get_product_field');
    Route::post('/product/get_billing_cycle', [ProductController::class, 'get_billing_cycle'])->name('get_billing_cycle');
    Route::post('/product/get_billing_price', [ProductController::class, 'get_billing_price'])->name('get_billing_price');
    Route::post('/product/get_group', [ProductController::class, 'get_product_group'])->name('get_product_group');

    //Administrator User
    Route::get('/console/admin', [AdminController::class, 'List']);
    Route::post('/console/admin/detail', [AdminController::class, 'Detail'])->name('user_detail');
    Route::post('/console/admin/create', [AdminController::class, 'Create']);
    Route::post('/console/admin/update', [AdminController::class, 'Update']);
    Route::post('/console/admin/set_deactive', [AdminController::class, 'set_deactive'])->name('set_admin_deactive');
    Route::post('/console/admin/set_active', [AdminController::class, 'set_active'])->name('set_admin_active');

    //Subscription
    Route::post('/console/subscription/set_update', [SubscriptionController::class, 'set_update'])->name('set_update_subscription');
    Route::post('/console/subscription/set_active', [SubscriptionController::class, 'set_active'])->name('set_active_subscription');
    Route::post('/console/subscription/set_canceled', [SubscriptionController::class, 'set_canceled'])->name('set_canceled_subscription');
    Route::post('/console/subscription/set_deactive', [SubscriptionController::class, 'set_deactive'])->name('set_deactive_subscription');
    Route::post('/console/subscription/set_terminated', [SubscriptionController::class, 'set_terminated'])->name('set_terminated_subscription');
    Route::get('/console/subscription/statistic/actual', [SubscriptionController::class, 'Statistic_status']);
    Route::get('/console/subscription/statistic/perday', [SubscriptionController::class, 'Statistic_perday']);
    Route::get('/console/subscription/statistic/permonth', [SubscriptionController::class, 'Statistic_permonth']);
    Route::get('/console/subscription/statistic/peryear', [SubscriptionController::class, 'Statistic_peryear']);
    Route::get('/console/subscription', [SubscriptionController::class, 'List_subs']);
    Route::get('/console/subscription/statistic_area/peryear', [SubscriptionController::class, 'StatisticArea_peryear']);
    Route::get('/console/subscription/statistic_rev/peryear', [SubscriptionController::class, 'StatisticRev_peryear']);
    Route::post('/console/subscription/set_dismentle', [SubscriptionController::class, 'set_dismentle'])->name('set_dismentle_subscription');
    Route::post('/console/subscription/set_inprogress', [SubscriptionController::class, 'set_inprogress'])->name('set_inprogress_subscription');
    Route::post('/console/subscription/get_detail', [SubscriptionController::class, 'get_detail'])->name('get_detail_subs');
    // Route::get('/console/subscription/detail/{order_id}', [SubscriptionController::class, 'Generate_invoices_Corporate']);

    //Invoices
    Route::get('/console/invoices/list/draft', [InvoicesController::class, 'List_draft']);
    Route::get('/console/invoices/list/publish', [InvoicesController::class, 'List_publish']);
    Route::get('/console/invoices/list/duedate', [InvoicesController::class, 'List_duedate']);
    Route::get('/console/invoices/list/pastduedate', [InvoicesController::class, 'List_pastduedate']);
    Route::get('/console/invoices/list/proofofpayment', [InvoicesController::class, 'List_proofOfPayment']);
    Route::get('/console/invoices/list/bill', [InvoicesController::class, 'List_billaccount']);
    Route::get('/console/invoices/detail/{invoices_id}', [InvoicesController::class, 'Detail']);
    Route::get('/console/invoices/edit/{invoices_id}', [InvoicesController::class, 'Edit']);
    Route::post('/console/invoices/editupdate', [InvoicesController::class, 'Update']);
    Route::get('/console/invoices/publish/{invoice_id}', [InvoicesController::class, 'publish_invoices']);
    Route::post('/console/invoices/batch_publish/', [InvoicesController::class, 'batch_publish_invoices']);
    Route::get('/console/invoices/set_paid/{invoice_id}/{order_id}', [InvoicesController::class, 'set_paid']);
    Route::get('/console/invoices/set_as_paid/{invoice_id}', [InvoicesController::class, 'set_as_paid']);
    Route::post('/console/invoices/add/payment', [InvoicesController::class, 'add_payment']);
    Route::post('/console/invoices/upload/bukti_bayar', [InvoicesController::class, 'Upload_bukti_bayar']);
    Route::post('/console/invoices/terbit_manual_percust', [InvoicesController::class, 'terbit_invoices_manual_percustomer']);

    Route::get('/console/invoices/cancel/{invoice_id}', [InvoicesController::class, 'cancel_invoices']);
    Route::get('/console/invoices/reminder/{invoice_id}', [InvoicesController::class, 'reminder_invoices']);
    Route::get('/console/invoices/statistic/permonth', [InvoicesController::class, 'Statistic_permonth']);
    Route::get('/console/invoices/stat/peryear', [InvoicesController::class, 'StatisticPerYear']);
    Route::get('/console/invoices/stat/byyear', [InvoicesController::class, 'StatisticByYear']);



    //bukti bayar
    Route::post('/console/buktibayar/rejected', [InvoicesController::class, 'bukti_bayar_rejected']);
    Route::get('/console/buktibayar/download/{attachments}', [TicketController::class, 'download_attachments']);

    //Pipeline
    Route::get('/console/pipeline', [PipelineController::class, 'List']);
    Route::post('/console/pipeline/create', [PipelineController::class, 'Create_pipeline']);
    Route::post('/console/pipeline/update', [PipelineController::class, 'Update_pipeline']);
    Route::post('/console/pipeline/detail', [PipelineController::class, 'Detail'])->name('pipeline_detail');
    Route::get('/console/pipeline/reject/{pipeline_id}', [PipelineController::class, 'Rejected_pipeline']);

    //Ticket
    Route::get('/console/ticket/list/open', [TicketController::class, 'List_open']);
    Route::get('/console/ticket/list/close', [TicketController::class, 'List_close']);
    Route::get('/console/ticket/list/overdue', [TicketController::class, 'List_overdue']);
    Route::get('/console/ticket/detail/{ticket_id}', [TicketController::class, 'Detail']);
    Route::get('/console/ticket/set_close/{ticket_id}', [TicketController::class, 'set_close']);
    Route::post('/console/ticket/reply', [TicketController::class, 'Reply']);
    Route::get('/console/ticket/attachment/download/{attachments}', [TicketController::class, 'download_attachments']);
    Route::post('/console/ticket/create', [TicketController::class, 'Create']);

    //Notification
    Route::get('/console/notif/read', [AdminController::class, 'Read_notif'])->name('read_notif');

    // Reward
    Route::get('/console/reward', [RewardController::class, 'List']);
    Route::post('/console/reward/detail', [RewardController::class, 'Detail'])->name('reward_detail');
    Route::post('/console/reward/create', [RewardController::class, 'Create']);
    Route::post('/console/reward/update', [RewardController::class, 'Update']);
    // Route::post('/console/reward/delete', [RewardController::class, 'Delete']);

    //Redem
    Route::get('/console/redem/queue', [RedemController::class, 'List_queue']);
    Route::get('/console/redem/complete', [RedemController::class, 'List_complete']);
    Route::get('/console/redem/detail/{redem_id}', [RedemController::class, 'Detail']);
    Route::post('/console/redem/update', [RedemController::class, 'Update']);


    //Customer
    Route::get('/console/customer/active', [CustomerController::class, 'List_active']);
    Route::get('/console/customer/corporate', [CustomerController::class, 'List_corporate']);
    Route::get('/console/customer/membership', [CustomerController::class, 'List_membership']);
    Route::get('/console/customer/detail/{customer_id}', [CustomerController::class, 'Detail_membership']);
    Route::get('/console/customer/invoices/{customer_id}', [CustomerController::class, 'List_invoices']);
    Route::get('/console/customer/redem/{customer_id}', [CustomerController::class, 'List_redem']);
    Route::get('/console/customer/subs/{customer_id}', [CustomerController::class, 'List_subs']);
    Route::get('/console/customer/downline/{customer_id}', [CustomerController::class, 'List_downline']);
    Route::get('/console/customer/point/{customer_id}', [CustomerController::class, 'List_point']);
    Route::get('/console/customer/transaction/{customer_id}', [CustomerController::class, 'List_transaction']);
    Route::get('/console/customer/balance-history/{customer_id}', [CustomerController::class, 'Balance_history']);

    Route::post('/console/customer/detail', [CustomerController::class, 'Detail'])->name('customer_detail');
    Route::post('/console/customer/company/detail', [CustomerController::class, 'CompanyDetail'])->name('company_detail');
    Route::post('/console/customer/company/update', [CustomerController::class, 'CompanyUpdate']);
    Route::post('/console/customer/update', [CustomerController::class, 'Update']);
    Route::post('/console/customer/set_deactive', [CustomerController::class, 'set_deactive'])->name('set_deactive');
    Route::post('/console/customer/set_active', [CustomerController::class, 'set_active'])->name('set_active');
    Route::post('/console/customer/set_status', [CustomerController::class, 'set_status'])->name('set_status');
    Route::get('/console/customer/statistic/peryear', [CustomerController::class, 'Statistic_peryear']);
    Route::get('/console/customer/corporate/pic', [CustomerController::class, 'Corporate_pic'])->name('pic_corporate_list');

    Route::post('/console/customer/company/add', [CustomerController::class, 'create_company']);
    Route::post('/console/customer/contact/add', [CustomerController::class, 'create_contact']);
    // Report
    Route::get('/console/report', [ReportController::class, 'List_Export']);
    Route::post('/console/report/cust', [ReportController::class, 'Export_cust']);
    Route::post('/console/report/subs', [ReportController::class, 'Export_subs']);
    Route::post('/console/report/inv', [ReportController::class, 'Export_inv']);
    Route::post('/console/report/invoice', [ReportController::class, 'Export_invoice']);


    // Site Project
    Route::get('/console/project', [ProjectController::class, 'List']);
    Route::post('/console/project/detail', [ProjectController::class, 'Detail'])->name('project_detail');
    Route::post('/console/project/create', [ProjectController::class, 'Create']);
    Route::post('/console/project/update', [ProjectController::class, 'Update']);
    Route::post('/console/project/set_deactive', [ProjectController::class, 'set_deactive'])->name('set_deactive_project');
    Route::post('/console/project/set_active', [ProjectController::class, 'set_active'])->name('set_active_project');

    // Site Router
    Route::get('/console/router', [SiteRouterController::class, 'List']);
    Route::post('/console/router/detail', [SiteRouterController::class, 'Detail'])->name('router_detail');
    Route::post('/console/router/create', [SiteRouterController::class, 'Create']);
    Route::post('/console/router/update', [SiteRouterController::class, 'Update']);
    Route::post('/console/router/set_deactive', [SiteRouterController::class, 'set_deactive'])->name('set_deactive_router');
    Route::post('/console/router/set_active', [SiteRouterController::class, 'set_active'])->name('set_active_router');

    // Doc
    Route::get('/console/documentation', [DocController::class, 'List']);
    Route::post('/console/documentation/detail', [DocController::class, 'Detail'])->name('documentation_detail');
    Route::post('/console/documentation/create', [DocController::class, 'Create']);
    Route::post('/console/documentation/update', [DocController::class, 'Update']);

    Route::get('/console/panduan', [DocController::class, 'view_list']);
    Route::get('/console/panduan/detail/{doc_id}', [DocController::class, 'view_list_detail']);


    // Route::post('/console/documentation/delete', [DocController::class, 'Delete']);
    Route::post('/console/documentation/img', [DocController::class, 'Img'])->name('documentation_img');

    // Banner
    Route::get('/console/banner', [BannerController::class, 'List']);
    Route::post('/console/banner/detail', [BannerController::class, 'Detail'])->name('banner_detail');
    Route::post('/console/banner/create', [BannerController::class, 'Create']);
    Route::post('/console/banner/update', [BannerController::class, 'Update']);

    // Reseller
    Route::get('/console/reseller', [ResellerController::class, 'List']);
    Route::post('/console/reseller/detail', [ResellerController::class, 'Detail'])->name('reseller_detail');
    Route::post('/console/reseller/create', [ResellerController::class, 'Create']);
    Route::post('/console/reseller/update', [ResellerController::class, 'Update']);
    Route::post('/console/reseller/login', [ResellerController::class, 'Login'])->name('reseller_login');
    Route::get('/console/reseller/backtolimputra', [ResellerController::class, 'Backtolimputra'])->name('backtolimputra');

    Route::get('/console/test', [SalesorderController::class, 'Test']);

    // Promo
    Route::get('/console/promo', [PromoController::class, 'List']);
    Route::get('/console/promo/detail', [PromoController::class, 'Get'])->name('promo_detail');
    Route::get('/console/promo/generate_code', [PromoController::class, 'generate_promo_code'])->name('generate_promo_code');
    Route::post('/console/promo/create', [PromoController::class, 'Create']);
    Route::post('/console/promo/update', [PromoController::class, 'Update']);


    // Request Deposit
Route::get('/console/request-deposit', [\App\Http\Controllers\RequestDepositController::class, 'index']);
Route::get('/console/request-deposit/{id}', [\App\Http\Controllers\RequestDepositController::class, 'show']);
Route::post('/console/request-deposit/{id}/approve', [\App\Http\Controllers\RequestDepositController::class, 'approve']);
Route::post('/console/request-deposit/{id}/set-in-progress', [\App\Http\Controllers\RequestDepositController::class, 'setInProgress']);
Route::get('/console/request-deposit/proof/{invoiceId}', [\App\Http\Controllers\RequestDepositController::class, 'viewProof']);
Route::post('/console/request-deposit/upload-proof/{invoiceId}', [\App\Http\Controllers\RequestDepositController::class, 'uploadProof']);
Route::post('/console/request-deposit/create', [\App\Http\Controllers\RequestDepositController::class, 'storeTopup']);

    // pre test
    Route::get('/console/invoices/current_date', [InvoicesController::class, 'current_date']);

});

// Active Cron
Route::get('/console/invoices/terbit', [InvoicesController::class, 'terbit_invoices']);
Route::get('/console/subscription/autosuspend', [SubscriptionController::class, 'Auto_suspend']);
Route::get('/console/subscription/autoactivated', [SubscriptionController::class, 'Auto_activated']);
Route::get('/console/subscription/autodeactivated', [SubscriptionController::class, 'Auto_deactivated']);

// Deactive Cron
Route::get('/console/invoices/terbit_manual', [InvoicesController::class, 'terbit_invoices_manual']);
Route::get('/console/invoices/terbit_manual_percustomer', [InvoicesController::class, 'terbit_invoices_manual_percustomer']);
Route::get('/console/invoices/terbit_peralihan', [InvoicesController::class, 'terbit_invoices_peralihan']);

Route::get('/.well-known/assetlinks.json', function () {
    $data = [
        [
            "relation" => ["delegate_permission/common.handle_all_urls"],
            "target" => [
                "namespace" => "android_app",
                "package_name" => "com.uninet.umscustomerapp",
                "sha256_cert_fingerprints" => [
                    "24:F0:E5:8E:76:32:24:B4:F4:4D:A6:08:F5:D9:BF:90:C4:6B:E0:BA:CE:91:B0:C8:10:39:0F:55:72:94:42:2E",
                    "97:95:72:B3:40:34:87:E9:F3:BA:F2:74:F5:1F:53:DB:31:6F:00:9F:50:1B:88:28:A2:E9:D9:3F:76:05:17:4A",
                    "39:51:F8:FB:B6:17:C4:09:18:6F:FB:25:A7:20:4C:6F:AC:A7:66:E0:85:CC:4F:8F:A1:58:C0:FE:34:B7:F0:1E"
                ]
            ]
        ]
    ];
    return response()->json($data);
});

// API
Route::get('/api/subscription/reactivate/{order_id}', [ServicesController::class, 'reactivated']);
