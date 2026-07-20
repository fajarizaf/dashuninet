<?php

namespace App\Exports;

use App\Models\Customer;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromCollection, WithHeadings, WithMapping
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
        $customer = Customer::query();
        $customer->select("customer_number", "customer_name", "customer_email", "customer_address", "customer_telp", "customer_company", "customer.created_at");
        $customer->leftJoin('customer_membership', 'customer_membership.customer_id', '=', 'customer.id');

        $customer->where('customer_name','LIKE', "%".$this->filter->name."%" );

        if ($this->filter->status != "") {
            $customer->where('customer.is_active',$this->filter->status);
        }
        if ($this->filter->type == "member") {
            $customer->whereNotNull('customer_membership.customer_id');
        }
        if ($this->filter->type == "non") {
            $customer->whereNull('customer_membership.customer_id');
        }
        if ($this->filter->date_from != "") {
            $customer->whereDate('customer.created_at', '>=', $this->filter->date_from);
        }
        if ($this->filter->date_to != "") {
            $customer->whereDate('customer.created_at', '<=', $this->filter->date_to);
        }

        $customer->omniFilter();
        $customer = $customer->get();

        return $customer;
    }

    public function headings(): array
    {
        return [
            'Number',
            'Name',
            'Email',
            'Address',
            'Telp',
            'Company',
            'Registration Date',
        ];
    }

    public function map($cust): array
    {
        return [
            $cust->customer_number,
            $cust->customer_name,
            $cust->customer_email,
            $cust->customer_address,
            $cust->customer_telp,
            $cust->customer_company,
            date_format($cust->created_at,"d-m-Y H:i:s"),
            // Date::dateTimeToExcel($cust->created_at),
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    //     ];
    // }
}
