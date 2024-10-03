<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;

// Models
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\CustomerOrder;
use App\Models\OrderStatus;
use App\Models\HomeDeliveryDetail;
use App\Models\Zone;
use App\Models\DeliveryPartners;

// Events
use App\Events\OrderStatusUpdated;
use App\Events\NotificationToDP;
use App\Events\DPDetailToCustomerEvent;

// Jobs
use App\Jobs\UpdateOrderStatus;

// Helpers
use App\Helpers\LocationHelper;

class CommonController extends Controller
{

    public static function generate_uuid()
    {
        $uuid = (string) Str::uuid();
        if (self::uuid_exists($uuid)) {
            return  self::generate_uuid();
        }
        return $uuid;
    }

    public static function uuid_exists($uuid)
    {
        return User::where('unique_id', $uuid)->exists();
    }

    public static function saveImage($image, $path, $filename)
    {
        $path  =  base_path($path);

        $image_extension    = $image->getClientOriginalExtension();
        $image_size         = $image->getSize();
        $type               = $image->getMimeType();

        $new_name           = rand(1111, 9999) . date('mdYHis') . uniqid() . '.' . $image_extension;
        $thumbnail_name     = 'thumbnail_' . rand(1111, 9999) . date('mdYHis') . uniqid() . '.' .  $image_extension;

        $image->move("storage/app/images/$filename", $new_name);

        $userImageUrl = url("storage/app/images/$filename/".$new_name);
        if($userImageUrl){
            return $userImageUrl;
        }else{
            return null;
        }
    }

