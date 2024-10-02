<?php 

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if(!function_exists('pre'))
{
    function pre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
if(!function_exists('setFile'))
{
	function setFile($filePath, $defaultFile="")
	{
        $filePathNew = env('UPLOAD_URL') . $filePath;
        
        if(@$defaultFile) $filePathNew = $defaultFile;
        if(@$filePath && Storage::exists($filePath)) $filePathNew = Storage::url($filePath);
        
        return $filePathNew;
    }
}
if(!function_exists('setKeyAsColumn'))
{
    function setKeyAsColumn($arr, $index_key='id', $column_key=null) {
		if(@$arr) $arr = array_column($arr, $column_key, $index_key);
		return $arr;
	}
}
if(!function_exists('generate_uniq_id')) 
{
    function generate_uniq_id($length=50) {
        return Str::random($length);
    }
}
if(!function_exists('haversineGreatCircleDistance'))
{
    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
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
}
if(!function_exists('isPointInPolygon'))
{
    function isPointInPolygon($polygon, $point) {
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
}