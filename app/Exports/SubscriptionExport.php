<?php

namespace App\Exports;

use DB;
use App\Models\UserSubscription;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionExport implements FromCollection, WithHeadings
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
        $customer = UserSubscription::query();
        $customer->select('subscription_number',
        DB::raw('DATE(subscription_date)'),
        'customer.customer_name',
        DB::raw('CONCAT(user.first_name, " ", user.last_name) AS sales'),        
        'site_product.product_name',
        'site_product.product_plan',
        'site_product.product_type',
        'billingcycle',
        'billing_account',
        'amount',
        DB::raw('DATE(next_due_date)'),
        DB::raw('DATE(termination_date)'),
        DB::raw('DATE(complete_date)'),
        DB::raw('DATE(cancel_date)'),
        DB::raw('DATE(deactive_date)'),
        DB::raw('DATE(reactive_date)'),
        DB::raw('DATE(dismentle_date)'),
        DB::raw('DATE(progress_date)'),
        'suspend_reason',
        'subscription_status.status_name',
        DB::raw('(CASE WHEN user_subscription.is_publish = 1 THEN "Yes" ELSE "No" END) AS publish'),
        DB::raw('(CASE WHEN user_subscription.is_free = 1 THEN "Yes" ELSE "No" END) AS free'),
        'user_order_item.promo',
        'site_project.project_name'
        );
        $customer->leftJoin('customer', 'user_subscription.customer_id', '=', 'customer.id');
        $customer->leftJoin('site_product', 'site_product.id', '=', 'user_subscription.product_id');
        $customer->leftJoin('subscription_status', 'subscription_status.id', '=', 'user_subscription.status_id');
        $customer->leftJoin('user_order', 'user_order.id', '=', 'user_subscription.order_id');
        $customer->leftJoin('user_order_item', 'user_order.id', '=', 'user_order_item.order_id');
        $customer->leftJoin('order_project', 'order_project.order_id', '=', 'user_subscription.order_id');
        $customer->leftJoin('site_project', 'site_project.id', '=', 'order_project.project_id');
        $customer->leftJoin('user', 'user_order.sales_id', '=', 'user.id');

        $customer->where('customer.customer_name','LIKE', "%".$this->filter->name."%" );

        if ($this->filter->status != "") {
            $customer->where('user_subscription.status_id',$this->filter->status);
        }
        if ($this->filter->type == "member") {
            $customer->where('site_product.product_type', "membership");
        }
        if ($this->filter->type == "non") {
            $customer->where('site_product.product_type', '!=', "membership");
        }
        if ($this->filter->date_from != "") {
            $customer->whereDate('user_subscription.subscription_date', '>=', $this->filter->date_from);
        }
        if ($this->filter->date_to != "") {
            $customer->whereDate('user_subscription.subscription_date', '<=', $this->filter->date_to);
        }
        if ($this->filter->product != "") {
            $customer->where('user_subscription.product_id', $this->filter->product);
        }

        $customer->omniFilter();
        $customer = $customer->get();

        return $customer;
    }

    public function headings(): array
    {
        return [
            'Subscription Number',
            'Subscription Date',
            'Customer Name',
            'Sales PIC',
            'Product Name',
            'Product Plan',
            'Product Type',
            'Billing Cycle',
            'Billing Account',
            'Amount',
            'Next Due Date',
            'Termination Date',
            'Active Date',
            'Cancel Date',
            'Deactive Date',
            'Reactive Date',
            'Dismantle Date',
            'Progress Date',
            'Suspend Reason',
            'Status',
            'Is Publish?',
            'Layanan Gratis?',
            'Promo',
            'Area'
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