    public static function sendWhatsappOtp($postdata)
    {
        // $phone = '91'.$phone;
        $url = 'https://graph.facebook.com/'.env('FACEBOOK_GRAPH_VERSION').'/'.env('FACEBOOK_GRAPH_PHONE_ID').'/messages';
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $postdata,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.env('WHATSAPP_CLOUD_API_TOKEN').'',
            'Content-Type: application/json',
            'Cookie: ps_l=0; ps_n=0'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function verifyOTPLess($token)
    {
        $curl = curl_init();
        
        $postField = 'token='.$token.'&client_id='.env('OTPLessCliendID').'&client_secret='.env('OTPLessCliendSecret').'';

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://auth.otpless.app/auth/userInfo',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postField,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }


    public static function allPermissions($type = '')
    {
        $query = Permission::all();
        return $query;
    }

    public static function getRolePermission($role_id)
    {
        if (!empty($role_id)) {
            $role = Role::find($role_id);
            return $role->permissions();
        } else {
            return null;
        }
    }

    public static function showRolePermission($role_id, $type = '')
    {

        // dd($type);
        #get all permission
        $allPermissionsLists  = self::allPermissions($type);

        #get role permission ids
        if ($role_id) {
            $rolePermissions    = self::getRolePermission($role_id);
            $rolePermissions    = !empty($rolePermissions) ? $rolePermissions->pluck('id')->toArray() : null;
        } else {
            $rolePermissions = [];
        }

        return [
            'allPermissionsLists' => !empty($allPermissionsLists) ? $allPermissionsLists : null,
            'allGroups'           => !empty($allPermissionsLists) ? array_values(array_unique($allPermissionsLists->pluck('group')->toArray())) : null,
            'rolePermissions'     => $rolePermissions,
        ];
    }

    public static function cashfree_Payment($data)
    {
        $url = env('CASHFREE_URL').'/orders';
       
        $headers = array(
             "Content-Type: application/json",
             "x-api-version: 2023-08-01",
             "x-client-id: ".env('CASHFREE_API_KEY'),
             "x-client-secret: ".env('CASHFREE_API_SECRET')
        );

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    public static function cashfree_Payment_settlement($order_id)
    {
        $url = env('CASHFREE_URL').'/orders'.'/'.$order_id.'/payments';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'x-api-version: 2023-08-01',
            "x-client-id: ".env('CASHFREE_API_KEY'),
            "x-client-secret: ".env('CASHFREE_API_SECRET')
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    //CF Signature 
        public static function CFSignature()
        {
            $clientId = env('CASHFREE_VERIFICATION_API_KEY');
            $file_path = '';
            if (file_exists('/home4/billp5kj/public_html/public_key/accountId_63574_public_key.pem')) {
                $file_path = '/home4/billp5kj/public_html/public_key/accountId_63574_public_key.pem';
            }

            $key_contents = file_get_contents($file_path);
            $publicKey = openssl_pkey_get_public($key_contents);

            $encodedData = $clientId.".".strtotime("now");

            return static::encrypt_RSA($encodedData, $publicKey);
        }

        private static function encrypt_RSA($plainData, $publicKey) { if (openssl_public_encrypt($plainData, $encrypted, $publicKey,
            OPENSSL_PKCS1_OAEP_PADDING)){
                    $encryptedData = base64_encode($encrypted);
            }else{
                return NULL;
            }
            return $encryptedData;
        }

        public static function upiVerification($upi_id, $signature)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashfree.com/verification/upi/advance',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
                "vpa": "'.$upi_id.'"
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'x-cf-signature: '.$signature.'',
                'x-client-id: '.env('CASHFREE_VERIFICATION_API_KEY').'',
                'x-client-secret: '.env('CASHFREE__VERIFICATION_API_SECRET').''
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }

        public static function gstVerification($gstnumber, $signature)
        {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.cashfree.com/verification/gstin',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'
            {
            "GSTIN": "'.$gstnumber.'"
            }
            ',
            CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/json',
            'x-client-id: '.env('CASHFREE_VERIFICATION_API_KEY').'',
            'x-client-secret: '.env('CASHFREE__VERIFICATION_API_SECRET').'',
            'x-cf-signature: '.$signature.''
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }
    //END CF Signature
    
    public static function sendMsg91WhatsappOtp($phone, $otp) {
        $curl = curl_init();
        try {
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POSTFIELDS =>'{
            "integrated_number": "917290052408",
            "content_type": "template",
            "payload": {
                "messaging_product": "whatsapp",
                "type": "template",
                "template": {
                    "name": "otp",
                    "language": {
                        "code": "hi",
                        "policy": "deterministic"
                    },
                    "namespace": null,
                    "to_and_components": [
                        {
                            "to": [
                                "91' . $phone . '"
                            ],
                            "components": {
                                "body_1": {
                                    "type": "text",
                                    "value": "'. $otp . '"
                                },
                                "button_1": {
                                    "subtype": "url",
                                    "type": "text",
                                    "value": "' . $otp . '"
                                }
                            }
                        }
                    ]
                }
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'authkey: 372139AN1phFfb4wx866e73080P1',
            'X-API-Key: eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZGE0ODE0YTZiNDM2NjZlODJmZDRlMGQ0ZWI1MWYyNTk5NGNlOGU0MGVlMjM1Y2VjODI2OWM5Y2RlMzQ3NmRkZmZmYzVlZjFmNTUyMWY5NDIiLCJpYXQiOjE3MjY0ODAwNDcuNDg4ODQ2LCJuYmYiOjE3MjY0ODAwNDcuNDg4ODQ4LCJleHAiOjE3NTgwMTYwNDcuNDc4NjI3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.K35Q5iOPL75BHaGZ0bzISacUu7LpuPzxKARPjDDXpW9L7CBkElYmqtolKl6BcTVUx8vwxjHyhpQBKSaRpFvnORzVFoVjCKHOBK7EN9hXxJ8x0Ebuxdriry_secxRU9agjWkMN3dtBXfnHV8bs47rtuNXkM6mcR0RNZ1KFNM6RW4LOVW6SYPxx1pSD-uC921wcjDD_ihk0XQ_XNVzZjfr8wfQw0VYNWtOyO4aKGGmQ8qZYp9R8yMWAnuhM-iG8CFwIvGigmakkHeGsPZNhIWoVUSFGdx8PaDkG2bRCpVS76UJVhFUJFQGMwYrVJOBBanqSyGyMmpVcyqo6fd9u1XFBm_TBUPApEd2l1qLFDnia4Fz8a8kDaKlhmFLVKqcBqzAPivI_CrFZd6XkOa0GQkMTsQKxEEGFmYJXTIWbClsqTsTEnBrQgjOnKChVlSgYk_teHjmlitgOSaHr8-NcgJV0NeEWEyxeR71MvnU6MNQiZJKOQvLfIl2q-SmQ1nR9ValrDMJf0yEVe_sN2WbiLtnqYWl6_lDSe0Nd8iEQCko_h8qfiB1i0L0_BfbgmeBAjrWF59vLULmeR1uwaX9tR4aku_crBOtMZ51_vz8FaZB0yiraLGJPvMSFbelDvh6BtYMvAPMl8IxZJYi77PlVuL4E_szeIuJ4igtHsI62FuEGmA',
            'Cookie: PHPSESSID=rkkcl4b8cohplt8drimc4t0q25'
        ),
        ));

        $response = curl_exec($curl);
        
        if($response === false)
        {
            return 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);
        
        return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
    public static function orderStatusChangeCommon($order_id, $order_status_id, $field_name)
    {
        try {
            $order = CustomerOrder::with("store")->find($order_id);
            $homeDelivery = HomeDeliveryDetail::where('store_id', $order->store_id)->first();
            
            $isModeDeliveryPartner = $homeDelivery->delivery_mode == 0;
            
            // Update the order status
            if($field_name == 'merchant_order_status'){
                switch ($order_status_id) {
                    case 2:
                        $order->order_status = 2;
                        $order->merchant_order_status = 2;

                        if($isModeDeliveryPartner){
                            // assign to near DP
                            $DPID = LocationHelper::assignNearestDP($order_id, $order->store->latitude, $order->store->longitude);
    
                            self::assignOrderToDeliveryBoyCommon($order_id, $DPID);
                        }
                        
                        break;
                    case 3:
                        $order->order_status = 3;
                        $order->merchant_order_status = 3;
                        break;
                    case 5:
                        $order->merchant_order_status = 5;

                        if($isModeDeliveryPartner && $order->d_p_order_status != 3){
                            return ['success' => false, 'message' => 'Unable to change status. the delivery partner has not yet reached your location.'];
                        }

                        break;
                    case 6:
                        $order->order_status = 5;
                        $order->merchant_order_status = 6;
                        break;
                    case 7:
                        $order->order_status = 6;
                        $order->merchant_order_status = 7;
                        break;
                    case 8:
                        $order->order_status = 7;
                        $order->merchant_order_status = 8;
                        break;
                    case 9:
                        $order->order_status = 8;
                        $order->merchant_order_status = 9;
                        break;
                    default:
                        $order->merchant_order_status = $order_status_id;
                        break;
                }
            } elseif($field_name == 'd_p_order_status') {
                switch ($order_status_id) {
                    case 2:
                        $order->d_p_order_status = 2;
                        if($isModeDeliveryPartner){
                            $DPDetail = User::find($order->deliveryboy_id);
                            event(new DPDetailToCustomerEvent($order, $DPDetail));
                        }
                        break;
                    case 4:
                        if($isModeDeliveryPartner && $order->merchant_order_status != 5){
                            return ['success' => false, 'message' => 'Unable to change status. The merchant is not yet ready to handover.'];
                        }
                        $order->order_status = 5;
                        $order->merchant_order_status = 6;
                        $order->d_p_order_status = 4;
                        break;
                    case 5:
                        $order->order_status = 8;
                        $order->d_p_order_status = 5;
                        break;
                    case 6:
                        $order->order_status = 6;
                        $order->merchant_order_status = 7;
                        $order->d_p_order_status = 6;

                        DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 0]);

                        break;
                    case 7:
                        $order->d_p_order_status = 1;
                        DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 0]);
                        
                        // assign to other near DP
                        $notUserId = $order->deliveryboy_id;
                        $DPID = LocationHelper::assignNearestDP($order_id, $order->store->latitude, $order->store->longitude, $notUserId);

                        self::assignOrderToDeliveryBoyCommon($order_id, $DPID);

                        break;
                    default:
                        $order->d_p_order_status = $order_status_id;
                        break;
                }
            } else {
                switch ($order_status_id) {
                    case 1:
                        $order->order_status = 1;
                        $order->merchant_order_status = 1;
                        $order->d_p_order_status = 1;
                        break;
                    default:
                        $order->order_status = $order_status_id;
                        break;
                }
            }
            $order->save();

            $order = CustomerOrder::with(["orderStatus", "merchantOrderStatus", "DPOrderStatus"])->find($order_id);

            //if status id 3 and delivery_mode = 0 (delivery partner) than run below code
            // if($order_status_id == 3){
            //     $homeDelivery = HomeDeliveryDetail::where('store_id',$order->store_id)->where('delivery_mode', 0)->first();
            //     if(@$homeDelivery){
                    // UpdateOrderStatus::dispatch($order)->delay(now()->addMinutes(1));
            //     }
            // }

            event(new OrderStatusUpdated($order));
            
            $response = [
                'success' => true,
                'message' => 'Order Status Update Successfully.',
                "order" => $order,
                "statusLabel" => $order->orderStatus->name
            ];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage() || 'Order Status Update failed.'];
        }
        return $response;
    }
    public static function assignOrderToDeliveryBoyCommon($order_id, $agent_id)
    {
        $order = CustomerOrder::with(["address", "store"])->find($order_id);
        
        $deliveryBoyDetail = User::find($agent_id);

        $order->deliveryboy_id = $agent_id;
        
        $pickup = LocationHelper::haversineGreatCircleDistance($deliveryBoyDetail->latitude, $deliveryBoyDetail->longitude, $order->store->latitude, $order->store->longitude);
        
        $order->dp_to_store_distance = $pickup;
        $order->save();

        DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 1]);

        $drop = LocationHelper::haversineGreatCircleDistance($order->store->latitude, $order->store->longitude, $order->address->latitude, $order->address->longitude);

        $zones = Zone::find($order->store->zone_id);
        $homeDelivery = HomeDeliveryDetail::where('store_id',$order->store_id)->first();

        $expected_earning = $drop * ($zones->per_km_rate ?? 0);
        $countdown = $homeDelivery->processing_time ?? 0;
        
        $newOrderData = [
            "expected_earning" => $expected_earning,
            "pickup" => $pickup,
            "drop" => $drop,
            "countdown" => 30,
            "order_id" => $order_id,
            "deliveryboy_id" => $agent_id,
        ];

        event(new NotificationToDP($newOrderData)); // send popup notification to delivery partner

        $response = ["success" => true, 'message' => 'Order Assign Successfully.'];
        
        return $response;
    }
}
