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
use App\Models\SubUnit;

use DataTables;


class SubUnitController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = SubUnit::with('unit')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.subunit.index');
    }

    public function add()
    {
        $units = Unit::all();
        return view('admin.subunit.add', compact('units'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'unit_id' => 'required',
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $subunit = SubUnit::create([
                'unit_id'         => $request->unit_id,
                'name'            => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.subunit.index')->with('message', 'Sub Unit added successfully');
        }
    }

    public function edit($id)
    {
        $subunit = SubUnit::where('id',$id)->first();
        $units = Unit::all();
        return view('admin.subunit.edit', compact('subunit','units'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'unit_id' => 'required',
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $subunit = SubUnit::where('id', $request->subunit_id)->first();
            $subunit->name = $request->name;
            $subunit->unit_id = $request->unit_id;
            $subunit->save();

            DB::commit();
            return redirect()->route('admin.subunit.index')->with('message', 'Sub Unit updated successfully');
        }
    }
}
