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

class ExportCentralLibrary implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    { 
        $subcategories = SubCategory::with('category')->where('status',1)->get();
        $arr = [];
        foreach($subcategories as $subcategorie)
        {
            $arr1 = [
                'module_id' => $subcategorie->category['module_id'],
                'category_id' => $subcategorie->category['id'],
                'category_name' => $subcategorie->category['name'],
                'subcategory_id' => $subcategorie->id,
                'subcategory_name' => $subcategorie->name,
            ];
            array_push($arr , $arr1);
        }
        
        $categorys = Category::select('module_id','id as category_id','name as category_name')->where('status',1)->get();
        foreach($categorys as $category)
        {
            $category->subcategory_id = null;
            $category->subcategory_name = null;
        }

        $totalArray = array_merge($arr, $categorys->toarray());
        return collect($arr);
       
        // $data= CentralLibrary::orderBy('id',"ASC")->first();
        // return $updateValues=CentralLibrary::select("barcode", "product_name","product_image","quantity","unit","mrp","wholesale_price")->where("id",$data->id)->get()->map(function($row){
        //     return $row;
        // });
    }

    public function headings(): array
    {
        return [
            "module_id",
            "category_id",
            "category_name",
            "subcategory_id",
            "subcategory_name",
            "barcode",
            "name",
            "image",
            "unit",
            "qtn",
            "mrp" ,
            "wholesale_price",
            "brand",
            "status",
        ];
    }
}
