<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Models
// use App\Models\CustomerOrder;

use Response;
// use Carbon\Carbon;

class ApiMerchantController extends Controller
{
    public function getAuthUser()
    {
        $user = Auth::user();
        return $user;
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
                $updateStatus = CommonController::orderStatusChangeCommon($request->order_id, $request->order_status_id, "merchant_order_status");
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
