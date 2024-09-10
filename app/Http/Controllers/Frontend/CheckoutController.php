<?php

namespace App\Http\Controllers\Frontend;

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
use App\Models\Addon;
use Session;
use Auth;
use App\Models\Store;
use App\Models\Coupan;
use App\Models\PackageOrder;
use App\Models\PackageTransection;

use Illuminate\Support\Str; 


class CheckoutController extends Controller
{
    public function checkout()
    {
        if(Auth::user()){
            if(Session::get('selectpackage')){
                $store = Store::with('user')->where('id',Session::get('store_id'))->first();
                $package = SubscriptionPackage::where('id',Session::get('selectpackage'))->first();
                // print_r($package->toarray()); die;
                return view('billpeapp.checkout', compact('store','package'));
            }
            return redirect('store/dashboard');
        }
        return redirect('store/login');
    }

    public function getCoupanByCode(Request $request)
    {
        $coupan  = Coupan::where('code',$request->coupanCode)->whereRaw('FIND_IN_SET('.Session::get('store_id').', store_id)')->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();

        if($coupan){
            return response()->json(['success' => true , 'coupan' => $coupan]);
        }
        return response()->json(['success' => false , 'message' => 'Coupan Code is not valid.']);
    }

    // public function checkoutOrder(Request $request)
    // {
        // print_r($request->all()); die;
        // DB::beginTransaction();
        // try {
        //     $rules = [
        //         'shipping_address'=>'required',
        //         'TotalAmount'=>'required',
        //     ];
             
        //     $requestData = $request->all();
        //     $validator = Validator::make($requestData, $rules);

        //     if ($validator->fails()) {
        //         return redirect()->back()->with('error', $validator->errors()->first());
        //     } else {
        //         $orderCount = OrderDetail::where('store_id', Session::get('store_id'))->count();
        //         $uniqueId = Str::random(8) . time();

        //         $newOrderGenerate = new OrderDetail();
        //         $newOrderGenerate->store_id = Session::get('store_id');
        //         $newOrderGenerate->product_details = json_encode($request->product);
        //         $newOrderGenerate->shipping_name = $request->shipping_name;
        //         $newOrderGenerate->shipping_address = $request->shipping_address;
        //         $newOrderGenerate->shipping_latitude = $request->shipping_latitude;
        //         $newOrderGenerate->shipping_longitude	 = $request->shipping_longitude;
        //         $newOrderGenerate->shipping_city = $request->shipping_city;
        //         $newOrderGenerate->shipping_code = $request->shipping_code;
        //         $newOrderGenerate->shipping_state = $request->shipping_state;
        //         $newOrderGenerate->copanCode = $request->copanCode;
        //         $newOrderGenerate->coupanAmount = $request->coupanAmount;
        //         $newOrderGenerate->TotalAmount = $request->TotalAmount;
        //         $newOrderGenerate->order_comment = $request->order_comment;
        //         $newOrderGenerate->unique_id = $uniqueId;
        //         $newOrderGenerate->combined_id = $orderCount + 1 . $uniqueId;
        //         $newOrderGenerate->order_number = $orderCount + 1;
        //         $newOrderGenerate->save();

        //         DB::commit();
        //         return redirect()->back()->with('message', 'Order added successfully');
        //     }

        //     return Response::json($response, 200);
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        // }
    // }

