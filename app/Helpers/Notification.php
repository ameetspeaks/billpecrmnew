<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Image;
use App\Models\Store;

class Notification
{ 
    public static function send($postdata)
    {
        try { 
            $url = "https://fcm.googleapis.com/fcm/send";
            $header = [
                'authorization: key=' .env("FirebaseNotificationKey"),
                'content-type: application/json'
            ];
                  
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
            CURLOPT_POSTFIELDS =>$postdata,
            CURLOPT_HTTPHEADER => $header,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        } catch (\ErrorException $e) {
            return null;
        }
    }
    
}
