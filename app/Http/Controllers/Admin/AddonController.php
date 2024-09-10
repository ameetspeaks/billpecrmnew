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
use App\Models\Addon;


use DataTables;

class AddonController extends Controller
{
    public function index()
    {
        return view('admin.addon.index');
    }

    public function add()
    {
        return view('admin.addon.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            #save image
            $image = $request->image;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $addonImage = CommonController::saveImage($image, $path , 'addon');
            }else{
                $addonImage = null;
            }

            $package = Addon::create([
                'name'                    => $request->name,
                'discription'             => $request->discription,
                'price'                   => $request->price,
                'validity_days'           => $request->validity,
                'image'                   => $addonImage,
                'status'                  => '1',  
            ]);
            DB::commit();
            return redirect()->route('admin.addon.index')->with('message', 'Addon added successfully');
        }
    }

    public function edit($id)
    {
        $addon = Addon::where('id',$id)->first();
        return view('admin.addon.edit', \compact('addon'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $addon = Addon::where('id', $request->addon_id)->first();
           
            #save image
            $image = $request->image;
            if ($image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $addon->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $addonImage = CommonController::saveImage($image, $path , 'addon');
            }else{
                $addonImage = $addon->image;
            }

            $addon->name               = $request->name;
            $addon->discription        = $request->discription;
            $addon->price              = $request->price;
            $addon->image              = $addonImage;
            $addon->save();

            DB::commit();
            return redirect()->route('admin.addon.index')->with('message', 'Addon updated successfully');
        }
    }

    public function delete($id)
    {
        $addon = Addon::where('id',$id)->first();
        $addon->destroy($id);
        return response()->json(['status' => true,'message' => 'Addon Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Addon::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.subscription.index');
    }
}
