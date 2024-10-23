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
use App\Models\CentralLibrary;
use App\Models\SubCategory;

class ExportModuleByCentralLibrary implements FromCollection, WithHeadings
{
    protected $module_id;

    public function __construct($module_id)
    {
        $this->module_id = $module_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = CentralLibrary::where('module_id',$this->module_id)->select('module_id','category','subCategory_id','barcode','food_type','product_image','product_name','unit','quantity','mrp','retail_price','wholesale_price','members_price','purchase_price','stock','low_stock','gst','hsn','cess','expiry','tags','brand','color')->get()->toarray();
        // print_r($data->toarray()); die;
        return collect($data);

    }

    public function headings(): array
    {
        return [
            "module_id",
            "category",
            "subCategory_id",
            "barcode",
            "food_type",
            "product_image",
            "product_name",
            "unit",
            "quantity",
            "mrp" ,
            'retail_price',
            "wholesale_price",
            "members_price",
            "purchase_price",
            "stock",
            "low_stock",
            "gst",
            "hsn",
            "cess",
            "expiry",
            "tags",
            "brand",
            "color",
        ];
    }
}
