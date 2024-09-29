<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\DeliveryPartnerEarnings;
use App\Models\DeliveryPartners;

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
                        "bottom_banner" => $bottom_banner
                    ]
                ];
            }
            return Response::json($response, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return Response::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
    public function saveLateLong(Request $request)
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
}
