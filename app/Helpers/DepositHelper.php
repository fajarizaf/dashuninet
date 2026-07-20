<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\UserInvoicestransaction;
use App\Models\UserInvoices;
use Illuminate\Support\Facades\DB;

class DepositHelper
{

    public static function getBalance($customer_id)
    {
        // Total topup dari transaksi dengan is_deposit = 1
        $total_topup = UserInvoicestransaction::join('user_invoices', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
            ->where('user_invoices.customer_id', $customer_id)
            ->where('user_invoices_transaction.is_deposit', 1)
            ->sum('user_invoices_transaction.amount_in');
        
        // Total penggunaan deposit dari transaksi dengan is_deposit = 0, payment_method = Deposit, status_id = 1036
        $total_used = UserInvoicestransaction::join('user_invoices', 'user_invoices_transaction.invoice_id', '=', 'user_invoices.id')
            ->where('user_invoices.customer_id', $customer_id)
            ->where('user_invoices_transaction.is_deposit', 0)
            ->where('user_invoices.payment_method', 'Deposit')
            ->where('user_invoices.status_id', 1036)
            ->sum('user_invoices_transaction.amount_in');
        
        // Saldo deposit = total topup - total yang sudah digunakan
        return $total_topup - $total_used;
    }

}