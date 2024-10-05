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

use App\Models\Module;
use App\Models\Coupan;

use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\ChangePackageSubscription;
use App\Models\PackageExtentDate;
use App\Models\StoreType;
use App\Models\Withdral;

use Carbon\Carbon;
use DataTables;

use Auth;
use App\Models\PackageOrder;
use App\Models\PackageTransection;

use App\Exports\StoreExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str; 

class StoreController extends Controller
{
    
    public function index()
    {
       return view('admin.store.index');
    }

    public function add()
    {
        $modules = Module::all();
        $storeTypes = StoreType::all();
        $roles = Role::where('id' , '!=', 1)->get();
        return view('admin.store.add', compact('modules','roles','storeTypes'));
    }

    public function store(Request $request)
    {
        
        DB::beginTransaction();
       
        $rules = [
            'whatsapp_no' => 'required|numeric|digits:10',
            'role_type' => 'required|numeric',
        ];
            if($request->role_type == '2' || $request->role_type == '3'){
                $rules['store_type'] = 'required';
                $rules['store_category'] = 'required';
                $rules['shop_name'] = 'required';
            }else if($request->role_type == '5'){
                $rules['aadhar_number'] = 'required';
                $rules['driving_licence'] = 'required';
            }else if($request->role_type == '6' || $request->role_type == '7'){
                $rules['user_id'] = 'required';
            }
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $checkUserformultiple = User::where('whatsapp_no',$request->whatsapp_no)->where('role_type',$request->role_type)->first();
            if($checkUserformultiple){
                return redirect()->back()->with('error', 'The user of this role already exists.');
            }

            #save image
            $image = $request->image;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path, 'user');
            }else{
                $image = null;
            }

            $roleID = Role::where('id',$request->role_type)->first();
            #add user
            $userAdd = User::create([
                'user_id'           => $request->user_id,
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => bcrypt($request->password),
                'role_type'         => $roleID->id,
                'whatsapp_no'       => $request->whatsapp_no,
                'image'             => $image,
                'unique_id'         => CommonController::generate_uuid('users'),
                'aadhar_number'     => $request->aadhar_number,
                'driving_licence'   => $request->driving_licence,
            ]);
            #assign role to user
            $userAdd->syncRoles($roleID->id);
            $userAdd->save();

            if($request->role_type == '2' ){

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
                    'user_id'               => $userAdd->id,
                    'store_type'             => $request->store_type,
                    'module_id'             => $request->store_category,
                    'store_image'           => $store_image,
                    'shop_name'             => $request->shop_name,
                    'latitude'              => $request->latitude,
                    'longitude'             => $request->longitude,
                    'address'               => $request->address,
                    'pincode'               => $request->pincode,
                    'city'                  => $request->city,
                    'gst'                   => $request->gst,
                    'owner_name'            => $request->name,
                    'package_id'            => $package->id,
                    'package_active_date'   => date('Y-m-d'),
                    'package_valid_date'    => $validdate,
                    'package_amount'        => $package->subscription_price,
                    'package_status'        => $package->status,
                ]);

                $storeAdd->save();
                
            }else{
                $storeAdd = null;
            }

            
            if(Auth::user()->role_type == 7)
            {
                DB::commit();
                return redirect()->route('admin.store.manualPayment')->with('message', 'Store added successfully');
            }
            DB::commit();
            return redirect()->route('admin.store.index')->with('message', 'Store added successfully');
        }
    }

    public function edit($id)
    {
        $modules = Module::all();
        $storeTypes = StoreType::all();
        $store = Store::with('user','module','package')->where('id',$id)->first();
        $subcr_package = SubscriptionPackage::where('status',1)->where('id', '!=', 1)->get();
        // print_r($store->toarray()); die;
        return view('admin.store.edit', compact('store','modules','subcr_package','storeTypes'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $rules = [
            'store_type' => 'required',
            'store_category' => 'required',
            'shop_name' => 'required',
        ];
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            #save image
            $store_image = $request->store_image;
            if ($store_image) {
                $path  = config('image.profile_image_path_view');
                $store_image = CommonController::saveImage($store_image, $path , 'store');
            }else{
                $store_image = $request->old_image;
            }

            $store = Store::where('id', $request->store_id)->first();
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
            return redirect()->route('admin.store.index')->with('message', 'Store updated successfully');
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
    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Store::with('user','module')->orderby('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.store.index');
    }

    public function export()
    {
        return Excel::download(new StoreExport, 'stores.xlsx');
    }

    public function manualPayment()
    {
        $stores = Store::with('user')->get();
        $subcr_package = SubscriptionPackage::where('status',1)->where('id', '!=', 1)->get();
        // print_r($stores->toarray()); die;
        return view('admin.store.manualPayment', compact('subcr_package','stores'));
    }

    public function getCoupanByCode(Request $request)
    {
        $coupan  = Coupan::where('code',$request->coupanCode)->whereRaw('FIND_IN_SET('.$request->store_id.', store_id)')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

        if($coupan){
            return response()->json(['success' => true , 'coupan' => $coupan]);
        }
        return response()->json(['success' => false , 'message' => 'Coupan Code is not valid.']);
    }

    public function addManualPayment(Request $request)
    {
        $orderCount = PackageOrder::count();
        $store = json_decode($request->store_data);
        $uniqueId = Str::random(8) . time();
        
        $package = SubscriptionPackage::where('id',$request->package_id)->first();
    
        $products = [
            'id' => $package->id,
            'name' => $package->name,
            'discription' => $package->discription,
            'price' => $package->subscription_price,
        ];

        $newOrderGenerate = new PackageOrder();
        $newOrderGenerate->store_id = $store->id;
        $newOrderGenerate->user_id = Auth::user()->id;
        $newOrderGenerate->product_details = json_encode($products);
        $newOrderGenerate->shipping_name = $request->shipping_name;
        $newOrderGenerate->shipping_address = $request->shipping_address;
        $newOrderGenerate->shipping_city = $request->shipping_city;
        $newOrderGenerate->shipping_code = $request->shipping_pincode;
        $newOrderGenerate->shipping_state = $request->shipping_state;
        $newOrderGenerate->copanCode = $request->coupanCode;
        $newOrderGenerate->coupanAmount = $request->coupanAmount;
        $newOrderGenerate->TotalAmount = $request->order_amount;
        $newOrderGenerate->unique_id = $uniqueId;
        $newOrderGenerate->combined_id = $orderCount + 1 . $uniqueId;
        $newOrderGenerate->order_number = $orderCount + 1;
        $newOrderGenerate->save();


        $newTransection = new PackageTransection();
        $newTransection->productOrder_id          = $newOrderGenerate->id;
        $newTransection->store_id                 = $store->id;
        $newTransection->cf_payment_id            = $request->payment_id;
        $newTransection->order_amount             = $request->order_amount;
        $newTransection->order_id                 = $request->order_id;
        $newTransection->payment_amount           = $request->payment_amount;
        $newTransection->payment_group            = $request->payment_type;
        $newTransection->payment_status           = 'SUCCESS';
        $newTransection->save();

        $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));
        $store = Store::where('id',$store->id)->first();
        $store->package_id = $package->id;
        $store->package_active_date = date('Y-m-d');
        $store->package_valid_date = $validdate;
        $store->package_amount = $package->subscription_price;
        $store->package_status = $package->status;
        $store->save();

        $invoiceUrl = url('subscriptionInvoice/'.$newOrderGenerate->combined_id);

        Store::where('id',$store->id)->update(['gst' => $request->billing_gst]);

        DB::commit();
        return redirect()->to($invoiceUrl);
    }

    public function billHistory()
    {
        if(\request()->ajax()){
            $data = PackageTransection::with('store')->orderBy('created_at', 'DESC')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.store.billHistory');
    }

    public function withdrawal()
    {
        if(\request()->ajax()){
            $data = Withdral::with('store','statusvalue')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.store.withdrawal');
    }
}
