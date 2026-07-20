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

class InvoicesExport implements FromCollection, WithHeadings
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
        'user_invoices.id',
        'invoice_number',
        'customer.customer_name',
        // DB::raw("GROUP_CONCAT(select user_order.id from user_order where user_order.id=user_invoices_item.order_id  SEPARATOR ',\n') AS pic_list"),
        DB::raw('CONCAT(user.first_name, " ", user.last_name) AS sales'),
        'invoice_type',
        'invoice_date',
        'user_invoices_item.billing_account',
        // DB::raw("GROUP_CONCAT(user_invoices_item.billing_account SEPARATOR ',\n') AS billing_account_list"),
        'user_invoices_item.item_name',
        // DB::raw("GROUP_CONCAT(CONCAT(user_invoices_item.item_name, ' Rp. ', user_invoices_item.amount, ' Billing Account: ', if(user_invoices_item.billing_account is null ,'',user_invoices_item.billing_account)) SEPARATOR ',\n' ) AS item_list"),
        'invoice_duedate',
        'invoice_next_duedate',
        'invoice_datepaid',
        'user_invoices.payment_method',
        'user_invoices_item.amount',
        'user_invoices.tax',
        'user_invoices.subtotal',
        'user_invoices.total',
        'invoices_status.status_name',
        DB::raw('(CASE WHEN user_invoices.is_publish = 1 THEN "Publish" ELSE "Draft" END) AS publish'),
        DB::raw("CONCAT('$BACKEND_URL', '/console/buktibayar/download/', invoices_proof_payment.file) as file")
        );
        $customer->leftJoin('user_invoices_item', 'user_invoices.id', '=', 'user_invoices_item.invoice_id');
        $customer->leftJoin('customer', 'user_invoices.customer_id', '=', 'customer.id');
        $customer->leftJoin('invoices_status', 'invoices_status.id', '=', 'user_invoices.status_id');

        $customer->leftJoin('user_order', 'user_order.id', '=', 'user_invoices_item.order_id');
        $customer->leftJoin('user', 'user.id', '=', 'user_order.sales_id');
        $customer->leftJoin('invoices_proof_payment', 'user_invoices.id', '=', 'invoices_proof_payment.invoice_id');

    //     $customer->groupBy('user_invoices.id', 'invoice_number',
    //     'customer.customer_name',
    //     'sales',
    //     'invoice_type',
    //     'invoice_date',
    //     'invoice_duedate',
    //     'invoice_next_duedate',
    //     'invoice_datepaid',
    //     'user_invoices.payment_method',
    //     'user_invoices.tax',
    //     'subtotal',
    //     'user_invoices.total',
    //     'invoices_status.status_name', 
    //     'publish',
    //     'file'
    // );
        // $customer->whereNotNull('user_invoices_item.billing_account');

        if ($this->filter->customer != "") {
            $customer->where('user_invoices.customer_id',$this->filter->customer);
        }
        if ($this->filter->status != "") {
            $customer->where('user_invoices.status_id',$this->filter->status);
        }
        if ($this->filter->type != "") {
            $customer->where('user_invoices.invoice_type', $this->filter->type);
        }
        if ($this->filter->visibility != "") {
            $customer->where('user_invoices.is_publish', $this->filter->visibility);
        }
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
        if ($this->filter->billing != "") {
            $customer->where('user_invoices_item.billing_account', $this->filter->billing);
        }
        if ($this->filter->product != "") {
            $customer->where('user_invoices_item.product_id', $this->filter->product);
        }

        $customer = $customer->get();

        return $customer;
    }

    public function headings(): array
    {
        return [
            'Invoice Id',
            'Invoice Number',
            'Customer Name',
            'Sales PIC',
            'Invoice Date',
            'Invoice Type',
            'Billing Account',
            'Product',
            'Due Date',
            'Next Due Date',
            'Date Paid',
            'Payment Method',
            'Amount',
            'Tax',
            'Subtotal',
            'Total',
            'Status',
            'Visibility',
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
