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

use App\Models\Unit;
use App\Models\Attribute;
use App\Models\Module;
use App\Models\Store;
use App\Models\CustomerBanner;

use DataTables;

class CustomerBannerController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = CustomerBanner::with('module','category')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.customerbanner.index');
    }

    public function add()
    {
        $modules = Module::where('status',1)->get();
        return view('admin.customerbanner.add', compact('modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'modules_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            if($request->banner_image_link)
            {
                $customer_banner_image = $request->banner_image_link;
            }else{

                #save image
                $customer_banner_image = $request->banner_image;
                if ($customer_banner_image) {
                    $path  = config('image.profile_image_path_view');
                    $customer_banner_image = CommonController::saveImage($customer_banner_image, $path , 'customerbannerImage');
                }else{
                    $customer_banner_image = null;
                }

            }

            $banner = CustomerBanner::create([
                'module_id'   =>$request->modules_id,
                'category_id' =>$request->category_id,
                'name'        =>$request->name,
                'image'       =>$customer_banner_image,
                'status'      =>1,
            ]);
            DB::commit();
            return redirect()->route('admin.customerbanner.index')->with('message', 'Banner added successfully');
        }
    }

    public function edit($id)
    {
        $banner = CustomerBanner::where('id',$id)->first();
        $modules = Module::where('status',1)->get();
        return view('admin.customerbanner.edit', compact('banner','modules'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'modules_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $banner = CustomerBanner::where('id', $request->banner_id)->first();

            if($request->banner_image_link)
            {
                $customer_banner_image = $request->banner_image_link;
            }else{

                #save image
                $customer_banner_image = $request->banner_image;
                if ($customer_banner_image) {
                    $find = url('/storage');
                    $pathurl = str_replace($find, "", $banner->image);

                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }

                    $path  = config('image.profile_image_path_view');
                    $customer_banner_image = CommonController::saveImage($customer_banner_image, $path , 'customerbannerImage');
                }else{
                    $customer_banner_image = $banner->image;
                }
            }

            $banner->module_id = $request->modules_id;
            $banner->category_id = $request->category_id;
            $banner->name = $request->name;
            $banner->image = $customer_banner_image;
            $banner->save();

            DB::commit();
            return redirect()->route('admin.customerbanner.index')->with('message', 'Banner updated successfully');
        }
    }

    public function delete($id)
    {
        $banner = CustomerBanner::where('id',$id)->first();
        $banner->destroy($id);
        return response()->json(['status' => true,'message' => 'Banner Deleted successfully']);
    }
}
