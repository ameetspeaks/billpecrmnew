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
use App\Models\PromotionalBanner;

use DataTables;

class PromotionalBannerController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = PromotionalBanner::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.promotionBanner.index');
    }

    public function add()
    {
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.promotionBanner.add', compact('stores','modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'package_type' => 'required',
            'redirect_to' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            if($request->banner_image_link)
            {
                $banner_image = $request->banner_image_link;
            }else{

                #save image
                $banner_image = $request->banner_image;
                if ($banner_image) {
                    $path  = config('image.profile_image_path_view');
                    $banner_image = CommonController::saveImage($banner_image, $path , 'promotionalBanner');
                }else{
                    $banner_image = null;
                }
            
            }

            $banner = PromotionalBanner::create([
                'module_id'       => implode(',',$request->modules_id),
                'package_type'    => $request->package_type,
                'redirect_to'     => $request->redirect_to,
                'banner_image'    => $banner_image,
                'status'          => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.promotionalBanner.index')->with('message', 'Promotional Banner added successfully');
        }
    }

    public function edit($id)
    {
        $banner = PromotionalBanner::where('id',$id)->first();
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.promotionBanner.edit', compact('stores','modules','banner'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'package_type' => 'required',
            'redirect_to' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $banner = PromotionalBanner::where('id', $request->promotion_banner_id)->first();

            if($request->banner_image_link)
            {
                $banner_image = $request->banner_image_link;
            }else{

                #save image
                $banner_image = $request->banner_image;
                if ($banner_image) {
                    $find = url('/storage');
                    $pathurl = str_replace($find, "", $banner->banner_image);

                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }

                    $path  = config('image.profile_image_path_view');
                    $banner_image = CommonController::saveImage($banner_image, $path , 'promotionalBanner');
                }else{
                    $banner_image = $banner->banner_image;
                }
            }

            $banner->module_id = implode(',',$request->modules_id);
            $banner->package_type = $request->package_type;
            $banner->redirect_to = $request->redirect_to;
            $banner->banner_image = $banner_image;
            $banner->save();

            DB::commit();
            return redirect()->route('admin.promotionalBanner.index')->with('message', 'Promotional Banner updated successfully');
        }
    }

    public function delete($id)
    {
        $banner = PromotionalBanner::where('id',$id)->first();
        $banner->destroy($id);
        return response()->json(['status' => true,'message' => 'Promotional Banner Deleted successfully']);
    }
}
