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
use App\Models\Store;

use DataTables;

class ZoneController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = Zone::get();
            return DataTables::of($data)
                ->make(true);
        }
       return view('admin.zone.index');
    }

    public function add()
    {
       return view('admin.zone.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|unique:zones',
            'mapDetails' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $zone = Zone::create([
                'name'          => $request->name,
                'map_details'   => $request->mapDetails,
                'status'        => '1',
            ]);

            $zoneAssignInCharges = DB::table('charges')->whereIn('id', [1, 2])->get();

            foreach ($zoneAssignInCharges as $zoneAssignInCharge) {
                // Append ',1' to the existing zone_id
                $newZoneId = $zoneAssignInCharge->zone_id .','.$zone->id;

                // Update the record directly
                DB::table('charges')->where('id', $zoneAssignInCharge->id)->update(['zone_id' => $newZoneId]);
            }
            DB::commit();
            return redirect()->route('admin.zone.index')->with('message', 'Zone added successfully');
        }
    }

    public function edit($id)
    {
        $zone = Zone::where('id', $id)->first();
        return view('admin.zone.edit', compact('zone'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|unique:zones,name,'.$request->zone_id,
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $zone = Zone::where('id', $request->zone_id)->first();
            $zone->name       = $request->name;
            if($request->mapDetails)
            {
                $zone->map_details = $request->mapDetails;
            }
            $zone->save();

            DB::commit();
            return redirect()->route('admin.zone.index')->with('message', 'Zone updated successfully');
        }
    }

    public function assignZone(Request $request)
    {
        $zones = Zone::where('status',1)->get();
        $stores = Store::whereNull('zone_id')->get();
        // print_r($zone->toarray()); die;
        return view('admin.zone.assignzone', compact('zones','stores'));
    }

    public function assignstoreupdate(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'zone_id' => 'required',
            'store_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $stores = Store::whereIn('id',$request->store_id)->update(['zone_id' => $request->zone_id]);
            DB::commit();
            return redirect()->back()->with('message', 'Zone Assign successfully');
        }
    }
}
