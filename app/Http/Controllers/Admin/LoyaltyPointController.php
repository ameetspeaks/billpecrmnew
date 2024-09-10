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
use App\Models\Module;
use App\Models\StoreType;
use App\Models\LoyaltyPoint;

use Auth;
use DataTables;

class LoyaltyPointController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = LoyaltyPoint::with('module')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.loyaltypoint.index');
    }

    public function add()
    {
        $modules = Module::where('status',1)->get();
        return view('admin.loyaltypoint.add' , compact('modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'modules_id' => 'required',
            'one_INR_point_amount' => 'required',
            'min_point_per_order' => 'required',
            'max_point_to_convert' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            // print_r($request->all()); die;
            $point = LoyaltyPoint::create([
                'modules_id'          => $request->modules_id,
                'one_INR_point_amount'=> $request->one_INR_point_amount,
                'min_point_per_order' => $request->min_point_per_order,
                'max_point_to_convert'=> $request->max_point_to_convert,
            ]);
            DB::commit();
            return redirect()->route('admin.loyaltypoint.index')->with('message', 'Loyalty Point added successfully');
        }
    }

    public function edit($id)
    {
        $point = LoyaltyPoint::where('id',$id)->first();
        $modules = Module::where('status',1)->get();
        return view('admin.loyaltypoint.edit' , compact('modules','point'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'modules_id' => 'required',
            'one_INR_point_amount' => 'required',
            'min_point_per_order' => 'required',
            'max_point_to_convert' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $loyalty = LoyaltyPoint::where('id',$request->loyalty_id)->first();
            $loyalty->modules_id = $request->modules_id;
            $loyalty->one_INR_point_amount = $request->one_INR_point_amount;
            $loyalty->min_point_per_order = $request->min_point_per_order;
            $loyalty->max_point_to_convert = $request->max_point_to_convert;
            $loyalty->save();

            DB::commit();
            return redirect()->route('admin.loyaltypoint.index')->with('message', 'Loyalty Point updated successfully');
        }
    }

    public function delete($id)
    {
        $point = LoyaltyPoint::where('id',$id)->first();
        $point->destroy($id);
        return response()->json(['status' => true,'message' => 'Loyalty Point Deleted.']);
    }
}
