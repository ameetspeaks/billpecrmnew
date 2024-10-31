<?php

namespace App\Http\Controllers;

use App\Events\DPDetailToCustomerEvent;
use App\Events\NotificationToDP;
use App\Events\OrderStatusUpdated;
use App\Helpers\LocationHelper;
use App\Models\CustomerOrder;
use App\Models\DeliveryPartnerEarnings;
use App\Models\DeliveryPartners;
use App\Models\HomeDeliveryDetail;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Zone;
use App\Services\FirebaseService;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


// Models

// Events

// Jobs

// Helpers

class CommonController extends Controller
{

    public static function generate_uuid()
    {
        $uuid = (string)Str::uuid();
        if (self::uuid_exists($uuid)) {
            return self::generate_uuid();
        }
        return $uuid;
    }

    public static function uuid_exists($uuid)
    {
        return User::where('unique_id', $uuid)->exists();
    }

    public static function saveImage($image, $path, $filename)
    {
        $path = base_path($path);

        $image_extension = $image->getClientOriginalExtension();
        $image_size = $image->getSize();
        $type = $image->getMimeType();

        $new_name = rand(1111, 9999) . date('mdYHis') . uniqid() . '.' . $image_extension;
        $thumbnail_name = 'thumbnail_' . rand(1111, 9999) . date('mdYHis') . uniqid() . '.' . $image_extension;

        $image->move("storage/app/images/$filename", $new_name);

        $userImageUrl = url("storage/app/images/$filename/" . $new_name);
        if ($userImageUrl) {
            return $userImageUrl;
        } else {
            return null;
        }
    }

    public static function sendWhatsappOtp($postdata)
    {
        // $phone = '91'.$phone;
        $url = 'https://graph.facebook.com/' . env('FACEBOOK_GRAPH_VERSION') . '/' . env('FACEBOOK_GRAPH_PHONE_ID') . '/messages';

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
                'Authorization: Bearer ' . env('WHATSAPP_CLOUD_API_TOKEN') . '',
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

        $postField = 'token=' . $token . '&client_id=' . env('OTPLessCliendID') . '&client_secret=' . env('OTPLessCliendSecret') . '';

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
        $allPermissionsLists = self::allPermissions($type);

        #get role permission ids
        if ($role_id) {
            $rolePermissions = self::getRolePermission($role_id);
            $rolePermissions = !empty($rolePermissions) ? $rolePermissions->pluck('id')->toArray() : null;
        } else {
            $rolePermissions = [];
        }

        return [
            'allPermissionsLists' => !empty($allPermissionsLists) ? $allPermissionsLists : null,
            'allGroups' => !empty($allPermissionsLists) ? array_values(array_unique($allPermissionsLists->pluck('group')->toArray())) : null,
            'rolePermissions' => $rolePermissions,
        ];
    }

