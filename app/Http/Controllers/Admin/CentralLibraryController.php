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
use App\Imports\ImportCentralLibrary;
use App\Exports\ExportCentralLibrary;
use App\Exports\ExportModuleByCentralLibrary;

use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CentralLibrary;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\Module;
use App\Models\Category;
use App\Models\Unit;
use App\Models\SubCategory;
use App\Models\Addon;
use App\Models\BlogCategory;
use App\Models\PromotionalBanner;
use App\Models\HomepageVideo;
use App\Models\Tutorial;
use App\Models\Zone;
use App\Models\SubZone;
use App\Models\Store;
use App\Models\Charges;

class CentralLibraryController extends Controller
{
    public function index()
    {
        $modules = Module::where('status',1)->get();
       return view('admin.centralLibrary.index', compact('modules'));
    }

    public function import(Request $request)
    {

        $rules = array(
            'productExcel'=>'required|mimes:csv,xlsx,xls' 
        ); 

        $validatorMesssages = array(
            'productExcel.required'=>'Excel file is required',
            'productExcel.mimes'=>'Only CSV,xlsx,xls and csv are extensions allow.', 
        );

        $validator = Validator::make($request->all(), $rules, $validatorMesssages); 
        if ($validator->fails()) { 
            $error=json_decode($validator->errors());
            return response()->json(['status' => 0,'error1' => $error]);
        }
        try{ 
            $check=Excel::import(new ImportCentralLibrary, $request->file('productExcel')->store('temp')); 
            return response()->json(['status' => 1,'success' => "File has been imported successfully"]);


        }catch(\CustomException $e){
            // print_r($e); die;
            // return response()->json(['status' => 2,'error' => $e->getMessage()]);
            return response()->json(['status' => 2,'error' => $e]);
        }
    }

    public function export()
    {
        return Excel::download(new ExportCentralLibrary, 'centralLib.xlsx');
    }

    public function add()
    {
        $unit = Unit::all();
        $categories = Category::where('status',1)->get();
        return view('admin.centralLibrary.add', compact('unit','categories'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 
        $rules = [
            'name' => 'required',
            'qtn' => 'required',
            'unit' => 'required',
            'mrp' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            if($request->image_Link)
            {
                $product_image = $request->image_Link;
            }else{
                #save image
                $product_image = $request->productImage;
                if ($product_image) {
                    $path  = config('image.profile_image_path_view');
                    $product_image = CommonController::saveImage($product_image, $path , 'centralLib');
                }else{
                    $product_image = null;
                }
            }
            

            //check product exist or not
            $exists = CentralLibrary::where('product_name', $request->name)
            ->where('quantity', $request->qtn)
            ->where('unit', $request->unit)
            ->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'A product with the same name, qtn, and unit already exists in central library.');
            }
            

            //check barcode
            $existingProductWithSameName = CentralLibrary::where('product_name', $request->name)
            ->first();

            $barcode = $request->barcode;

            if ($existingProductWithSameName != null) {
                // If a product with the same name and store exists, use its barcode
                $barcode = $existingProductWithSameName->barcode;
            } elseif ($barcode != null) {
                // If a barcode is provided, check for its uniqueness
                $existingProductWithSameBarcode = CentralLibrary::where('barcode', $barcode)
                    ->first();

                if ($existingProductWithSameBarcode != null) {
                    // If a product with the same barcode exists, return an error
                    return ["status" => 4, 'message' => 'Add a unique barcode.'];
                }
            }

            $product = CentralLibrary::create([
                'barcode'            => $barcode,
                'product_image'      => $product_image,
                'product_name'       => $request->name,
                'unit'               => $request->unit,
                'quantity'           => $request->qtn,
                'mrp'                => $request->mrp,
                'category'           => $request->category_id,
                'subCategory_id'     => $request->subcategory_id,
                'gst'                => $request->gst,
                'hsn'                => $request->hsn,
                'cess'               => $request->CESS,
                'expiry'             => $request->expiry_date,
                'tags'               => $request->tag,
                'brand'              => $request->brand,
            ]);

            DB::commit();
            return redirect()->route('admin.centralLibrary.index')->with('message', 'Product added in  central library');
        }
    }

