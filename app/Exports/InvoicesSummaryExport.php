<?php

namespace App\Exports;

use DB;
use App\Models\UserInvoices;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesSummaryExport implements FromCollection, WithHeadings
{
    protected $filter;

    function __construct($r) {
        $this->filter = $r;
        // $this->id = $r->status;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $BACKEND_URL = request()->getSchemeAndHttpHost();
        $customer = UserInvoices::query();
        $customer->select(
        // 'user_invoices.id',        
        DB::raw('(CASE WHEN invoice_number != "" THEN invoice_number ELSE user_invoices.id END) AS invoice_number'),
        // 'invoice_number',
        'customer.customer_name',
        // DB::raw('CONCAT(user.first_name, " ", user.last_name) AS sales'),
        DB::raw("(select CONCAT(user.first_name, ' ', user.last_name) AS sales from user_invoices_item left join user_order ON user_order.id = user_invoices_item.order_id left join user ON user.id = user_order.sales_id where invoice_id=user_invoices.id AND user_invoices_item.order_id IS NOT NULL limit 1)"), //customer_id=customer.id
        'invoice_date',
        'invoice_duedate',
        'invoice_next_duedate',
        'user_invoices_transaction.trx_number',
        DB::raw("DATE(user_invoices_transaction.trx_date) as trx_date"),
        'user_invoices.payment_method',
        // 'user_invoices_item.billing_account',
        DB::raw("(select GROUP_CONCAT(DISTINCT billing_account SEPARATOR ', \n ') AS bill from user_invoices_item where invoice_id=user_invoices.id)"),
        DB::raw("(select GROUP_CONCAT(DISTINCT item_name SEPARATOR ', \n ') AS locations from user_invoices_item where invoice_id=user_invoices.id)"),
        DB::raw("(select sum(amount) as base_forex FROM user_invoices_item where invoice_id=user_invoices.id AND item_name NOT LIKE '%Potongan%' group by invoice_id)"),
        DB::raw("(select sum(amount) as discount FROM user_invoices_item where invoice_id=user_invoices.id AND item_name LIKE '%Potongan%' group by invoice_id)"),
        'user_invoices.subtotal',
        DB::raw("user_invoices.tax * user_invoices.subtotal / 100"),
        'user_invoices.total',
        'invoices_status.status_name',
        'invoice_type',
        'user_invoices_transaction.gateway',
        // DB::raw('(CASE WHEN user_invoices.is_publish = 1 THEN "Publish" ELSE "Draft" END) AS publish'),
        DB::raw("CONCAT('$BACKEND_URL', '/console/buktibayar/download/', invoices_proof_payment.file) as file")
        );
        // $customer->leftJoin('user_invoices_item', 'user_invoices.id', '=', 'user_invoices_item.invoice_id');
        $customer->leftJoin('customer', 'user_invoices.customer_id', '=', 'customer.id');
        $customer->leftJoin('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');

        // $customer->leftJoin('user_order', 'user_order.id', '=', 'user_invoices_item.order_id');
        // $customer->leftJoin('user', 'user.id', '=', 'user_order.sales_id');
        $customer->leftJoin('invoices_proof_payment', 'user_invoices.id', '=', 'invoices_proof_payment.invoice_id');
        $customer->leftJoin('user_invoices_transaction', 'user_invoices.id', '=', 'user_invoices_transaction.invoice_id');

        // $customer->whereNotNull('user_invoices_item.order_id');
        $customer->where('user_invoices.is_publish', '1');

        if ($this->filter->customer != "") {
            $customer->where('user_invoices.customer_id',$this->filter->customer);
        }
        if ($this->filter->status != "") {
            $customer->where('user_invoices.status_id',$this->filter->status);
        }
        if ($this->filter->type != "") {
            $customer->where('user_invoices.invoice_type', $this->filter->type);
        }
        // if ($this->filter->visibility != "") {
        //     $customer->where('user_invoices.is_publish', $this->filter->visibility);
        // }
        if ($this->filter->date_from != "") {
            $customer->whereDate('user_invoices.invoice_date', '>=', $this->filter->date_from);
        }
        if ($this->filter->date_to != "") {
            $customer->whereDate('user_invoices.invoice_date', '<=', $this->filter->date_to);
        }
        if ($this->filter->due_date != "") {
            $customer->whereDate('user_invoices.invoice_duedate', $this->filter->due_date);
        }
        if ($this->filter->next_due != "") {
            $customer->whereDate('user_invoices.invoice_next_duedate', $this->filter->next_due);
        }
        // if ($this->filter->billing != "") {
        //     $customer->where('user_invoices_item.billing_account', $this->filter->billing);
        // }
        // if ($this->filter->product != "") {
        //     $customer->where('user_invoices_item.product_id', $this->filter->product);
        // }

        $customer->omniFilter();
        $customer = $customer->get();

        return $customer;
    }

    public function headings(): array
    {
        return [
            // 'Invoice Id',
            'Invoice Number',
            'Customer',
            'Sales PIC',
            'Invoice Date',
            'Due Date',
            'Next Due Date',
            'Trans No.',
            'Trans Date',
            'Payment Method',
            'Billing Account',
            'Rincian Item',
            'Base Forex',
            'Discount',
            'Sub Amount',
            'PPN',
            'Total',
            'Status',
            'Invoice Type',
            'Payment Method',
            // 'Visibility',
            'Link Proof of Payment'
        ];
    }

    // public function map($cust): array
    // {
    //     return [
    //         $cust->customer_number,
    //         $cust->customer_name,
    //         $cust->customer_email,
    //         $cust->customer_address,
    //         $cust->customer_telp,
    //         $cust->customer_company,
    //         date_format($cust->created_at,"d-m-Y H:i:s"),
    //         // Date::dateTimeToExcel($cust->created_at),
    //     ];
    // }

}