    public static function cashfree_Payment($data)
    {
        $url = env('CASHFREE_URL') . '/orders';

        $headers = array(
            "Content-Type: application/json",
            "x-api-version: 2023-08-01",
            "x-client-id: " . env('CASHFREE_API_KEY'),
            "x-client-secret: " . env('CASHFREE_API_SECRET')
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
        $url = env('CASHFREE_URL') . '/orders' . '/' . $order_id . '/payments';

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
                "x-client-id: " . env('CASHFREE_API_KEY'),
                "x-client-secret: " . env('CASHFREE_API_SECRET')
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

        $encodedData = $clientId . "." . strtotime("now");

        return static::encrypt_RSA($encodedData, $publicKey);
    }

    private static function encrypt_RSA($plainData, $publicKey)
    {
        if (openssl_public_encrypt($plainData, $encrypted, $publicKey,
            OPENSSL_PKCS1_OAEP_PADDING)) {
            $encryptedData = base64_encode($encrypted);
        } else {
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
            CURLOPT_POSTFIELDS => '
            {
                "vpa": "' . $upi_id . '"
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'x-cf-signature: ' . $signature . '',
                'x-client-id: ' . env('CASHFREE_VERIFICATION_API_KEY') . '',
                'x-client-secret: ' . env('CASHFREE__VERIFICATION_API_SECRET') . ''
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
            CURLOPT_POSTFIELDS => '
            {
            "GSTIN": "' . $gstnumber . '"
            }
            ',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'x-client-id: ' . env('CASHFREE_VERIFICATION_API_KEY') . '',
                'x-client-secret: ' . env('CASHFREE__VERIFICATION_API_SECRET') . '',
                'x-cf-signature: ' . $signature . ''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    //END CF Signature

    public static function sendMsg91WhatsappOtp($phone, $otp)
    {
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
                CURLOPT_POSTFIELDS => '{
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
                                    "value": "' . $otp . '"
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

            if ($response === false) {
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
            $assignDP = ["success" => true, 'message' => 'Order Assign Successfully.'];
            if ($field_name == 'merchant_order_status') {
                switch ($order_status_id) {
                    case 2:
                        $order->order_status = 2;
                        $order->merchant_order_status = 2;

                        if ($isModeDeliveryPartner) {
                            // assign to near DP
                            $DPID = LocationHelper::assignNearestDP($order_id, $order->store->latitude, $order->store->longitude);

                            $assignDP = self::assignOrderToDeliveryBoyCommon($order_id, $DPID);
                        }

                        break;
                    case 3:
                        $order->order_status = 3;
                        $order->merchant_order_status = 3;

                        //    FireBase Integration for notification to the customer for order is processing
                        $deviceToken = $order->customer->device_token;
                        $title = 'Order is processing';
                        $body = 'Your Order #' . $order->id . ' is processing bt the merchant.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order->id
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);


                        break;
                    case 5:
                        $order->merchant_order_status = 5;

                        if ($isModeDeliveryPartner && $order->d_p_order_status != 3) {
                            return ['success' => false, 'message' => 'Unable to change status. the delivery partner has not yet reached your location.'];
                        }
                        if (empty($order->deliveryboy_id)) {
                            return ['success' => false, 'message' => 'Unable to change the status. Please assign a delivery person to this order.'];
                        }

                        //    FireBase Integration for notification to the delivery partner for order is ready to handover
                        $deviceToken = $order->delivery_boy->device_token;
                        $title = 'Ready for pickup';
                        $body = 'Your Order #' . $order->id . ' is ready for pickup.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order_id
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);

                        break;
                    case 6:
                        $order->order_status = 5;
                        $order->merchant_order_status = 6;
                        break;
                    case 7:
                        $order->order_status = 8;
                        $order->merchant_order_status = 7;
                        break;
                    case 8:
                        $order->order_status = 6;
                        $order->merchant_order_status = 8;
                        break;
                    case 9:
                        $order->order_status = 7;
                        $order->merchant_order_status = 9;
                        break;
                    default:
                        $order->merchant_order_status = $order_status_id;
                        break;
                }
            } elseif ($field_name == 'd_p_order_status') {
                switch ($order_status_id) {
                    case 2:
                        $order->d_p_order_status = 2;
                        if ($isModeDeliveryPartner) {
                            $DPDetail = User::find($order->deliveryboy_id);
                            event(new DPDetailToCustomerEvent($order, $DPDetail));
                        }
                        break;
                    case 3:
                        $order->order_status = 4;
                        $order->d_p_order_status = 3;

                        //    FireBase Integration for notification to the merchant for delivery partner has reached
                        $deviceToken = $order->store->user->device_token;
                        $title = 'Delivery Partner Reached';
                        $body = 'Delivery partner reached for Order #' . $order->id . '.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order->id,
                            'deliveryType' => 'fullfill',
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);

                        break;

                    case 4:
                        if ($isModeDeliveryPartner && $order->merchant_order_status != 5) {
                            return ['success' => false, 'message' => 'Unable to change status. The merchant is not yet ready to handover.'];
                        }
                        $order->order_status = 5;
                        $order->merchant_order_status = 6;
                        $order->d_p_order_status = 4;

                        //    FireBase Integration for notification to the customer for order is picked up
                        $deviceToken = $order->customer->device_token;
                        $title = 'Order Picked Up';
                        $body = 'Your Order #' . $order->id . ' has been picked up by the delivery partner.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order->id
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);


                        break;
                    case 5:
                        $order->order_status = 8;
                        $order->d_p_order_status = 5;

                        //    FireBase Integration for notification to the customer for order has reached drop location
                        $deviceToken = $order->customer->device_token;
                        $title = 'Your order has reached';
                        $body = 'Delivery partner for your Order #' . $order->id . ' has reached your location.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order->id
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);

                        break;
                    case 6:
                        // Delivered
                        $order->order_status = 6;
                        $order->merchant_order_status = 8;
                        $order->d_p_order_status = 6;

                        DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 0]);

                        $expected_earning = self::calculateExpectedEarning($order);
                        $dataEarn = [
                            "user_id" => $order->deliveryboy_id,
                            "order_id" => $order_id,
                            "amount" => $expected_earning,
                        ];
                        DeliveryPartnerEarnings::create($dataEarn);

                        //    FireBase Integration for notification to the merchant for order delivered
                        $deviceToken = $order->store->user->device_token;
                        $title = 'Order Delivered';
                        $body = 'Order #' . $order->id . ' has been delivered successfully.';
                        $data = [
                            'event_type' => 'order',
                            'orderData' => $order->id,
                            'deliveryType' => 'fullfill',
                        ];

                        $firebaseService = new FirebaseService();
                        $firebaseService->sendNotification($deviceToken, $title, $body, $data);

                        break;
                    case 7:
                        $order->d_p_order_status = 1;
                        DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 0]);

                        // assign to other near DP
                        $notUserId = $order->deliveryboy_id;
                        $DPID = LocationHelper::assignNearestDP($order_id, $order->store->latitude, $order->store->longitude, $notUserId);

                        $assignDP = self::assignOrderToDeliveryBoyCommon($order_id, $DPID);

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

            event(new OrderStatusUpdated($order));

            if (!$assignDP['success']) {
                $message = 'Order status updated, but no delivery partner is available. Please try assigning again later.';
            } else {
                $message = 'Order Status Updated Successfully.';
            }
            $response = [
                'success' => true,
                'message' => $message,
                "order" => $order,
                "statusLabel" => $order->orderStatus->name
            ];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage() || 'Order Status Update failed.'];
        }
        return $response;
    }

    public static function calculateExpectedEarning($order)
    {
        $drop = $order->store_to_customer_distance;
        $zones = Zone::select("per_km_rate")->find($order->store->zone_id);

        $expected_earning = $drop * ($zones->per_km_rate ?? 0);
        return $expected_earning;
    }

    public static function assignOrderToDeliveryBoyCommon($order_id, $agent_id)
    {

        try {


            $order = CustomerOrder::with(["address", "store", "delivery_boy"])->find($order_id);

            $deliveryBoyDetail = DeliveryPartners::where("user_id", $agent_id)->first();
            if (empty($deliveryBoyDetail)) {
                return ["success" => false, 'message' => 'No delivery partner available.'];
            }

            $order->deliveryboy_id = $agent_id;

            $pickup = LocationHelper::haversineGreatCircleDistance($deliveryBoyDetail->latitude, $deliveryBoyDetail->longitude, $order->store->latitude, $order->store->longitude);

            $order->dp_to_store_distance = $pickup;
            $order->save();

            DeliveryPartners::where("user_id", $order->deliveryboy_id)->update(['on_going_order' => 1]);

            $drop = $order->store_to_customer_distance;

            $homeDelivery = HomeDeliveryDetail::where('store_id', $order->store_id)->first();

            $expected_earning = self::calculateExpectedEarning($order);
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


            //    FireBase Integration for Notification to Merchant
            $deviceToken = $order->store->user->device_token;
            //        $deviceToken = 'dljxvzIVQ9q5QOB92ZaMU1:APA91bFGGZg1n_riDIs9k6HiHP_JSxf_SoVOf-kQKBY_kukVE30vYwQx-A2Tb-sEXOx27k87vb4XKA9rZER0YH94iUR6Eag0Q8Q-APmfyeqq1dhjYP9Rdtk';
            $title = 'Delivery Partner Assigned';
            $body = 'Order #' . $order->id . ' has been assigned to the delivery partner.';
            $data = [
                'event_type' => 'order',
                'orderData' => $order->id,
                'deliveryType' => 'fullfill',
            ];
            $firebaseService = new FirebaseService();
            $firebaseService->sendNotification($deviceToken, $title, $body, $data);


            //    FireBase Integration for Notification to Delivery Partner
            $deviceToken1 = $deliveryBoyDetail->user->device_token;
            //            $deviceToken1 = 'dljxvzIVQ9q5QOB92ZaMU1:APA91bFGGZg1n_riDIs9k6HiHP_JSxf_SoVOf-kQKBY_kukVE30vYwQx-A2Tb-sEXOx27k87vb4XKA9rZER0YH94iUR6Eag0Q8Q-APmfyeqq1dhjYP9Rdtk';
            $title1 = 'New Order Received';
            $body1 = 'Order #' . $order->id . ' has been assigned to you.';
            $data1 = [
                'event_type' => 'order',
                'orderData' => $order->id
            ];
            $firebaseService1 = new FirebaseService();
            $firebaseService1->sendNotification($deviceToken1, $title1, $body1, $data1);


            return ["success" => true, 'message' => 'Order Assign Successfully.', 'order' => $order];
        } catch (Exception $e) {
            return ["success" => false, 'message' => $e->getMessage() || 'Order Assign failed.'];
        }
    }
}
