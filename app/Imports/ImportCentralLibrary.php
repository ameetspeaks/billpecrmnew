<?php

namespace App\Imports;

use App\Models\CentralLibrary;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ImportCentralLibrary implements ToModel, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    private $currentRow = 0;

    public function rules(): array
    {
        return [ 
            "name"=>"required",
            "qtn"=>"required",
            "unit"=>"required",
            'mrp' => "required",
        ];
    }

    public function model(array $row)
    {
        $count=CentralLibrary::where("product_name",$row["name"])->count();
        $verified = true;
        //check product exist or not
        $exists = CentralLibrary::where('product_name', $row['name'])
        ->where('quantity', $row['qtn'])
        ->where('unit', $row['unit'])
        ->exists();
        if ($exists) {
            $verified = false;
        }

        //check barcode
        $existingProductWithSameName = CentralLibrary::where('product_name', $row['name'])
        ->first();

        $barcode = $row['barcode'];

        if ($existingProductWithSameName != null) {
            // If a product with the same name and store exists, use its barcode
            $barcode = $existingProductWithSameName->barcode;
        } elseif ($barcode != null) {
            // If a barcode is provided, check for its uniqueness
            $existingProductWithSameBarcode = CentralLibrary::where('barcode', $barcode)
                ->first();

            if ($existingProductWithSameBarcode != null) {
                // If a product with the same barcode exists, return an error
                $verified = false;
            }
        }

        if($count == 0){
            $centrallLib = new CentralLibrary();
            $centrallLib->module_id = $row['module_id'];
            $centrallLib->category = $row['category_id'];
            $centrallLib->subCategory_id = $row['subcategory_id'];
            $centrallLib->product_name = $row['name'];
            $centrallLib->product_image = $row['image'];
            $centrallLib->barcode = $barcode;
            $centrallLib->unit = $row['unit'];
            $centrallLib->quantity = $row['qtn'];
            $centrallLib->mrp = $row['mrp'];
            $centrallLib->wholesale_price = $row['wholesale_price'];
            $centrallLib->status = $row['brand'];
            $centrallLib->status = $row['status'];
            $centrallLib->save();  
        }    
    }
}
