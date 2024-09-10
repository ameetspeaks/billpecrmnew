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
use App\Imports\ImportCentralLibrary;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CentralLibrary;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\Module;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Store;
use App\Models\Coupan;
use App\Models\CustomerCoupan;
use App\Models\Zone;
use App\Models\SubZone;

class CustomerCoupanController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = CustomerCoupan::all();
            // print_r($data->toarray()); die;
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.customerCoupan.index');
    }

    public function add()
    {
        $modules = Module::where('status', 1)->get();
        $zones = Zone::where('status', 1)->get();
        return view('admin.customerCoupan.add' , compact('modules','zones'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'title' => 'required',
            'sub_heading' => 'required',
            'discount' => 'required',
            'discountType' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $zones = explode(',',$request->zone_id);
            if ($request->zone_id == 'all') {
                $zones = DB::table('zones')->where('status',1)->get()->pluck('id')->toarray();
            }

            $subzones = explode(',',$request->subzone_id);
            if ($request->subzone_id == 'all') {
                if ($request->zone_id == 'all') {
                    $subzones = DB::table('sub_zones')->where('status',1)->get()->pluck('id')->toarray();
                }else{
                    $subzones = DB::table('sub_zones')->where('zone_id',$request->zone_id)->where('status',1)->get()->pluck('id')->toarray();
                }
            }

            $modules = explode(',',$request->module_id);
            if ($request->module_id == 'all') {
                $modules = DB::table('modules')->where('status',1)->get()->pluck('id')->toarray();
            }

            $category = explode(',',$request->category_id);
            if ($request->category_id == 'all') {
                if ($request->module_id == 'all') {
                    $category = DB::table('categories')->where('status',1)->get()->pluck('id')->toarray();
                }else{
                    $category = DB::table('categories')->where('module_id',$request->module_id)->where('status',1)->get()->pluck('id')->toarray();
                }
            }

            $stores = explode(',',$request->store_id);
            if ($request->store_id == 'all') {
                if ($request->module_id == 'all') {
                    $stores = DB::table('stores')->get()->pluck('id')->toarray();
                }else{
                    $stores = DB::table('stores')->where('module_id',$request->module_id)->get()->pluck('id')->toarray();
                }
            }

            #save image
            $image = $request->image;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path , 'customerCoupan');
            }else{
                $image = null;
            }

            $coupan = CustomerCoupan::create([
                'zone_id'           => implode(',',$zones),
                'subzone_id'        => implode(',',$subzones),
                'store_id'          => implode(',',$stores),
                'module_id'         => implode(',',$modules),
                'category_id'       => implode(',',$category),
                'image'             => $image,
                'title'             => $request->title,
                'sub_heading'       => $request->sub_heading,
                'discount'          => $request->discount,
                'discountType'      => $request->discountType,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'coupan_code'       => $request->coupan_code,
                'maximum_discount_amount' => $request->maximum_discount,
                'minimum_purchase'  => $request->minimum_purchase,
            ]);
            DB::commit();
            return redirect()->route('admin.customerCoupan.index')->with('message', 'Customer Coupan generate successfully');
        }
    }

    public function delete($id)
    {
        $coupan = CustomerCoupan::where('id',$id)->first();
        $coupan->destroy($id);
        return response()->json(['status' => true,'message' => 'Coupan Deleted successfully']);
    }

    public function getSubZone(Request $request)
    {
        $subzones = SubZone::where('zone_id',$request->zone_id)->where('status', 1)->get();
        if($request->zone_id == 'all'){
            $subzones = SubZone::where('status', 1)->get();
        }
        return response()->json(['subzones' => $subzones]);
    }

    public function getCategoryandStore(Request $request)
    {
        $categorys = Category::where('module_id',$request->module_id)->where('status', 1)->get();
        $stores = Store::where('module_id',$request->module_id)->get();

        if($request->module_id == 'all'){
            $categorys = Category::where('status', 1)->get();
            $stores = Store::all();
        }

        return response()->json(['categorys' => $categorys , 'stores' => $stores]);
    }
}
