<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\CentralLibrary;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use corbon\corbon;

class ImportProduct implements ToModel,WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable,SkipsErrors, SkipsFailures;
    public function rules(): array
    {
        return [ 
            "store_id" =>"required|exists:stores,id|integer",
            "category_id"=>"required|exists:categories,id|integer",
            "module_id"=>"required|exists:modules,id|integer",
            "name"=>"required",
            "stock" =>"required",
            "low_stock" =>"nullable",
            "mrp"=>"required",
            "unit"=>"required",
            'qtn' => "required",
        ];
    }

    public function model(array $row)
    {
        $count=DB::table("products")->where("product_name",$row["name"])->where("store_id",$row["store_id"])->count();
        $verified = true;

        //check product exist or not
        $exists = Product::where('product_name', $row["name"])
        ->where('quantity', $row["qtn"])
        ->where('unit', $row["unit"])
        ->where('store_id', $row["store_id"])
        ->exists();
        if ($exists) {
            $verified = false;
        }

        //check barcode
        $existingProductWithSameName = Product::where('product_name', $row["name"])
        ->where('store_id', $row["store_id"])
        ->first();

        if ($existingProductWithSameName) {
            $category_id = DB::table('categories')->where('id', $existingProductWithSameName->category)->value('id');

            if ($category_id != $row["category_id"]) {
                $verified = false;
            }
        }

        $barcode = $row["barcode"];
        if ($existingProductWithSameName != null) {
            // If a product with the same name and store exists, use its barcode
            $barcode = $existingProductWithSameName->barcode;
        } elseif ($barcode != null) {
            // If a barcode is provided, check for its uniqueness
            $existingProductWithSameBarcode = Product::where('barcode', $barcode)
                ->where('store_id', $row["store_id"])
                ->first();

            if ($existingProductWithSameBarcode != null) {
                // If a product with the same barcode exists, return an error
                $verified = false;
            }
        }

        if($count==0){  
            $product = Product::create([
                'store_id'           => $row["store_id"],
                'module_id'          => $row["module_id"],
                'category'           => $row["category_id"],
                'barcode'            => $barcode,
                'product_image'      => $row["image"],
                'product_name'       => $row["name"],
                'unit'               => $row["unit"],
                'package_weight'     => $row["package_weight"],
                'package_size'       => $row["package_size"],
                'quantity'           => $row["qtn"],
                'mrp'                => $row["mrp"],
                'retail_price'       => $row["retail_price"],
                'wholesale_price'    => $row["wholesale_price"],
                'members_price'      => $row["members_price"],
                'purchase_price'     => $row["purchase_price"],
                'stock'              => $row["stock"],
                'low_stock'          => $row["low_stock"],
                'gst'                => $row["gst"],
                'hsn'                => $row["hsn"],
                'cess'               => $row["cess"],
                'expiry'             => $row["expiry_date"],
                'tags'               => $row["tag"],
                'brand'              => $row["brand"],
                'color'              => $row["color"],
                'status'             => '1',  
            ]);
        } // IF end

        // Add Products in central Library
        $countcent=DB::table("central_libraries")->where("product_name",$row["name"])->count();
        if($countcent==0){  
            $centrallib = new CentralLibrary();
            $centrallib->product_id = $product->id;
            $centrallib->module_id = $product->module_id;
            $centrallib->category = $product->category;
            $centrallib->barcode = $product->barcode;
            $centrallib->unit = $product->unit;
            $centrallib->quantity = $product->quantity;
            $centrallib->product_name = $product->product_name;
            $centrallib->product_image = $product->product_image;
            $centrallib->package_weight = $product->package_weight;
            $centrallib->package_size = $product->package_size;
            $centrallib->mrp = $product->mrp;
            $centrallib->retail_price = $product->retail_price;
            $centrallib->wholesale_price = $product->wholesale_price;
            $centrallib->members_price = $product->members_price;
            $centrallib->purchase_price = $product->purchase_price;
            $centrallib->gst = $product->gst;
            $centrallib->hsn = $product->hsn;
            $centrallib->cess = $product->cess;
            $centrallib->expiry = $product->expiry;
            $centrallib->tags = $product->tag;
            $centrallib->brand = $product->brand;
            $centrallib->color = $product->color;
            $centrallib->save();
        } // IF end
    }
}
