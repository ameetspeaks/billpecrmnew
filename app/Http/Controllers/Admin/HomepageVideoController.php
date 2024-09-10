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
use App\Models\HomepageVideo;

use DataTables;

class HomepageVideoController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = HomepageVideo::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.homepagevideo.index');
    }

    public function add()
    {
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.homepagevideo.add', compact('stores','modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'package_type' => 'required',
            'module_condition' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            
            if($request->homepage_video_image_link)
            {
                $homepage_video_image = $request->homepage_video_image_link;
            }else{
                #save image
                $homepage_video_image = $request->homepage_video_image;
                if ($homepage_video_image) {
                    $path  = config('image.profile_image_path_view');
                    $homepage_video_image = CommonController::saveImage($homepage_video_image, $path , 'homepageVideo');
                }else{
                    $homepage_video_image = null;
                }
            }

            $homepageVideo = HomepageVideo::create([
                'module_id'            => implode(',',$request->modules_id),
                'package_type'         => $request->package_type,
                'module_condition'     => $request->module_condition,
                'homepage_video_image' => $homepage_video_image,
                'status'               => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.homepagevideo.index')->with('message', 'Homepage Video added successfully');
        }
    }

    public function edit($id)
    {
        $homepageVideo = HomepageVideo::where('id',$id)->first();
        $stores = Store::all();
        $modules = Module::where('status',1)->get();
        return view('admin.homepagevideo.edit', compact('stores','modules','homepageVideo'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'modules_id' => 'required',
            'package_type' => 'required',
            'module_condition' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $hoempageVideo = HomepageVideo::where('id', $request->homepage_video_id)->first();

            if($request->homepage_video_image_link)
            {
                $homepage_video_image = $request->homepage_video_image_link;
            }else{

                #save image
                $homepage_video_image = $request->homepage_video_image;
                if ($homepage_video_image) {
                    $find = url('/storage');
                    $pathurl = str_replace($find, "", $hoempageVideo->homepage_video_image);

                    if(File::exists('storage'.$pathurl))
                    {
                        File::delete('storage'.$pathurl);
                    }

                    $path  = config('image.profile_image_path_view');
                    $homepage_video_image = CommonController::saveImage($homepage_video_image, $path , 'homepageVideo');
                }else{
                    $homepage_video_image = $hoempageVideo->homepage_video_image;
                }
            
            }

            $hoempageVideo->module_id = implode(',',$request->modules_id);
            $hoempageVideo->package_type = $request->package_type;
            $hoempageVideo->module_condition = $request->module_condition;
            $hoempageVideo->homepage_video_image = $homepage_video_image;
            $hoempageVideo->save();

            DB::commit();
            return redirect()->route('admin.homepagevideo.index')->with('message', 'Homepage Video updated successfully');
        }
    }

    public function delete($id)
    {
        $homepageVideo = HomepageVideo::where('id',$id)->first();
        $homepageVideo->destroy($id);
        return response()->json(['status' => true,'message' => 'Homepage Video Deleted.']);
    }
}
