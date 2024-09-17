<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\AppActivity;
use App\Models\Category;
use App\Models\Product;
use App\Models\TemplateOffer;
use App\Models\Module;
use App\Models\MultipleAddress;
use App\Models\CustomerOrder;
use App\Models\Otp;
use App\Models\Filter;
use App\Models\AddtoCart;
use App\Models\SubZone;
use App\Models\HomeDeliveryDetail;
use App\Models\CustomerCoupan;
use App\Models\OrderStatus;

use Illuminate\Support\Str;
use App;
use Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

use PDF;
use Carbon\Carbon;

use App\Exports\BillExport;
use Excel;

class CustomerAppController extends Controller
{
    public function sendOTP(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'phone' => 'required|numeric|digits:10',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                if($request->phone == '9634188285' || $request->phone == '9670006261'){
                    $randNo = '123456';
                }else{
                    $randNo = rand(100000, 999999);
                    $sendOtpResponse = CommonController::sendMsg91WhatsappOtp($request->phone,$randNo);
                }
                $checkPhone = Otp::where('phone_number',$request->phone)->first();
                if($checkPhone){
                    $otp = Otp::where('phone_number',$request->phone)->update(['otp' => $randNo]);
                }else{
                    $otp = Otp::create([
                        'phone_number'     => $request->phone,
                        'otp'              => $randNo,
                    ]);
                }
                DB::commit();

                $response = ['success' => true, 'message' => 'Otp send successfully'];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function verifyOTP(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'phone' => 'required|numeric|digits:10',
                'otp'   => 'required|numeric',
                'device_token' => 'required',
                'role_type' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $checkOtp = Otp::where("phone_number",$request->phone)->where('otp',$request->otp)->first();
                if($checkOtp){
                    $user = User::where('whatsapp_no',$request->phone)->where('role_type',$request->role_type)->first();
                    if($user){
                        User::where('whatsapp_no',$request->phone)->where('role_type',$request->role_type)->update(['device_token' => $request->device_token]);
                        $user = User::where('whatsapp_no',$request->phone)->where('role_type',$request->role_type)->first();

                        $address = MultipleAddress::where('user_id',$user->id)->where('label',$user->label)->first();
                        $user->address = $address;
                        // print_r($address); die;

                        Auth::login($user);
                        $token = $user->createToken('billpe.cloud')->accessToken;

                        $activity = AppActivity::create([
                            'action'  => 'Login',
                            'message' => $user->name.' logged in',
                        ]);
                        $activity->save();

                        DB::commit();

                        return response()->json(['success' => true, 'is_complete' => true, 'message' => 'User Login successfully.', 'token' => $token, 'data' => $user], 200);
                    }else{

                        $roleID = Role::where('id',$request->role_type)->first();

                        $customer = new User();
                        $customer->whatsapp_no = $request->phone;
                        $customer->role_type = $request->role_type;
                        $customer->unique_id = CommonController::generate_uuid('users');
                        $customer->device_token = $request->device_token;
                        $customer->save();

                        #assign role to user
                        $customer->syncRoles($roleID->id);
                        $customer->save();

                        $token = $customer->createToken('billpe.cloud')->accessToken;
                        $user = User::where('id',$customer->id)->first();
                        Auth::login($user);
                        DB::commit();

                        return Response::json(['success' => true, 'is_complete' => false,  'message' => 'Complete your profile.', 'token'=> $token, 'data' => $user], 200);
                    }
                }else{
                    return Response::json(['success' => false, 'message' => "Phone or otp is not valid. Enter valid detail."], 404);
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function verifyTokenWithRole(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'otpless_token' => 'required',
                'device_token' => 'required',
                'role_type' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {
                $verifyOtpLess = CommonController::verifyOTPLess($request->otpless_token);
                if(array_key_exists('message',$verifyOtpLess))
                {
                    return Response::json(['status' => false, 'message' => 'Unable to login. kindly login first.'], 200);
                }

                if($verifyOtpLess['authentication_details']['phone'])
                {
                    $phoneNumber = $verifyOtpLess['authentication_details']['phone']['phone_number'];
                    $user = User::where('whatsapp_no',$phoneNumber)->where('role_type',$request->role_type)->first();

                    if($user){
                        $store = null;
                        if($user->role_type == 2){
                            $store = Store::where('user_id', $user->id)->first();
                        }
                        User::where('whatsapp_no',$phoneNumber)->where('role_type',$request->role_type)->update(['device_token' => $request->device_token]);
                        $user = User::where('whatsapp_no',$phoneNumber)->where('role_type',$request->role_type)->first();
                        $address = MultipleAddress::where('user_id',$user->id)->where('label',$user->label)->first();
                        $user->address = $address;

                        Auth::login($user);
                        $token = $user->createToken('billpe.cloud')->accessToken;

                        $activity = AppActivity::create([
                            'action'  => 'Login',
                            'message' => $user->name.' logged in',
                        ]);
                        $activity->save();

                        DB::commit();

                        return response()->json(['success' => true, 'is_complete' => true, 'message' => 'User Login successfully.', 'token' => $token, 'data' => $user, 'store' => $store], 200);
                    }else{

                        $roleID = Role::where('id',$request->role_type)->first();

                        $customer = new User();
                        $customer->whatsapp_no = $phoneNumber;
                        $customer->role_type = $request->role_type;
                        $customer->unique_id = CommonController::generate_uuid('users');
                        $customer->device_token = $request->device_token;
                        $customer->save();

                        #assign role to user
                        $customer->syncRoles($roleID->id);
                        $customer->save();

                        $token = $customer->createToken('billpe.cloud')->accessToken;
                        $user = User::where('id',$customer->id)->first();
                        Auth::login($user);
                        DB::commit();

                        return Response::json(['success' => true, 'is_complete' => false,  'message' => 'Complete your profile.', 'token'=> $token, 'data' => $user], 200);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addCustomerAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'label' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {

                $check_Customer = User::where('id',$request->user_id)->first();
                $check_Customer->address = $request->address;
                $check_Customer->latitude = $request->latitude;
                $check_Customer->longitude = $request->longitude;
                $check_Customer->city = $request->city;
                $check_Customer->state = $request->state;
                $check_Customer->country = $request->country;
                $check_Customer->label = $request->label;
                $check_Customer->save();

                $customerMultiAdd = new MultipleAddress();
                $customerMultiAdd->user_id = $request->user_id;
                $customerMultiAdd->address = $request->address;
                $customerMultiAdd->latitude = $request->latitude;
                $customerMultiAdd->longitude = $request->longitude;
                $customerMultiAdd->city = $request->city;
                $customerMultiAdd->state = $request->state;
                $customerMultiAdd->country = $request->country;
                $customerMultiAdd->label = $request->label;
                $customerMultiAdd->save();

                $activity = AppActivity::create([
                    'action'  => 'Customer Update Address',
                    'message' => $check_Customer->name.' update address in',
                ]);
                $activity->save();
                DB::commit();
                return Response::json(['success' => true, 'message' => 'Customer update address.', 'data' => $check_Customer], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addMultipleAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'label' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {

                $checkLableAdd = MultipleAddress::where('user_id', $request->user_id)->where('label',$request->label)->first();
                if($checkLableAdd){
                    return Response::json(['status' => false, 'message' => 'This lable address has already been taken.'], 404);
                }

                $customerMultiAdd = new MultipleAddress();
                $customerMultiAdd->user_id = $request->user_id;
                $customerMultiAdd->address = $request->address;
                $customerMultiAdd->latitude = $request->latitude;
                $customerMultiAdd->longitude = $request->longitude;
                $customerMultiAdd->city = $request->city;
                $customerMultiAdd->state = $request->state;
                $customerMultiAdd->country = $request->country;
                $customerMultiAdd->label = $request->label;
                $customerMultiAdd->save();

                $activity = AppActivity::create([
                    'action'  => 'Add Multipe Address',
                    'message' => Auth::user()->name.' add multiple address in',
                ]);
                $activity->save();
                DB::commit();
                return Response::json(['success' => true, 'message' => 'Customer add multiple address.', 'data' => $customerMultiAdd], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getMultipleAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {
                $allAddress = MultipleAddress::where('user_id', $request->user_id)->get();
                DB::commit();
                return Response::json(['success' => true, 'message' => 'Address List.', 'data' => $allAddress], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updateMultipleAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'address_id' => 'required|exists:multiple_addresses,id|numeric',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'label' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {

                $getAdd = MultipleAddress::where('id',$request->address_id)->first();

                if($getAdd->label != $request->label){
                    $checkLableAdd = MultipleAddress::where('user_id', $getAdd->user_id)->where('label',$request->label)->first();
                    if($checkLableAdd){
                        return Response::json(['status' => false, 'message' => 'This lable address has already been taken.'], 404);
                    }
                }

                $getAdd->address = $request->address;
                $getAdd->latitude = $request->latitude;
                $getAdd->longitude = $request->longitude;
                $getAdd->city = $request->city;
                $getAdd->state = $request->state;
                $getAdd->country = $request->country;
                $getAdd->label = $request->label;
                $getAdd->save();

                if($request->label == "Home")
                {
                    $user = User::where('id',$getAdd->user_id)->first();
                    $user->address = $request->address;
                    $user->latitude = $request->latitude;
                    $user->longitude = $request->longitude;
                    $user->city = $request->city;
                    $user->state = $request->state;
                    $user->country = $request->country;
                    $user->label = $request->label;
                    $user->save();
                }

                $activity = AppActivity::create([
                    'action'  => 'Update Multipe Address',
                    'message' => Auth::user()->name.' update multiple address in',
                ]);
                $activity->save();
                DB::commit();
                return Response::json(['success' => true, 'message' => 'Customer update multiple address.', 'data' => $getAdd], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'phone' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return Response::json(['status' => false, 'message' => $validator->errors()->all()], 404);
            } else {

                $getUser = User::where('id',$request->user_id)->first();

                if($getUser->whatsapp_no != $request->phone){
                    $checkUserPhone = User::where('whatsapp_no', $request->phone)->where('role_type',4)->first();
                    if($checkUserPhone){
                        return Response::json(['status' => false, 'message' => 'This phone number has already been taken.'], 404);
                    }
                }

                #save image
                $image = $request->image;
                if ($image) {
                    $find = url('/storage');
                    $pathurl = str_replace($find, "", $getUser->image);

                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }

                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path, 'user');
                }else{
                    $image = $getUser->image;
                }

                $getUser->name = $request->name;
                $getUser->email = $request->email;
                $getUser->whatsapp_no = $request->phone;
                $getUser->locality = $request->locality;
                $getUser->dob = $request->dob;
                $getUser->gender = $request->gender;
                $getUser->image = $image;
                $getUser->save();

                $activity = AppActivity::create([
                    'action'  => 'Customer Profile Updated',
                    'message' => Auth::user()->name.' Customer update profile',
                ]);
                $activity->save();
                DB::commit();
                return Response::json(['success' => true, 'message' => 'Customer update profile.', 'data' => $getUser], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function deleteAddress(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'address_id' => 'required|exists:multiple_addresses,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $address = MultipleAddress::where('id', $request->address_id)->first();
                $address->destroy($address->id);
                DB::commit();
                $response = ['success' => true, 'message' => 'Address deleted successfully'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

      public function customerOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_details' => 'required|array',
                'product_details.*.id' => 'required|numeric',
                'product_details.*.product_name' => 'required|string',
                'product_details.*.qtn' => 'required|numeric',
                'product_details.*.price' => 'required|numeric',
                'product_details.*.total_amount' => 'required|numeric',

                'user_id'=>'required|exists:users,id|numeric',
                'store_id'=>'required|exists:stores,id|numeric',
                'amount'=>'required|numeric',
                'total_amount'=>'required|numeric',
                'payment_mode'=>'required|string',
                'address_id'=>'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $deliveryDetail = HomeDeliveryDetail::where('store_id',$request->store_id)->first();

                if($deliveryDetail)
                {
                    if($request->total_amount < $deliveryDetail->minimum_order_amount)
                    {
                        return Response::json(['success' => false, 'message' => 'Your total order amount is less then minimum order amount '.$deliveryDetail->minimum_order_amount.''], 404);
                    }
                }

                $orderNumber = 1;
                $order = CustomerOrder::where('user_id', $request->user_id)->orderBy('created_at','DESC')->first();
                if($order){
                    $orderNumber = $order->order_number + 1;
                }

                $uniqueId = Str::random(8) . time();

                $newOrder = new CustomerOrder();
                $newOrder->user_id = $request->user_id;
                $newOrder->store_id = $request->store_id;
                $newOrder->address_id = $request->address_id;
                $newOrder->product_details = json_encode($request->product_details);
                $newOrder->amount = $request->amount;
                $newOrder->coupan_amount = $request->coupan_amount;
                $newOrder->any_other_fee = json_encode($request->any_other_fee);
                $newOrder->tip = $request->tip;
                $newOrder->total_amount = $request->total_amount;
                $newOrder->payment_mode = $request->payment_mode;
                $newOrder->instruction = $request->instruction;
                $newOrder->order_status = 1;
                $newOrder->unique_id = $uniqueId;
                $newOrder->combined_id = $orderNumber . $uniqueId;
                $newOrder->order_number = $orderNumber;

                foreach ($request->product_details as $productDetail) {

                    $product = Product::where('id', $productDetail['id'])->first();

                    if ($product) {
                        if ((int)$product->stock > 0 && (int) $request->qtn<=(int)$product->stock) {
                            $product->stock = (int)$product->stock - (int) $productDetail['qtn'];
                            $product->save();
                        }
                    }
                }
                $newOrder->save();

                AddtoCart::where('user_id',$request->user_id)->delete();

                $activity = AppActivity::create([
                    'action'  => 'Customer Order',
                    'message' => Auth::user()->name.' Customer Created New Order',
                ]);
                $activity->save();
                DB::commit();

                $response = ['success' => true, 'message' => 'Customer Order created successfully', 'data' => $newOrder];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    //Location based data - paid user - no distruibute module userd apis
        public function customerHomeDashboard(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {

                    $customer = Auth::user();

                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);
                    $getStores =  Store::with('module')
                    ->whereHas('module', function ($query) {
                        $query->where('online', 1);
                    })
                    ->select('*')
                    ->selectRaw("{$nearestData['haversine']} AS distance")
                    ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                    ->where('package_id', '<>' , 1)
                    ->where('featured', 1)
                    ->orderBy('distance')
                    // ->orderByRaw("FIELD(featured, 1) DESC")
                    ->get();
                    foreach($getStores as $store){
                        $store->delivery_time = intval($store->distance * 4);
                    }

                    $storeIDs = $getStores->pluck('id');

                    //storecategory
                        $products = Product::whereIn('store_id',$storeIDs)->where('status', '1')->get();

                        $productCat = $products->unique('category')->pluck('category');
                        $categories = Category::with('module')
                        ->whereHas('module', function ($query) {
                            $query->where('online', 1);
                        })->whereIn('id',$productCat)->where('featured',1)->get();
                    //

                    //product offer
                        $productIDS = $products->pluck('id');
                        $offerbyProduct = TemplateOffer::whereIn('product_id',$productIDS)->get();
                    //

                    //module wise product

                        $storeModuleIDs = $getStores->unique('module_id')->pluck('module_id');
                        $moduleProduct = Module::with(['stores' => function ($query) use ($storeIDs, $nearestData) {
                            // Filter stores based on module_id present in $storeModuleIDs
                            $query->select('*')
                                    ->selectRaw("{$nearestData['haversine']} AS distance")
                                    ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])->whereIn('id', $storeIDs)
                                    ->where('package_id', '<>' , 1)
                                    ->orderByRaw("FIELD(featured, 1) DESC");
                        }])
                        ->whereIn('id', $storeModuleIDs)
                        ->where('online', 1)
                        ->where('status', 1)
                        ->get();

                        foreach($moduleProduct as $store){
                            foreach($store->stores as $storedistance){
                                // print_R($storedistance->distance); die;
                                $storedistance->delivery_time = intval($storedistance->distance * 4);
                            }
                        }
                    //

                    $response = ['success' => true, 'message' => 'Home dashboard detail', 'stores' => $getStores, 'categories' => $categories, 'offerbyProduct' => $offerbyProduct, 'moduleProduct' => $moduleProduct];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function foodStoreList(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $customer = Auth::user();

                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);
                    $getfoodStores =  Store::with('module')
                        ->whereHas('module', function ($query) {
                            $query->where('online', 1);
                        })
                        ->select('*')
                        ->selectRaw("{$nearestData['haversine']} AS distance")
                        ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                        ->where('package_id', '<>' , 1)
                        ->where('module_id', 4)
                        ->orderBy('distance')
                        ->get();

                    foreach($getfoodStores as $store){
                        $store->delivery_time = intval($store->distance * 4);
                    }
                    $response = ['success' => true, 'message' => 'Food store list', 'getfoodStores' => $getfoodStores];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getCategoryStoreList(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'category_id'=>'required|exists:categories,id|numeric',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $customer = Auth::user();

                    $categorsyProductsStoreIDs = Product::where('category',$request->category_id)->groupby('store_id')->get()->pluck('store_id');

                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);

                    $categoryStores =  Store::with('module')
                    ->whereHas('module', function ($query) {
                        $query->where('online', 1);
                    })
                    ->select('*')
                    ->selectRaw("{$nearestData['haversine']} AS distance")
                    ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                    ->whereIn('id',$categorsyProductsStoreIDs)
                    ->where('package_id', '<>' , 1)
                    ->orderBy('distance')
                    ->get();

                    foreach($categoryStores as $store){
                        $store->delivery_time = intval($store->distance * 4);
                    }
                    // print_R($categoryStores->toarray()); die;
                    DB::commit();

                    $response = ['success' => true, 'message' => 'Category Store List', 'data' => $categoryStores];
                }

                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getstoreDetail(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'user_id'=>'required|exists:users,id|numeric',
                    'store_id'=>'required|exists:stores,id|numeric',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $customer = Auth::user();
                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);

                    $store =  Store::withCount('product')->with('module')
                        // ->select('*')
                        ->whereHas('module', function ($query) {
                            $query->where('online', 1);
                        })
                        ->selectRaw("{$nearestData['haversine']} AS distance")
                        ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                        ->where('id',$request->store_id)
                        ->where('package_id', '<>' , 1)
                        ->orderBy('distance')
                        ->first();
                    if($store){
                        $store->delivery_time = intval($store->distance * 4);
                    }
                    //storecategory
                        $productsCategortIds = Product::where('store_id',$request->store_id)->where('status', '1')->groupby('category')->get()->pluck('category');

                        $categories = Category::with(['products' => function($query) use ($request) {
                            // $query->where('store_id', $request->store_id);

                            $query->where('store_id', $request->store_id)
                                  ->with(['cart' => function($query) use ($request) {
                                      $query->where('user_id', $request->user_id)
                                            ->where('store_id', $request->store_id);  // Assuming user_id identifies the user
                                  }]);
                        }])->with('module')
                        ->whereHas('module', function ($query) {
                            $query->where('online', 1);
                        })
                        ->whereIn('id', $productsCategortIds)->get();
                        // print_R($categories->toarray()); die;

                    //
                    DB::commit();

                    $response = ['success' => true, 'message' => 'Store detail', 'store' => $store, 'category' => $categories];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function searchStorebyproductandStore(Request $request)
        {

            DB::beginTransaction();
            try {
                $rules = [
                    'name'=>'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $storeIDs = Product::where('status', '1')->where('product_name', 'LIKE', '%'.$request->name.'%')->groupby('store_id')->get()->pluck('store_id');
                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);

                    if(count($storeIDs) > 0)
                    {
                        $stores =  Store::withCount('product')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->whereIn('id',$storeIDs)
                            ->where('package_id', '<>' , 1)
                            ->orderBy('distance')
                            ->get();

                    }else{
                        $stores =  Store::withCount('product')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->where('shop_name', 'LIKE', '%'.$request->name.'%')
                            ->where('package_id', '<>' , 1)
                            ->orderBy('distance')
                            ->get();
                    }

                    foreach($stores as $store)
                    {
                        $store->delivery_time = intval($store->distance * 4);
                    }

                    DB::commit();

                    $response = ['success' => true, 'message' => 'Store detail', 'store' => $stores];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function filterStore(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'filter_id'=>'required|exists:filters,id|numeric',
                    'latitude' => 'required',
                    'longitude' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $stores = [];
                    $nearestData = $this->nearestRange($request->latitude, $request->longitude);

                    if($request->filter_id == 1)
                    {
                        $radius = 1;
                        $stores =  Store::withCount('product')->with('module')
                        // ->select('*')
                        ->whereHas('module', function ($query) {
                            $query->where('online', 1);
                        })
                        ->selectRaw("{$nearestData['haversine']} AS distance")
                        ->whereRaw("{$nearestData['haversine']} < ?", [$radius])
                        ->where('package_id', '<>' , 1)
                        ->orderBy('distance')
                        ->get();
                        if(count($stores) == 0)
                        {
                            $stores =  Store::withCount('product')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->where('package_id', '<>' , 1)
                            ->orderBy('distance')
                            ->get();
                        }
                    }

                    if($request->filter_id == 2)
                    {
                        $stores =  Store::withCount('product')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->where('package_id', '<>' , 1)
                            ->where('featured', 1)
                            ->orderBy('distance')
                            ->get();
                    }

                    if($request->filter_id == 3)
                    {
                        $stores =  Store::withCount('product','customer_orders')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->where('package_id', '<>' , 1)
                            ->orderBy('customer_orders_count', 'desc')
                            ->get();
                    }

                    if($request->filter_id == 4)
                    {
                        $stores =  Store::withCount('product')->with('module')
                            // ->select('*')
                            ->whereHas('module', function ($query) {
                                $query->where('online', 1);
                            })
                            ->selectRaw("{$nearestData['haversine']} AS distance")
                            ->whereRaw("{$nearestData['haversine']} < ?", [$nearestData['radius']])
                            ->where('package_id', '<>' , 1)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->orderBy('distance')
                            ->get();
                    }

                    foreach($stores as $store)
                    {
                        $store->delivery_time = intval($store->distance * 4);
                    }
                    DB::commit();

                    $response = ['success' => true, 'message' => 'Store detail', 'store' => $stores];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //

    public function getFilters(Request $request)
    {
        try {
            $filters = Filter::all();
            $response = ['success' => true, 'message' => 'Filters List', 'data' => $filters];

            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addtocart(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id'=>'required|exists:users,id|numeric',
                'store_id'=>'required|exists:stores,id|numeric',
                'product_id'=>'required|exists:products,id|numeric',
                'product_qty' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $anotherStoreData = AddtoCart::where('user_id',$request->user_id)->where('store_id','<>',$request->store_id)->first();
                if($anotherStoreData){
                    return Response::json(['success' => false, 'message' => 'Your cart contains items from another store Do You want to discard the selection and add dishes from current store', 'store_id'=>$anotherStoreData->store_id], 404);
                }

                $product = Product::where('id',$request->product_id)->first();
                if($request->product_qty > $product->stock)
                {
                    return Response::json(['success' => false, 'message' => 'Product qty greater then product stock'], 404);
                }
                $product_amount = $product->mrp*$request->product_qty;
                if($product->retail_price){
                    $product_amount = $product->retail_price*$request->product_qty;
                }

                $addToCart = AddtoCart::where('user_id',$request->user_id)->where('store_id',$request->store_id)->where('product_id',$request->product_id)->first();

                if($request->product_qty > 0){
                    if(!$addToCart){
                        $addToCart = new AddtoCart();
                    }
                    $addToCart->user_id = $request->user_id;
                    $addToCart->store_id = $request->store_id;
                    $addToCart->product_id = $request->product_id;
                    $addToCart->product_qty = $request->product_qty;
                    $addToCart->product_amount = $product_amount;
                    $addToCart->save();

                    $activity = AppActivity::create([
                        'action'  => 'Add TO Cart',
                        'message' => Auth::user()->name.' add product to our cart',
                    ]);
                    $activity->save();
                }else{
                    if($addToCart){
                        $addToCart->destroy($addToCart->id);
                        $addToCart = null;
                    }
                }

                $storeAddtoCart = AddtoCart::where('user_id',$request->user_id)->where('store_id',$request->store_id)->get();

                $itemCount = $storeAddtoCart->count();
                $itemTotalAmount = $storeAddtoCart->sum('product_amount');
                DB::commit();

                $response = ['success' => true, 'message' => 'Product add to cart', 'data' => $addToCart, 'itemCount' => $itemCount, 'itemTotalAmount' => $itemTotalAmount];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getAddToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id'=>'required|exists:users,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $addToCart = AddtoCart::with('store','product')->where('user_id',$request->user_id)->get();

                $itemCount = AddtoCart::where('user_id',$request->user_id)->count();
                $itemTotalAmount = AddtoCart::where('user_id',$request->user_id)->sum('product_amount');
                DB::commit();

                $response = ['success' => true, 'message' => 'Add To Cart List', 'data' => $addToCart, 'itemCount' => $itemCount, 'itemTotalAmount' => $itemTotalAmount];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function deleteAddToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id'=>'required|exists:users,id|numeric',
                'store_id'=>'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $addToCart = AddtoCart::where('user_id',$request->user_id)->where('store_id',$request->store_id)->delete();
                DB::commit();

                $response = ['success' => true, 'message' => 'Cart data deleted successfully.'];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id'=>'required|exists:users,id|numeric',
                'store_id'=>'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $addToCartItems = AddtoCart::with('product')->where('user_id',$request->user_id)->where('store_id',$request->store_id)->get();

                $subTotalAmount = '0';
                $subTotalDiscountAmount = $addToCartItems->sum('product_amount');

                foreach($addToCartItems as $addToCartItem)
                {
                    $addToCartItem->subTotalAmount = $addToCartItem->product_qty*$addToCartItem->product->mrp;
                    $subTotalAmount = $subTotalAmount+$addToCartItem->product_qty*$addToCartItem->product->mrp;
                }

                $cartProductIDs = $addToCartItems->pluck('product_id');
                $suggestedProducts = Product::whereNotIn('id',$cartProductIDs)->where('store_id',$request->store_id)->get();

                $deliveryDetail = HomeDeliveryDetail::where('store_id',$request->store_id)->first();

                $areaZone = DB::table('sub_zones')->whereRaw("FIND_IN_SET($request->store_id, store_id)")->where('status',1)->first();

                $allCharges = [];
                $chargesNotIncluded = [];
                if($areaZone){
                    $allCharges = DB::table('charges')->whereRaw("FIND_IN_SET($areaZone->id, subzone_id)")->where('minimum_cart_value', '>', $subTotalDiscountAmount)->where('start_time', '<', date('H:m'))->where('end_time', '>', date('H:m'))->where('status',1)->get();

                    $chargesNotIncluded = DB::table('charges')->whereRaw("FIND_IN_SET($areaZone->id, subzone_id)")->where('minimum_cart_value', '<', $subTotalDiscountAmount)->where('start_time', '<', date('H:m'))->where('end_time', '>', date('H:m'))->where('status',1)->get();
                }

                // print_r($chargesNotIncluded->toarray()); die;

                $grandTotal = $subTotalDiscountAmount;
                if(count($allCharges) > 0)
                {
                    $grandTotal = $subTotalDiscountAmount + $allCharges->sum('amount');
                }

                $coupons = CustomerCoupan::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->get();
                foreach($coupons as $coupon)
                {
                    $coupon->valid = 0;
                    if (in_array($request->store_id, explode(',',$coupon->store_id)) && $grandTotal > $coupon->minimum_purchase) {
                        $coupon->valid = 1;
                    }
                }

                $response = ['success' => true, 'message' => 'Checkout Details', 'addToCartItems' => $addToCartItems, 'suggestedProducts' => $suggestedProducts,  'subTotalAmount' => $subTotalAmount,  'subTotalDiscountAmount' => $subTotalDiscountAmount , 'deliveryDetail' => $deliveryDetail, 'allCharges' => $allCharges , 'chargesNotIncluded' => $chargesNotIncluded , 'grandTotal' => $grandTotal, 'coupons' => $coupons];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getCustomerCoupan()
    {
        try {
            $coupans = CustomerCoupan::all();
            $response = ['success' => true, 'message' => 'Customer Coupan detail', 'Coupan' => $coupans];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function verifyCustomerCoupan(Request $request)
    {
        try {
            $rules = [
                'store_id'=>'required|exists:stores,id|numeric',
                'coupan_code' => 'required',
                'total_amount' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $coupan = CustomerCoupan::where('coupan_code',$request->coupan_code)->where('minimum_purchase', '<', $request->total_amount)->whereRaw('FIND_IN_SET('.$request->store_id.', store_id)')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

                if(!$coupan)
                {
                    return Response::json(['success' => false, 'message' => 'Coupan not valid']);
                }

                $totalDiscount = $coupan->discount;
                if($coupan->discountType =='%')
                {
                    $totalDiscount = $request->total_amount*$coupan->discount/100;
                }

                if($totalDiscount > 0){
                    if($totalDiscount > $coupan->maximum_discount_amount){
                        $totalDiscount = $coupan->maximum_discount_amount;
                    }
                }
                $coupan->totalDiscountAmount = intval($totalDiscount);
                // print_r($totalDiscount); die;

                $response = ['success' => true, 'message' => 'Customer Coupan details.', 'coupan' => $coupan,];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function orderList(Request $request)
    {
        try {
            $rules = [
                'user_id'=>'required|exists:users,id|numeric',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $orders = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->where('user_id',$request->user_id)->get();
                $response = ['success' => true, 'message' => 'Order List.', 'orders' => $orders,];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getOrderStatus()
    {
        try {
            $orderStatus = OrderStatus::all();
            $response = ['success' => true, 'message' => 'Order Status List', 'data' => $orderStatus];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    
    public function nearestRange($latitude, $longitude)
    {
        $customer = Auth::user();

        //radius wise store
            $latitude = $latitude;
            $longitude = $longitude;
            $radius = '5';

            $haversine = "(6371 * acos(cos(radians($latitude))
                            * cos(radians(latitude))
                            * cos(radians(longitude)
                            - radians($longitude))
                            + sin(radians($latitude))
                            * sin(radians(latitude))))";
        //
        $data = [
            'haversine' => $haversine,
            'radius'    => $radius,
        ];
        return $data;
    }
}
