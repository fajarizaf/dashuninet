<?php

namespace App\Http\Controllers;

use DB;
use App\Models\SiteProduct;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Exports\CustomerExport;
use App\Exports\SubscriptionExport;
use App\Exports\InvoicesExport;
use App\Exports\InvoicesSummaryExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function List_Export(Request $request)
    {
        $prod = SiteProduct::query();
        $prod->select("id", "product_plan", "product_name", "product_type");
        $prod = $prod->get();

        $cust = Customer::query();
        $cust->select("id", "customer_name", "customer_email");
        $cust->orderBy("customer_name");
        $cust = $cust->get();

        return view('page/report', [
            'prod' => $prod,
            'cust' => $cust,
        ]);

    }

    public function Export_cust(Request $request) {
        $customer = (object) [
            'status' => $request->status,
            'name' => $request->name,
            'type' => $request->type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];

        return Excel::download(new CustomerExport($customer), 'customer.xlsx');
    }

    public function Export_subs(Request $request) {
        $customer = (object) [
            'status' => $request->status,
            'name' => $request->name,
            'type' => $request->type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'product' => $request->product,
        ];

        return Excel::download(new SubscriptionExport($customer), 'subscription.xlsx');
    }

    public function Export_inv(Request $request) {
        $customer = (object) [
            'status' => $request->status,
            'customer' => $request->customer,
            'type' => $request->type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'next_due' => $request->next_due,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'visibility' => $request->visibility,
            'billing' => $request->billing,
        ];
        // dd($customer);

        return Excel::download(new InvoicesExport($customer), 'invoices.xlsx');
    }

    public function Export_invoice(Request $request) {
        $customer = (object) [
            'status' => $request->status,
            'customer' => $request->customer,
            'type' => $request->type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'next_due' => $request->next_due,
            'due_date' => $request->due_date
            // 'product' => $request->product,
            // 'billing' => $request->billing
        ];
        // dd($customer);

        return Excel::download(new InvoicesSummaryExport($customer), 'summary invoices.xlsx');
    }


}