    public function edit($id)
    {
        $package = CentralLibrary::where('id',$id)->first();
        $unit = Unit::get();

        $categories = Category::where('status',1)->get();
        return view('admin.centralLibrary.edit', compact('package','unit','categories'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction(); 
        $rules = [
            'name' => 'required',
            'qtn' => 'required',
            'unit' => 'required',
            'mrp' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
                        
            if($request->image_Link)
            {
                $product_image = $request->image_Link;
            }else{
                #save image
                $product_image = $request->productImage;
                if ($product_image) {
                    $path  = config('image.profile_image_path_view');
                    $product_image = CommonController::saveImage($product_image, $path , 'centralLib');
                }else{
                    $product_image = $request->oldImage;
                }
            }


            //check barcode
            $existingProductWithSameName = CentralLibrary::where('product_name', $request->name)
            ->first();

            $barcode = $request->barcode;

            if ($existingProductWithSameName != null) {
                // If a product with the same name and store exists, use its barcode
                $barcode = $existingProductWithSameName->barcode;
            } elseif ($barcode != null) {
                // If a barcode is provided, check for its uniqueness
                $existingProductWithSameBarcode = CentralLibrary::where('barcode', $barcode)
                    ->first();

                if ($existingProductWithSameBarcode != null) {
                    // If a product with the same barcode exists, return an error
                    return ["status" => 4, 'message' => 'Add a unique barcode.'];
                }
            }

            $product = CentralLibrary::where('id', $request->productId)->first();
            $product->barcode            = $request->barcode;
            $product->product_image      = $product_image;
            $product->product_name       = $request->name;
            $product->unit               = $request->unit;
            $product->quantity           = $request->qtn;
            $product->mrp                = $request->mrp;
            $product->gst                = $request->gst;
            $product->hsn                = $request->hsn;
            $product->cess               = $request->CESS;
            $product->expiry             = $request->expiry_date;
            $product->tags               = $request->tag;
            $product->brand              = $request->brand;
            $product->save();

            DB::commit();
            return redirect()->route('admin.centralLibrary.index')->with('message', 'Product update in  central library');
        }
    }

    public function delete($id)
    {
        $product = CentralLibrary::where('id',$id)->first();
        $product->destroy($id);
        return response()->json(['status' => true,'message' => 'Product Deleted in central library.']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = CentralLibrary::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.centralLibrary.index');
    }

    public function changeStatus(Request $request)
    {
        if($request->statusName == 'centralLib')
        {
            $product = CentralLibrary::where('id', $request->id)->first();
            if ($product->status == '1') {
                $product->status = '0';
            } else {
                $product->status = '1';
            }
            $product->save();
        }
        if($request->statusName == 'product')
        {
            $product = Product::where('id', $request->id)->first();
            if ($product->status == '1') {
                $product->status = '0';
            } else {
                $product->status = '1';
            }
            $product->save();
        }

        if($request->statusName == 'subscription')
        {
            $subscription = SubscriptionPackage::where('id', $request->id)->first();
            if ($subscription->status == '1') {
                $subscription->status = '0';
            } else {
                $subscription->status = '1';
            }
            $subscription->save();
        }

        if($request->statusName == 'module')
        {
            $module = Module::where('id', $request->id)->first();
            if ($module->status == '1') {
                $module->status = '0';
            } else {
                $module->status = '1';
            }
            $module->save();
        }

        if($request->statusName == 'category')
        {
            $category = Category::where('id', $request->id)->first();
            if ($category->status == '1') {
                $category->status = '0';
            } else {
                $category->status = '1';
            }
            $category->save();
        }

        if($request->statusName == 'subcategory')
        {
            $subcategory = SubCategory::where('id', $request->id)->first();
            if ($subcategory->status == '1') {
                $subcategory->status = '0';
            } else {
                $subcategory->status = '1';
            }
            $subcategory->save();
        }

        if($request->statusName == 'addon')
        {
            $addon = Addon::where('id', $request->id)->first();
            if ($addon->status == '1') {
                $addon->status = '0';
            } else {
                $addon->status = '1';
            }
            $addon->save();
        }

        if($request->statusName == 'blogcategory')
        {
            $blogcategory = BlogCategory::where('id', $request->id)->first();
            if ($blogcategory->status == '1') {
                $blogcategory->status = '0';
            } else {
                $blogcategory->status = '1';
            }
            $blogcategory->save();
        }

        if($request->statusName == 'promotion_bannner')
        {
            $promotion_bannner = PromotionalBanner::where('id', $request->id)->first();
            if ($promotion_bannner->status == '1') {
                $promotion_bannner->status = '0';
            } else {
                $promotion_bannner->status = '1';
            }
            $promotion_bannner->save();
        }

        if($request->statusName == 'homepage_video')
        {
            $homepage_video = HomepageVideo::where('id', $request->id)->first();
            if ($homepage_video->status == '1') {
                $homepage_video->status = '0';
            } else {
                $homepage_video->status = '1';
            }
            $homepage_video->save();
        }

        if($request->statusName == 'tutorial')
        {
            $tutorial = Tutorial::where('id', $request->id)->first();
            if ($tutorial->status == '1') {
                $tutorial->status = '0';
            } else {
                $tutorial->status = '1';
            }
            $tutorial->save();
        }

        if($request->statusName == 'zone')
        {
            $zone = Zone::where('id', $request->id)->first();
            if ($zone->status == '1') {
                $zone->status = '0';
            } else {
                $zone->status = '1';
            }
            $zone->save();
        }

        if($request->statusName == 'subzone')
        {
            $subzone = SubZone::where('id', $request->id)->first();
            if ($subzone->status == '1') {
                $subzone->status = '0';
            } else {
                $subzone->status = '1';
            }
            $subzone->save();
        }

        if($request->statusName == 'charges')
        {
            $charges = Charges::where('id', $request->id)->first();
            if ($charges->status == '1') {
                $charges->status = '0';
            } else {
                $charges->status = '1';
            }
            $charges->save();
        }
        return response()->json(['status' => true, 'message' => 'Status Change successfully']);
    }

    public function changeFeatured(Request $request)
    {
        if($request->changeFeatured == 'category')
        {
            $category = Category::where('id', $request->id)->first();
            if ($category->featured == '1') {
                $category->featured = '0';
            } else {
                $category->featured = '1';
            }
            $category->save();
        }

        if($request->changeFeatured == 'store')
        {
            $store = Store::where('id', $request->id)->first();
            if ($store->featured == '1') {
                $store->featured = '0';
            } else {
                $store->featured = '1';
            }
            $store->save();
        }

        return response()->json(['status' => true, 'message' => 'Featured Change successfully']);
    }

    public function exportByModule(Request $request)
    {
        $module_id = $request->module_id;
        return Excel::download(new ExportModuleByCentralLibrary($module_id), 'centralLibModuleWise.xlsx');
    }
}
