<?php

namespace App\Http\Controllers\Admin;

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

use DataTables;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('admin.subscription.index');
    }

    public function add()
    {
        return view('admin.subscription.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'package_price' => 'required',
            'validity' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            #save image
            $image = $request->subscriptionImage;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $subscriptipnImage = CommonController::saveImage($image, $path , 'subscription');
            }else{
                $subscriptipnImage = null;
            }

            #save image
            $imageLogo = $request->coupan_logo;
            if ($imageLogo) {
                $path  = config('image.profile_image_path_view');
                $imageLogo = CommonController::saveImage($imageLogo, $path , 'subscriptionCoupanLogo');
            }else{
                $imageLogo = null;
            }

            $package = SubscriptionPackage::create([
                'name'               => $request->name,
                'discription'        => $request->discription,
                'subscription_price' => $request->package_price,
                'discount_price'     => $request->discount_price,
                'validity_days'      => $request->validity,
                'image'              => $subscriptipnImage,
                'benefits'           => json_encode(explode(',', $request->benefits)),
                'termsandcondition'  => $request->term_condition,
                'offer'              => $request->offer,
                'coupan_no'          => $request->extra_brand_coupan,
                'coupan_title'       => $request->coupan_title,
                'coupan_logo'        => $imageLogo,
                'status'             => '1',  
            ]);
            DB::commit();
            return redirect()->route('admin.subscription.index')->with('message', 'Subscription added successfully');
        }
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::where('id',$id)->first();
        if($package->benefits){
            $package->benefitshow = implode(',',json_decode($package->benefits));
        }
        return view('admin.subscription.edit', \compact('package'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'package_price' => 'required',
            'validity' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $package = SubscriptionPackage::where('id', $request->packageID)->first();
            #save image
            $image = $request->subscriptionImage;
            if ($image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $package->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $subscriptipnImage = CommonController::saveImage($image, $path , 'subscription');
            }else{
                $subscriptipnImage = $package->image;
            }

            #save image
            $imageLogo = $request->coupan_logo;
            if ($imageLogo) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $package->coupan_logo);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $imageLogo = CommonController::saveImage($imageLogo, $path , 'subscriptionCoupanLogo');
            }else{
                $imageLogo = $package->image;
            }

            $package->name               = $request->name;
            $package->discription        = $request->discription;
            $package->subscription_price = $request->package_price;
            $package->discount_price     = $request->discount_price;
            $package->validity_days      = $request->validity;
            $package->image              = $subscriptipnImage;
            $package->benefits           = json_encode(explode(',', $request->benefits));
            $package->termsandcondition  = $request->term_condition;
            $package->offer              = $request->offer;
            $package->coupan_no          = $request->extra_brand_coupan;
            $package->coupan_title       = $request->coupan_title;
            $package->coupan_logo        = $imageLogo;
            $package->save();

            DB::commit();
            return redirect()->route('admin.subscription.index')->with('message', 'Subscription updated successfully');
        }
    }

    public function delete($id)
    {
        $package = SubscriptionPackage::where('id',$id)->first();
        $package->destroy($id);
        return response()->json(['status' => true,'message' => 'package Deleted successfully']);
    }
    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = SubscriptionPackage::get();
            // foreach($data as $datas){
            //     if($datas->subscription_price > 0){
            //         $datas->subscription_price = (int)$datas->subscription_price + (int)$datas->subscription_price*18/100;
            //         $datas->subscription_price = number_format($datas->subscription_price, 2);
            //     }
            // }
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.subscription.index');
    }
}
