<?php

namespace App\Http\Controllers\Store;

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
use App\Models\Product;
use App\Models\CentralLibrary;
use App\Models\Attribute;
use App\Models\User;

use Session;
use DataTables;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProduct;
use App\Imports\ImportProduct;
use Auth;

use App\Models\ChangePackageSubscription;
use App\Models\PackageExtentDate;
use App\Models\StoreType;

class StoreController extends Controller
{
    public function storeList()
    {
        $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();
        $data = Store::with('user','package')->where('user_id',$userLogin->id)->get();
        if(\request()->ajax()){
            $data = Store::with('user','package')->where('user_id',$userLogin->id)->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.store-list');
    }

    public function add()
    {
        $modules = Module::all();
        $store_types = StoreType::all();
        return view('store.storeAdmin.add-store', compact('modules','store_types'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
       
        $rules = [
            'store_type' => 'required',
            'store_category' => 'required',
            'shop_name' => 'required',
            'owner_name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();

            #save image
            $store_image = $request->store_image;
            if ($store_image) {
                $path  = config('image.profile_image_path_view');
                $store_image = CommonController::saveImage($store_image, $path , 'store');
            }else{
                $store_image = null;
            }
            
            //get package
            $package = SubscriptionPackage::where('id',1)->first();
            $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));

            $storeAdd = Store::create([
                'user_id'               => $userLogin->id,
                'store_type'            => $request->store_type,
                'module_id'             => $request->store_category,
                'store_image'           => $store_image,
                'shop_name'             => $request->shop_name,
                'latitude'              => $request->latitude,
                'longitude'             => $request->longitude,
                'address'               => $request->address,
                'pincode'               => $request->pincode,
                'city'                  => $request->city,
                'gst'                   => $request->gst,
                'owner_name'            => $request->owner_name,
                'package_id'            => $package->id,
                'package_active_date'   => date('Y-m-d'),
                'package_valid_date'    => $validdate,
                'package_amount'        => $package->subscription_price,
                'package_status'        => $package->status,
            ]);

            $storeAdd->save();

            DB::commit();
            return redirect()->route('store.store-list')->with('message', 'Store added successfully');
        }
    }

    public function edit($id)
    {
        $store = Store::where('id',$id)->first();
        $modules = Module::all();
        $store_types = StoreType::all();
        $subcr_package = SubscriptionPackage::where('status', 1)->get();
        return view('store.storeAdmin.edit-store', compact('modules','store','subcr_package','store_types'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $rules = [
            'store_type' => 'required',
            'store_category' => 'required',
            'shop_name' => 'required',
            'owner_name' => 'required',
        ];
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            
            $store = Store::where('id', $request->store_id)->first();

            #save image
            $store_image = $request->store_image;
            if ($store_image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $store->store_image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $store_image = CommonController::saveImage($store_image, $path , 'store');
            }else{
                $store_image = $request->old_image;
            }

            $store->store_type = $request->store_type;
            $store->module_id = $request->store_category;
            $store->store_image = $store_image;
            $store->shop_name = $request->shop_name;
            $store->latitude = $request->latitude;
            $store->longitude = $request->longitude;
            $store->address = $request->address;
            $store->pincode = $request->pincode;
            $store->city = $request->city;
            $store->gst = $request->gst;
            $store->owner_name = $request->owner_name; 

            $newPackageId = $request->package_id;
            $newPackage = SubscriptionPackage::find($newPackageId);
            if ($newPackage) {
                if ($newPackageId != $store->package_id) {
                // Create a new instance of the Change_Package_Subscription model
                $changeSubscription = new ChangePackageSubscription();
            
                // Set the store_id
                $changeSubscription->store_id = $store->id;
            
                // Set the old subscription data
                $changeSubscription->last_package = $store->package_id;
                $changeSubscription->last_package_price = $store->package_amount;
                $changeSubscription->last_package_date = $store->package_valid_date; // Set to valid_package_date
            
                // Update the store with the new subscription data
                $store->package_id = $newPackageId;
                $store->package_amount = $newPackage->subscription_price;
            
                $today = now();
                $store->package_active_date = $today->toDateString();
            
                $end_date = $today->addDays($newPackage->validity_days);
                $store->package_valid_date = $end_date->toDateString();
                $changeSubscription->new_package = $newPackageId;
                $changeSubscription->new_package_price = $newPackage->subscription_price;
                $changeSubscription->new_package_date = now();
                $changeSubscription->save();
                }
            
            }

            $previousValidePackageDate = $store->package_valid_date;
            $extendDay = $request->input('extend_day');
            $newValidePackageDate = Carbon::parse($store->package_valid_date)->addDays($extendDay);
            $store->package_valid_date = $newValidePackageDate->toDateString();
            $store->save(); // Save the store model

            if ($request->extend_day !== null && $request->extend_day > 0) {
                $package_extend = new PackageExtentDate();
                $package_extend->store_id = $store->id;
                $package_extend->package_id = $store->package_id;
                $package_extend->extend_day = $request->extend_day;
                $package_extend->expiry_date = $previousValidePackageDate; // Use the previous value
                $package_extend->save();
            }
          
            DB::commit();
            return redirect()->route('store.store-list')->with('message', 'Store updated successfully');
        }
    }

    public function delete($id)
    {
        $store = Store::where('id',$id)->first();
        // $products = Product::where('store_id',$store->id)->delete();
        // $user = User::where('id',$store->user_id)->delete();
        $store->destroy($id);
        return response()->json(['status' => true,'message' => 'Store Deleted successfully']);
    }
}
