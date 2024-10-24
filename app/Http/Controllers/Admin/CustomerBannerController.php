<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Models\CustomerBanner;
use App\Models\Module;
use App\Models\Zone;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CustomerBannerController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = CustomerBanner::with('module', 'category')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.customerbanner.index');
    }

    public function add()
    {
        $zones = Zone::get();
        $modules = Module::where('status', 1)->get();
        return view('admin.customerbanner.add', compact('modules','zones'));
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
            if ($request->banner_image_link) {
                $customer_banner_image = $request->banner_image_link;
            } else {

                #save image
                $customer_banner_image = $request->banner_image;
                if ($customer_banner_image) {
                    $path = config('image.profile_image_path_view');
                    $customer_banner_image = CommonController::saveImage($customer_banner_image, $path, 'customerbannerImage');
                } else {
                    $customer_banner_image = null;
                }

            }


            $newBanner = new CustomerBanner();
            $newBanner->module_id = $request->modules_id;
            $newBanner->category_id = $request->category_id;
            $newBanner->name = $request->name;
            $newBanner->image = $customer_banner_image;
            $newBanner->status = 1;
            $newBanner->position = $request->position;
            if ($request->zone && $request->position === "bottom") {

                $zoneIds = Zone::all()->pluck('id')->toArray();
                if (in_array('all', $request->zone)) {
                    $newBanner->zone = json_encode($zoneIds);
                } else {
                    $newBanner->zone = json_encode($request->zone);
                }

            } else {
                $newBanner->zone = null;
            }

            $newBanner->save();

            DB::commit();
            return redirect()->route('admin.customerbanner.index')->with('message', 'Banner added successfully');
        }
    }

    public function edit($id)
    {
        $zones = Zone::get();
        $banner = CustomerBanner::where('id', $id)->first();
        $modules = Module::where('status', 1)->get();
        return view('admin.customerbanner.edit', compact('banner', 'modules', 'zones'));
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

            if ($request->banner_image_link) {
                $customer_banner_image = $request->banner_image_link;
            } else {

                #save image
                $customer_banner_image = $request->banner_image;
                if ($customer_banner_image) {
                    $find = url('/storage');
                    $pathurl = str_replace($find, "", $banner->image);

                    if (File::exists('storage' . $pathurl)) {
                        File::delete('storage' . $pathurl);
                    }

                    $path = config('image.profile_image_path_view');
                    $customer_banner_image = CommonController::saveImage($customer_banner_image, $path, 'customerbannerImage');
                } else {
                    $customer_banner_image = $banner->image;
                }
            }

            $banner->module_id = $request->modules_id;
            $banner->category_id = $request->category_id;
            $banner->name = $request->name;
            $banner->image = $customer_banner_image;
            $banner->position = $request->position;
            if ($request->zone && $request->position === "bottom") {

                $zoneIds = Zone::all()->pluck('id')->toArray();
                if (in_array('all', $request->zone)) {
                    $banner->zone = json_encode($zoneIds);
                } else {
                    $banner->zone = json_encode($request->zone);
                }

            } else {
                $banner->zone = null;
            }
            $banner->save();




            DB::commit();
            return redirect()->route('admin.customerbanner.index')->with('message', 'Banner updated successfully');
        }
    }

    public function delete($id)
    {
        $banner = CustomerBanner::where('id', $id)->first();
        $banner->destroy($id);
        return response()->json(['status' => true, 'message' => 'Banner Deleted successfully']);
    }
}
