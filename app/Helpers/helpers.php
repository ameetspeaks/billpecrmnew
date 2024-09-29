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