    public function checkoutOrder(Request $request)
    {
        try{
            $rules = [
                'shipping_name'=>'required',
                'shipping_address'=>'required',
                'shipping_city'=>'required',
                'shipping_code'=>'required',
                'shipping_state'=>'required',
                'TotalAmount'=>'required',
            ];
                
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            } else {
                
                $store = Store::with('user')->where('id',Session::get('store_id'))->first();
                
                Session::put('checkoutData', $request->all());
                $data = json_encode([
                    'order_id'     => 'order_'.rand(1111111111,9999999999),
                    'order_amount' =>  $request->TotalAmount,
                    "order_currency" => "INR",
                    "customer_details" => [
                        "customer_id" => 'customer_'.rand(111111111,999999999),
                        "customer_name" => $store->user->name,
                        "customer_email" => $store->user->email,
                        "customer_phone" => $store->user->whatsapp_no,
                ],
                    "order_meta" => [
                        "return_url" => url('cashfree/payments/success/?order_id={order_id}'),
                    ]
                ]);
                $cashfree_Payment = CommonController::cashfree_Payment($data);
                $cashfree_Payment = json_decode($cashfree_Payment);
                return view('billpeapp.cashfreeapp', compact('cashfree_Payment'));
                // return redirect()->to(json_decode($cashfree_Payment)->payment_link);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage()->first());
        }
    }


    public function success(Request $request)
    {
        $cashfree_Payment_settlement = CommonController::cashfree_Payment_settlement($request->order_id);
        $cashfree_Payment_settlement = json_decode($cashfree_Payment_settlement);
        
        foreach($cashfree_Payment_settlement as $cashfree_Payment)
        {
            if($cashfree_Payment->payment_status == 'SUCCESS')
            {
                if(Session::get('checkoutData')){
                    $orderCount = PackageOrder::count();
                    $uniqueId = Str::random(8) . time();
                    $checkoutData = Session::get('checkoutData');
                
                    $newOrderGenerate = new PackageOrder();
                    $newOrderGenerate->store_id = Session::get('store_id');
                    $newOrderGenerate->product_details = json_encode($checkoutData['product']);
                    $newOrderGenerate->shipping_name = $checkoutData['shipping_name'];
                    $newOrderGenerate->shipping_address = $checkoutData['shipping_address'];
                    $newOrderGenerate->shipping_city = $checkoutData['shipping_city'];
                    $newOrderGenerate->shipping_code = $checkoutData['shipping_code'];
                    $newOrderGenerate->shipping_state = $checkoutData['shipping_state'];
                    $newOrderGenerate->copanCode = $checkoutData['copanCode'];
                    $newOrderGenerate->coupanAmount = $checkoutData['coupanAmount'];
                    $newOrderGenerate->TotalAmount = $checkoutData['TotalAmount'];
                    $newOrderGenerate->order_comment = $checkoutData['order_comment'];
                    $newOrderGenerate->unique_id = $uniqueId;
                    $newOrderGenerate->combined_id = $orderCount + 1 . $uniqueId;
                    $newOrderGenerate->order_number = $orderCount + 1;
                    $newOrderGenerate->save();
                }


                $newTransection = new PackageTransection();
                $newTransection->productOrder_id          = $newOrderGenerate->id;
                $newTransection->store_id                 = Session::get('store_id');
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


                $package = SubscriptionPackage::where('id',$checkoutData['package_id'])->first();
                $validdate = date('Y-m-d',strtotime(''.$package->validity_days.' days'));
                // print_r($validdate); die; 
                $store = Store::where('id',Session::get('store_id'))->first();
                $store->package_id = $package->id;
                $store->package_active_date = date('Y-m-d');
                $store->package_valid_date = $validdate;
                $store->package_amount = $package->subscription_price;
                $store->package_status = $package->status;
                $store->save();

                $invoiceUrl = url('subscriptionInvoice/'.$newOrderGenerate->combined_id);

                Store::where('id',Session::get('store_id'))->update(['gst' => $checkoutData['billing_gst']]);

                Session::forget('checkoutData');
                Session::forget('selectpackage');
                return redirect()->to($invoiceUrl);
            }
        }
        return redirect()->route('checkout-1');
    }

    public function subscriptionExpire()
    {
        $store = Store::where('id',Session::get('store_id'))->first();
        $storePackage = SubscriptionPackage::where('id',$store->package_id)->first();

        return view('billpeapp.subscriptionExpire', compact('storePackage'));
    }
}
