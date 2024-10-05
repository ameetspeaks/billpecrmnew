<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Zone;

use DataTables;

class PerKmRateByZoneController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Zone::orderBy("id", "DESC")->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.perKmRateByZone.index');
    }

    public function edit($id)
    {
        $zone = Zone::where('id', $id)->first();
        if(empty($zone)){
            return redirect()->back();
        }
        return view('admin.perKmRateByZone.edit', compact('zone'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'zoneID' => 'required|numeric',
            'per_km_rate' => 'required|numeric'
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $data = ["per_km_rate" => $request->per_km_rate];
            $update = Zone::where('id', $request->zoneID)->update($data);
            DB::commit();

            if($update){
                return redirect()->route('admin.perKmRateByZone.index')->with('message', 'Rate updated successfully');
            } else {
                return redirect()->back()->with('error', 'Rate update failed');
            }
        }
    }
}
