<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Store;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Session;
use DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use Maatwebsite\Excel\Sheet;
use App\Models\BillDetail;

class BillExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($billid)
    {
        $this->billids = $billid;
    }

    public function collection()
    {
        $billExport = DB::table('bill_details')->leftjoin('stores','stores.id','bill_details.store_id')
                            ->select('stores.shop_name', 'bill_details.product_detail','bill_details.customer_name','bill_details.customer_number','bill_details.amount','bill_details.discount','bill_details.total_amount','bill_details.due_amount','bill_details.due_date','bill_details.payment_methord')
                            ->whereIn('bill_details.id', $this->billids)
                            ->get();
        return collect($billExport);
    }

    public function headings(): array
    {
        return [
            "Store Name",
            "Product Details",
            "Customer Name",
            "Customer Number",
            "Amount" ,
            "Discount" ,
            "Total Amount" ,
            "Due Amount" ,
            "Due Date" ,
            "Payment Method" ,
        ];
    }

    public function styles(Worksheet $sheet)
{
    return [
       // Style the first row as bold text.
       1    => ['font' => ['bold' => true]],
    ];
}
}
