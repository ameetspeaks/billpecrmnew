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


class StoreExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function __construct($storeId)
    // {
    //     $this->storeId = $storeId;
    // }

    public function collection()
    {
        $store = DB::table('stores')->leftjoin('users','users.id','stores.user_id')
                            ->leftjoin('modules','modules.id','stores.module_id')
                            ->select('users.whatsapp_no','stores.shop_name','modules.name as module_name','stores.address as store_address','stores.owner_name','stores.gst',)
                            ->get();
        
        return collect($store);
    }

    public function headings(): array
    {
        return [
            "Whatsapp Number",
            "store Name",
            "Module Name",
            "Store Address" ,
            "Owner Name",
            "Gst Number",
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
