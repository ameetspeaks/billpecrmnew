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

use App\Models\Zone;
use App\Models\SubZone;
use App\Models\Store;

use DataTables;


class SubZoneController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = SubZone::get();
            return DataTables::of($data)
                ->make(true);
        }
       return view('admin.subzone.index');
    }

    public function add()
    {
        $stores = Store::all();
        $zones = Zone::all();
       return view('admin.subzone.add', compact('stores','zones'));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        
        $rules = [
            'zone_id' => 'required',
            'name' => 'required|unique:sub_zones',
            'store_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $subzone = SubZone::create([
                'zone_id' => $request->zone_id,
                'name'    => $request->name,
                'store_id'=> implode(',',$request->store_id),
                'status'  => '1',
            ]);
            DB::commit();
            return redirect()->route('admin.subzone.index')->with('message', 'Sub Zone added successfully');
        }
    }

    public function edit($id)
    {
        $subZone = SubZone::where('id',$id)->first();
        $stores = Store::all();
        $zones = Zone::all();
       return view('admin.subzone.edit', compact('stores','zones','subZone'));
    }
    
    public function update(Request $request)
    {

        DB::beginTransaction();
        
        $rules = [
            'zone_id' => 'required',
            'name' =>    'required|unique:sub_zones,name,'.$request->subzone_id,
            'store_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $subzone = SubZone::where('id', $request->subzone_id)->first();
            $subzone->zone_id    = $request->zone_id;
            $subzone->name       = $request->name;
            $subzone->store_id   = implode(',',$request->store_id);
            $subzone->save();

            DB::commit();
            return redirect()->route('admin.subzone.index')->with('message', 'Sub Zone updated successfully');
        }
    }
}
