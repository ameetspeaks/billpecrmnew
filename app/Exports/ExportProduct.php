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

class ExportProduct implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($storeId)
    {
        $this->storeId = $storeId;
    }

    public function collection()
    {
        $store = Store::where('id',Session::get('store_id'))->first();
        $categorys = Category::select('id','name','module_id')->where('module_id',$store->module_id)->get();
        foreach($categorys as $category)
        {
            $category->store_id = $store->id;
        }
        return $categorys;
    }

    public function headings(): array
    {
        return [
            "category_id",
            "category_name",
            "module_id",
            "store_id" ,
            "barcode",
            "name",
            "image",
            "unit",
            "qtn",
            "package_weight",
            "package_size",
            "mrp" ,
            "retail_price",
            "wholesale_price",
            "members_price",
            "purchase_price",
            "stock" ,
            "low_stock" ,
            "gst" ,
            "hsn",
            "cess", 
            "expiry_date",
            "tag",
            "brand",
            "color",
        ];
    }

    public function styles(Worksheet $sheet)
    {   

        $sheet->getStyle('A1:R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:R1')->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow background color
        $sheet->getStyle('A1:R1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('A1:A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:A1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('A1:A1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
       
        $sheet->getStyle('B1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B1:B1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('B1:B1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('D1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('D1:D1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('D1:D1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('G1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('G1:G1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('G1:G1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('H1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('H1:H1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('H1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('K1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('K1:K1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('K1:K1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('M1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('M1:M1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('M1:M1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        $sheet->getStyle('N1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('N1:N1')->getFill()->getStartColor()->setARGB('ff0e0e'); // Yellow background color
        $sheet->getStyle('N1:N1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);

        $sheet->getStyle('S1:S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('S1:S1')->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow background color
        $sheet->getStyle('S1:S1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);

        $sheet->getStyle('T1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('T1:T1')->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow background color
        $sheet->getStyle('T1:T1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);

        $sheet->getStyle('U1:U1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('U1:U1')->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow background color
        $sheet->getStyle('U1:U1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);

        $sheet->getStyle('V1:V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('V1:V1')->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow background color
        $sheet->getStyle('V1:V1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        
        
     
        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(false);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(false);
        $sheet->getColumnDimension('T')->setAutoSize(false);
        $sheet->getColumnDimension('U')->setAutoSize(false);
        $sheet->getColumnDimension('V')->setAutoSize(true);


        return [
        // Style the first row as bold text.
        1    => ['font' => ['bold' => true]],
        ];
    }
}
