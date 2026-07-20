<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\UserInvoicestransaction;
use App\Models\UserInvoices;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;

class SubscriptionHelper
{

    public static function getActivationDate($customer_id)
    {
        
    }

    /**
     * Mengambil tanggal aktivasi berdasarkan order_id
     * 
     * @param int $order_id
     * @return string|null
     */
    public static function getActivationDateByOrderId($order_id)
    {
        $activationDate = DB::table('user_order_field')
            ->join('user_order_item', 'user_order_field.order_item_id', '=', 'user_order_item.id')
            ->join('user_order', 'user_order_item.order_id', '=', 'user_order.id')
            ->where('user_order.id', $order_id)
            ->where('user_order_field.field', 'tanggal-aktivasi')
            ->select('user_order_field.value')
            ->first();

        return $activationDate ? $activationDate->value : null;
    }

    public static function getActivationTimeByOrderId($order_id)
    {
        $activationTime = DB::table('user_order_field')
            ->join('user_order_item', 'user_order_field.order_item_id', '=', 'user_order_item.id')
            ->join('user_order', 'user_order_item.order_id', '=', 'user_order.id')
            ->where('user_order.id', $order_id)
            ->where('user_order_field.field', 'jam-aktivasi')
            ->select('user_order_field.value')
            ->first();

        return $activationTime ? $activationTime->value : null;
    }

    public static function deactiveAllSubscription($customer_id)
    {

        // Deactivate all subscriptions for the given customer_id
        // Tambahkan kondisi khusus untuk product dengan deposit_payment = 1 di tabel site_product
        // Mengembalikan total jumlah baris yang terpengaruh

        // Ambil daftar product_id untuk produk deposit dan non-deposit
        $depositProductIds = DB::table('site_product')
            ->where('deposit_payment', 1)
            ->pluck('id');

        // Deactivate untuk produk non-deposit
        $affectedNonDeposit = UserSubscription::where('customer_id', (int)$customer_id)
            ->whereIn('product_id', $depositProductIds)
            ->where('status_id', 1001)
            ->update([
                'status_id' => 1002,
                'suspend_reason' => 'Bulk deactivation by customer',
                'deactive_date' => now(),
                'updated_at' => now(),
            ]);

        return ($affectedNonDeposit);
    }

}