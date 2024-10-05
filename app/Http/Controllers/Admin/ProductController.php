<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\SubscriptionPackage;
use App\Models\Store;
use App\Models\Module;
use App\Models\Unit;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\CentralLibrary;
use App\Models\Attribute;

use DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function add()
    {
        $stores = Store::all();
        $modules = Module::where('status','1')->get();
        $unit = Unit::get();
        $attributes = Attribute::all();
        return view('admin.product.add', compact('stores','modules','unit','attributes'));
    }

    public function getCategory($id)
    {
        $categorys = Category::where('module_id',$id)->where('status','1')->get();
        return response()->json(['status' => true,'data' => $categorys]);
    }

    public function getsubCategory($id)
    {
        $subcategorys = SubCategory::where('category_id',$id)->where('status','1')->get();
        return response()->json(['status' => true,'data' => $subcategorys]);
    }

    public function getUnit($id)
    {
        $units = Unit::where('attribute_id',$id)->get();
        $attribute = Attribute::where('name',$id)->first();
        if($attribute){
            $units = Unit::where('attribute_id',$attribute->id)->get();
        }
        return response()->json(['status' => true,'data' => $units]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        $rules = [
            'barcode' => 'required|unique:products',
            'category_id' => 'required',
            'store_id' => 'required',
            'name' => 'required',
            'stock' => 'required',
            'wholesale_price' => 'required',
            'qtn' => 'required',
            'unit' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            #save image
            $product_image = $request->productImage;
            if ($product_image) {
                $path  = config('image.profile_image_path_view');
                $product_image = CommonController::saveImage($product_image, $path , 'product');
            }else{
                $product_image = null;
            }

            //check product exist or not
            $exists = Product::where('product_name', $request->name)
            ->where('quantity', $request->qtn)
            ->where('unit', $request->unit)
            ->where('store_id', $request->store_id)
            ->exists();
            if ($exists) {
                $fail('A product with the same name, qtn, and unit already exists in this store.');
            }
            

            //check barcode
            $existingProductWithSameName = Product::where('product_name', $request->name)
            ->where('store_id', $request->store_id)
            ->first();

            $barcode = $request->barcode;

            if ($existingProductWithSameName != null) {
                // If a product with the same name and store exists, use its barcode
                $barcode = $existingProductWithSameName->barcode;
            } elseif ($barcode != null) {
                // If a barcode is provided, check for its uniqueness
                $existingProductWithSameBarcode = Product::where('barcode', $barcode)
                    ->where('store_id', $request->store_id)
                    ->first();

                if ($existingProductWithSameBarcode != null) {
                    // If a product with the same barcode exists, return an error
                    return ["status" => 4, 'message' => 'Add a unique barcode.'];
                }
            }

            $product = Product::create([
                'store_id'           => $request->store_id,
                'module_id'          => $request->module_id,
                'category'           => $request->category_id,
                'subCategory_id'     => $request->subcategory_id,
                'barcode'            => $request->barcode,
                'product_image'      => $product_image,
                'product_name'       => $request->name,
                'unit'               => $request->unit,
                'package_weight'     => $request->package_weight,
                'package_size'       => $request->package_size,
                'quantity'           => $request->qtn,
                'mrp'                => $request->mrp,
                'retail_price'       => $request->retail_price,
                'wholesale_price'    => $request->wholesale_price,
                'members_price'      => $request->member_price,
                'purchase_price'     => $request->purchase_price,
                'stock'              => $request->stock,
                'low_stock'          => $request->low_stock,
                'gst'                => $request->gst,
                'hsn'                => $request->hsn,
                'cess'               => $request->CESS,
                'expiry'             => $request->expiry_date,
                'tags'               => $request->tag,
                'brand'              => $request->brand,
                'color'              => $request->color,
                'status'             => '1',  
            ]);

            //add central Library
            $existingProduct = CentralLibrary::where('product_name', $product->product_name)->where('quantity', $product->qtn)
            ->where('unit', $product->unit)->first();
            if (!$existingProduct) {
                
                $centrallib = new CentralLibrary();
                $centrallib->product_id = $product->id;
                $centrallib->module_id = $product->module_id;
                $centrallib->category = $product->category;
                $centrallib->subCategory_id = $product->subCategory_id;
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
            }


            DB::commit();
            return redirect()->route('admin.product.index')->with('message', 'Product added successfully');
        }
    }

    public function edit($id)
    {
        $package = Product::where('id',$id)->first();
        $stores = Store::all();
        $modules = Module::where('status','1')->get();
        $unit = Unit::get();
        $attributes = Attribute::all();
        return view('admin.product.edit', compact('package','stores','modules','unit','attributes'));
    }

    public function update(Request $request)
    {
        
        DB::beginTransaction();
        
        $rules = [
            'barcode' => 'required|unique:products,barcode,'.$request->productId,
            'category_id' => 'required',
            'store_id' => 'required',
            'name' => 'required',
            'stock' => 'required',
            'wholesale_price' => 'required',
            'qtn' => 'required',
            'unit' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            // print_r($request->all()); die;

            $product = Product::where('id', $request->productId)->first();

            #save image
            $product_image = $request->productImage;
            if ($product_image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $product->product_image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $product_image = CommonController::saveImage($product_image, $path , 'product');
            }else{
                $product_image = $request->oldImage;
            }

            $product->store_id           = $request->store_id;
            $product->module_id          = $request->module_id;
            $product->category           = $request->category_id;
            $product->subCategory_id     = $request->subcategory_id;
            $product->barcode            = $request->barcode;
            $product->product_image      = $product_image;
            $product->product_name       = $request->name;
            $product->unit               = $request->unit;
            $product->package_weight     = $request->package_weight;
            $product->package_size       = $request->package_size;
            $product->quantity           = $request->qtn;
            $product->mrp                = $request->mrp;
            $product->retail_price       = $request->retail_price;
            $product->wholesale_price    = $request->wholesale_price;
            $product->members_price      = $request->member_price;
            $product->purchase_price     = $request->purchase_price;
            $product->stock              = $request->stock;
            $product->low_stock          = $request->low_stock;
            $product->gst                = $request->gst;
            $product->hsn                = $request->hsn;
            $product->cess               = $request->CESS;
            $product->expiry             = $request->expiry_date;
            $product->tags               = $request->tag;
            $product->brand              = $request->brand;
            $product->color              = $request->color;
            $product->save();

            $existingProduct = CentralLibrary::where('product_name', $product->product_name)->where('quantity', $product->qtn)
            ->where('unit', $product->unit)->first();
            if (!$existingProduct) {
                $centrallib = new CentralLibrary();
                $centrallib->product_id = $product->id;
                $centrallib->module_id = $product->module_id;
                $centrallib->category = $product->category_id;
                $centrallib->subCategory_id = $product->subCategory_id;
                $centrallib->barcode = $product->barcode;
                $centrallib->unit = $product->unit;
                $centrallib->quantity = $product->qtn;
                $centrallib->product_name = $product->product_name;
                $centrallib->product_image = $product->product_image;
                $centrallib->package_weight = $product->package_weight;
                $centrallib->package_size    = $product->package_size;
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
            }

            DB::commit();
            return redirect()->route('admin.product.index')->with('message', 'Product updated successfully');
        }
    }

    public function delete($id)
    {
        $product = Product::where('id',$id)->first();
        $product->destroy($id);
        return response()->json(['status' => true,'message' => 'Product Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Product::with('store','module','category')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.product.index');
    }
}
