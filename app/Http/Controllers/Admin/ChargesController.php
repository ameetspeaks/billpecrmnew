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
use App\Models\Zone;
use App\Models\Charges;

class ChargesController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Charges::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.charges.index');
    }

    public function add()
    {
        $zones = Zone::where('status', 1)->get();
        return view('admin.charges.add',compact('zones'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'zone_id' => 'required',
            'name' => 'required',
            'amount' => 'required',
            'minimum_cart_value' => 'required',
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

            #save image
            $image = $request->image;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path , 'charges');
            }else{
                $image = null;
            }

            $coupan = Charges::create([
                'zone_id'           => implode(',',$zones),
                'subzone_id'        => implode(',',$subzones),
                'name'              => $request->name,
                'amount'            => $request->amount,
                'minimum_cart_value'=> $request->minimum_cart_value,
                'start_time'        => $request->start_time,
                'end_time'          => $request->end_time,
                'occurring'         => $request->occurring,
                'image'             => $image,
                'status'            => '1',

            ]);
            DB::commit();
            return redirect()->route('admin.charges.index')->with('message', 'Charges added successfully');
        }
    }

    public function edit($id)
    {
        $charge = Charges::where('id',$id)->first();
        $zones = Zone::where('status', 1)->get();
        return view('admin.charges.edit',compact('zones','charge'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required',
            'amount' => 'required',
            'minimum_cart_value' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $Charges = Charges::where('id',$request->chargeID)->first();

            #save image
            $image = $request->image;
            if ($image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $Charges->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path , 'charges');
            }else{
                $image = $Charges->image;
            }

            $Charges->name = $request->name;
            $Charges->amount = $request->amount;
            $Charges->minimum_cart_value = $request->minimum_cart_value;
            $Charges->start_time = $request->start_time;
            $Charges->end_time = $request->end_time;
            $Charges->occurring = $request->occurring;
            $Charges->image = $image;
            $Charges->save();

            DB::commit();
            return redirect()->route('admin.charges.index')->with('message', 'Charges updated successfully');
        }
    }

    public function delete($id)
    {
        $charge = Charges::where('id',$id)->first();
        $charge->destroy($id);
        return response()->json(['status' => true,'message' => 'Charges Deleted.']);
    }
}
