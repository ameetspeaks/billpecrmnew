<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Models\Store;
use App\Models\Module;
use App\Models\StoreType;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\BillDetail;
use App\Models\Testing;
use App\Models\Attribute;
use App\Models\AppVersion;
use App\Models\TemplateCategory;
use App\Models\TemplateMarket;
use App\Models\TemplateOffer;
use App\Models\VendorStockPurchase;
use App\Models\Coupan;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Verifications;
use App\Models\ProductVariation;

use App\Models\SubscriptionPackage;
use App\Models\WholesellerBillcreate;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Models\CentralLibrary;
use Illuminate\Support\Facades\Auth;

use App\Models\SubCategory;
use App\Models\PackageOrder;
use App\Models\PackageTransection;
use App\Models\TemplateType;

use Illuminate\Support\Str;
use App;
use Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

use Barryvdh\DomPDF\Facade as PDF;

class ApiUpdateController extends Controller
{
    public function getModuleByStoreType(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_type_id' => 'required|exists:store_types,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $modules = Module::whereIn('store_type_id',[$request->store_type_id,3])->get();
                if($request->store_type_id == 3)
                {
                    $modules = Module::where('store_type_id',$request->store_type_id)->get();
                }
                $response = ['success' => true, 'message' => 'Modules detail', 'Module' => $modules];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getUnitByModule(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'module_id' => 'required|exists:modules,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $units = Unit::where('module_id',$request->module_id)->get();
                $response = ['success' => true, 'message' => 'Units detail', 'Units' => $units];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addProductByVariant(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'product_type' => 'required',
                'name' => 'required|string',
            ];

                if($request->product_type == 'Simple'){
                    $rules['qtn'] = 'required|numeric';
                    $rules['unit'] = 'required';
                    $rules['category_id'] = 'nullable|exists:categories,id|numeric';
                    $rules['mrp'] = 'required';
                    $rules['stock'] = 'required|numeric';
                }
                if($request->product_type == 'Variable'){
                    $rules['variant_list'] = 'required|array';
                    $rules['variant_list.*.attributes'] = 'required';
                    $rules['variant_list.*.units'] = 'required';
                    $rules['variant_list.*.mrp'] = 'required';
                    $rules['variant_list.*.stock'] = 'required';
                }

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->first(),'data' => null];
            } else {

                $store = Store::where('id',$request->store_id)->first();

                if($request->product_type == "Simple"){

                    $existingProductInDifferentCategory = Product::where('quantity', $request->qtn)
                    ->where('unit', $request->unit)
                    ->where('product_name', $request->name)
                    ->where('store_id', $request->store_id)
                    ->first();

                    if ($existingProductInDifferentCategory) {
                        return ["status" => false, 'message' => 'A product with the same qtn and unit exists already.'];
                    }

                    $existingProductWithSameName = Product::where('product_name', $request->name)
                    ->where('store_id', $request->store_id)
                    ->first();

                    $barcode = $request->barcode;
                    $barcode_two = $request->barcode_two;

                    if ($existingProductWithSameName != null) {
                        // If a product with the same name and store exists, use its barcode
                        $barcode = $existingProductWithSameName->barcode;
                        $barcode_two = $existingProductWithSameName->barcode_two;
                    } elseif ($barcode != null) {

                        // If a barcode is provided, check for its uniqueness
                        $existingProductWithSameBarcode = Product::where('store_id', $request->store_id)
                            ->where('barcode', $barcode)
                            ->first();

                        if ($existingProductWithSameBarcode != null) {
                            // If a product with the same barcode exists, return an error
                            return ["status" => false, 'message' => 'Add a unique barcode.'];
                        }
                    }

                    $category_id = $request->category_id ?? $this->getUncategorizedCategoryIdForStore($request->store_id);


                    #save image
                    $product_image = $request->product_image;
                    if ($product_image) {
                        $path  = config('image.profile_image_path_view');
                        $product_image = CommonController::saveImage($product_image, $path , 'product');
                    }else{
                        $product_image = null;
                    }

                    $category = Category::where('id',$category_id)->first();

                    $product = Product::create([
                        'store_id'           => $request->store_id,
                        'module_id'          => $store->module_id,
                        'category'           => $category_id,
                        'subCategory_id'     => $request->subcategory_id,
                        'barcode'            => $barcode,
                        'barcode_two'        => $barcode_two,
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
                        'food_type'              => $request->food_type,
                    ]);
                    $product->save();

                    //add central Library
                    $existingProduct = CentralLibrary::where('product_name', $product->product_name)->where('quantity', $product->qtn)
                    ->where('unit', $product->unit)->first();
                    if (!$existingProduct) {

                        $centrallib = new CentralLibrary();
                        $centrallib->product_id = $product->id;
                        $centrallib->module_id = $product->module_id;
                        $centrallib->category = $request->subcategory_id;
                        $centrallib->subCategory_id = $product->module_id;
                        $centrallib->barcode = $product->barcode;
                        $centrallib->barcode_two = $product->barcode_two;
                        $centrallib->unit = $product->unit;
                        $centrallib->quantity = $product->quantity;
                        $centrallib->product_name = $product->product_name;
                        $centrallib->product_image = $product->product_image;
                        $centrallib->package_weight = $product->package_weight;
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
                        $centrallib->food_type = $product->food_type;
                        $centrallib->save();
                    }
                    //

                    $product->category = $category;
                }

                if($request->product_type == "Variable"){

                    $existingProductWithSameName = Product::where('product_name', $request->name)
                        ->where('store_id', $request->store_id)
                        ->first();

                    $barcode = $request->barcode;
                    $barcode_two = $request->barcode_two;

                    if ($existingProductWithSameName != null) {
                        // If a product with the same name and store exists, use its barcode
                        $barcode = $existingProductWithSameName->barcode;
                        $barcode_two = $existingProductWithSameName->barcode_two;
                    } elseif ($barcode != null) {

                        // If a barcode is provided, check for its uniqueness
                        $existingProductWithSameBarcode = Product::where('store_id', $request->store_id)
                            ->where('barcode', $barcode)
                            ->first();

                        if ($existingProductWithSameBarcode != null) {
                            // If a product with the same barcode exists, return an error
                            return ["status" => false, 'message' => 'Add a unique barcode.'];
                        }
                    }

                    $category_id = $request->category_id ?? $this->getUncategorizedCategoryIdForStore($request->store_id);
                    $category = Category::where('id',$category_id)->first();

                    $product = Product::create([
                        'store_id'           => $request->store_id,
                        'module_id'          => $store->module_id,
                        'category'           => $category_id,
                        'subCategory_id'     => $request->subcategory_id,
                        'barcode'            => $barcode,
                        'barcode_two'        => $barcode_two,
                        'product_name'       => $request->name,
                        'attributes'         => $request->variant_list[0]['attributes'],
                        'gst'                => $request->gst,
                        'hsn'                => $request->hsn,
                        'cess'               => $request->CESS,
                        'expiry'             => $request->expiry_date,
                        'tags'               => $request->tag,
                        'brand'              => $request->brand,
                        'color'              => $request->color,
                        'status'             => '1',
                    ]);
                    $product->save();

                    foreach($request->variant_list as $variant_list)
                    {
                        #save image
                        $product_image = $variant_list['product_image'];

                        if ($product_image) {
                            $path  = config('image.profile_image_path_view');
                            $product_image = CommonController::saveImage($product_image, $path , 'product');
                        }else{
                            $product_image = null;
                        }

                        $productVariation = ProductVariation::create([
                            'product_id'         => $product->id,
                            'unit'               => $variant_list['units'],
                            'variant_combination'=> json_encode (array_combine(explode(',',$variant_list['attributes']), explode(',',$variant_list['units']))),
                            'quantity'           => '1',
                            'mrp'                => $variant_list['mrp'],
                            'stock'              => $variant_list['stock'],
                            'low_stock'          => $variant_list['low_stock'],
                            'image'      => $product_image,

                        ]);
                        $productVariation->save();
                    }
                }

                DB::commit();
                $response = ['success' => true, 'message' => 'Product added successfully', 'data' => $product];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function editProductByVariant(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_type' => 'required',
                'name' => 'required|string',
                'product_id' => 'required|exists:products,id|numeric',
            ];

                if($request->product_type == 'Simple'){
                    $rules['qtn'] = 'required|numeric';
                    $rules['unit'] = 'required';
                    $rules['category_id'] = 'nullable|exists:categories,id|numeric';
                    $rules['mrp'] = 'required';
                    $rules['stock'] = 'required|numeric';
                }
                if($request->product_type == 'Variable'){
                    $rules['variant_list'] = 'required|array';
                    $rules['variant_list.*.id'] = 'required';
                    $rules['variant_list.*.attributes'] = 'required';
                    $rules['variant_list.*.units'] = 'required';
                    $rules['variant_list.*.mrp'] = 'required';
                    $rules['variant_list.*.stock'] = 'required';
                }

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {


                if($request->product_type == "Simple"){
                    $product = Product::with('category')->where('id', $request->product_id)->first();

                    #save image
                    $product_image = $request->product_image;
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
                        $product_image = $product->product_image;
                    }

                    $category_id = $request->category_id ?? $this->getUncategorizedCategoryIdForStore($request->store_id);

                    $product->category           = $category_id;
                    $product->subCategory_id     = $request->subcategory_id;
                    $product->product_name       = $request->name;
                    $product->barcode            = $request->barcode;
                    $product->barcode_two        = $request->barcode_two;
                    $product->product_image      = $product_image;
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
                    $product->food_type              = $request->food_type;
                    $product->save();

                    $existingProduct = CentralLibrary::where('product_name', $product->product_name)->where('quantity', $product->qtn)
                    ->where('unit', $product->unit)->first();
                    if (!$existingProduct) {
                        $centrallib = new CentralLibrary();
                        $centrallib->product_id = $product->id;
                        $centrallib->module_id = $product->module_id;
                        $centrallib->category = $product->category_id;
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
                        $centrallib->food_type = $product->food_type;
                        $centrallib->save();
                    }
                }

                if($request->product_type == "Variable"){
                    $category_id = $request->category_id ?? $this->getUncategorizedCategoryIdForStore($request->store_id);

                    $product = Product::with('category')->where('id', $request->product_id)->first();
                    $product->category           = $category_id;
                    $product->subCategory_id     = $request->subcategory_id;
                    $product->product_name       = $request->name;
                    $product->barcode            = $request->barcode;
                    $product->barcode_two        = $request->barcode_two;
                    $product->gst                = $request->gst;
                    $product->hsn                = $request->hsn;
                    $product->cess               = $request->CESS;
                    $product->expiry             = $request->expiry_date;
                    $product->tags               = $request->tag;
                    $product->brand              = $request->brand;
                    $product->color              = $request->color;
                    $product->food_type              = $request->food_type;
                    $product->save();

                    foreach($request->variant_list as $variant_list)
                    {
                        $productVariation = ProductVariation::where('id', $variant_list['id'])->first();

                        #save image
                        $product_image = $variant_list['product_image'];
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
                            $product_image = $product->product_image;
                        }

                        $productVariation->unit  = $variant_list['units'];
                        $productVariation->variant_combination  = json_encode (array_combine(explode(',',$variant_list['attributes']), explode(',',$variant_list['units'])));
                        $productVariation->mrp  = $variant_list['mrp'];
                        $productVariation->stock  = $variant_list['stock'];
                        $productVariation->low_stock  = $variant_list['low_stock'];
                        $productVariation->image  = $product_image;
                        $productVariation->save();
                    }
                }

                DB::commit();
                $response = ['success' => true, 'message' => 'Product updated successfully', 'data' => $product];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    private function getUncategorizedCategoryIdForStore($store_id)
    {
        $store = Store::where('id',$store_id)->first();
        $uncategorizedCategory = Category::where('name', 'Uncategorized')
            ->where('module_id', $store->module_id)
            ->first();

        if (!$uncategorizedCategory) {
            // If "Uncategorized" category doesn't exist for the store module, create it
            $uncategorizedCategory = new Category();
            $uncategorizedCategory->name = 'Uncategorized';
            $uncategorizedCategory->module_id = $store->module_id;
            $uncategorizedCategory->save();
        }

        return $uncategorizedCategory->id;
    }
}
