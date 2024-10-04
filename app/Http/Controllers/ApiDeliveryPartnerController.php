<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\DeliveryPartnerEarnings;
use App\Models\DeliveryPartners;
use App\Models\CustomerOrder;

use Response;
use Carbon\Carbon;

class ApiDeliveryPartnerController extends Controller
{
    public function getAuthUser()
    {
        $user = Auth::user();
        return $user;
    }
    public function getHomePageDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                // 'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();

                $deliveryPartners = DeliveryPartners::select('current_work_status','account_status')
                    ->with("shift_detail")
                    ->where('user_id', $user->id)
                    ->first();

                $todayEarnings = DeliveryPartnerEarnings::whereDate('created_at', Carbon::today())->sum('amount');
                DB::commit();

                $show_bottom_banner = true;
                if($show_bottom_banner) {
                    $bottom_banner = 'https://billpeapp.com/storage/app/images/delivery_partner/dp-bottom-banner.png';
                } else {
                    $bottom_banner = null;
                }

                $response = [
                    'success' => true,
                    'message' => 'Home Detail',
                    'data' => [
                        "todayEarnings" => $todayEarnings,
                        "show_bottom_banner" => $show_bottom_banner,
                        "bottom_banner" => $bottom_banner,
                        "user" => $user,
                        "delivery_boy_detail" => $deliveryPartners,
                    ]
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function getProfileDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                // 'store_id' => 'required|exists:stores,id|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();

                $deliveryPartners = DeliveryPartners::with(["shift_detail", "delivery_boy_detail"])
                    ->where('user_id', $user->id)
                    ->first();

                DB::commit();

                $response = [
                    'success' => true,
                    'message' => 'User Profile Detail',
                    'data' => $deliveryPartners
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function saveLatLong(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();

                $deliveryPartners = DeliveryPartners::where('user_id', $user->id)->first();
                $deliveryPartners->latitude = $request->latitude;
                $deliveryPartners->longitude = $request->longitude;
                $deliveryPartners->save();

                DB::commit();

                $response = [
                    'success' => true,
                    'message' => 'Lat-Long saved Successfully.' ,
                    'data' => [
                        "deliveryPartners" => $deliveryPartners,
                    ]
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function orderConfirmCancel(Request $request)
    {
        $response = ['success' => false, 'message' => 'This API Removed.'];
        return Response::json($response, 200);
    }
    public function currentOrderDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'order_id' => 'required|numeric|exists:customer_orders,id',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();
                
                $orderDetail = CustomerOrder::with("customer", "address", "store")->where('id', $request->order_id)
                ->where('deliveryboy_id', $user->id)
                ->first();

                DB::commit();

                $response = [
                    'success' => true,
                    'message' => "Current Order Detail...",
                    'data' => [
                        "orderDetail" => $orderDetail,
                    ]
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function saveProfileDetail(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'bank_name' => 'required|string',
                'account_holder_name' => 'required|string',
                'account_number' => 'required|numeric',
                'ifsc' => 'required|string',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();

                $conditions = [
                    "user_id" => $user->id,
                ];
                $data = [
                    'bank_name' => $request->bank_name,
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'ifsc' => $request->ifsc,
                ];
                $save = DeliveryPartners::updateOrCreate($conditions, $data);

                DB::commit();

                $user['delivery_boy_detail'] = $save;
                
                $response = ['success' => true, 'message' => 'Bank Detail Saved Successfully.', 'user' => $user];
            }

            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function orderDetailByDate(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'date' => 'required|date_format:Y-m-d',
            ];

            $messages = [
                'date.date_format' => 'The date must be in the format Y-m-d (e.g., '.date('Y-m-d').').',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules, $messages);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $user = $this->getAuthUser();
                
                $orderDetail = CustomerOrder::with(["customer", "address", "store"])
                ->where('deliveryboy_id', $user->id)
                ->whereDate('created_at', Carbon::parse($request->date))
                ->get();

                DB::commit();

                $response = [
                    'success' => true,
                    'message' => "Order Detail...",
                    'data' => [
                        "orderDetail" => $orderDetail,
                    ]
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function orderStatusChange(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required|numeric',
                'order_status_id' => 'required|numeric',
            ];

            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                $response = ['success' => false, 'message' => $validator->errors()->all()];
            } else {
                $updateStatus = CommonController::orderStatusChangeCommon($request->order_id, $request->order_status_id, "d_p_order_status");
                if ($updateStatus['success']) {
                    $response = ['success' => true, 'message' => 'Order Status Update Successfully.'];
                } else {
                    $response = $updateStatus;
                }
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
