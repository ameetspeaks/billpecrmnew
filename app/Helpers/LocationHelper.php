<?php

namespace App\Helpers;

use App\Models\DeliveryPartners;

class LocationHelper
{
    public static function isPointInPolygon($polygon, $point) {
        $c = false;
        $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            if ((($polygon[$i]['lng'] > $point['lng']) != ($polygon[$j]['lng'] > $point['lng'])) &&
                ($point['lat'] < ($polygon[$j]['lat'] - $polygon[$i]['lat']) * ($point['lng'] - $polygon[$i]['lng']) / ($polygon[$j]['lng'] - $polygon[$i]['lng']) + $polygon[$i]['lat'])) {
                $c = !$c;
            }
        }
        return $c;
    }
    public static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // if value null or undefined not available
        if ($latitudeFrom == null || $longitudeFrom == null || $latitudeTo == null || $longitudeTo == null) return 0.00;

        // Convert degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
        
        // Calculate the differences between latitudes and longitudes
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        // Haversine formula
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
        cos($latFrom) * cos($latTo) *
        sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // Multiply by Earth's radius to get distance in kilometers
        $distance = $earthRadius * $c;
        
        return round($distance, 2); // distance in kilometers
    }
    public static function assignNearestDP($order_id, $latitude, $longitude, $notUserId=0, $radius = 5)
    {
        $data = DeliveryPartners::selectRaw("*,
            ( 6371 * acos( cos( radians(".$latitude.") ) 
                * cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(".$longitude.") )
                + sin( radians(".$latitude.") ) *
                sin( radians( latitude ) ) ) ) AS distance")
            ->where("current_work_status", 1)
            ->where("on_going_order", 0)
            ->where("user_id", "!=", $notUserId)
            // ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->first();
        return $data->user_id ?? 0;
    }
}
