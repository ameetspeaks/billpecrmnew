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

use DataTables;

class UnitController extends Controller
{
    public function index()
    {
        return view('admin.unit.index');
    }

    public function add()
    {
        $attributes = Attribute::all();
        $modules = Module::all();
        return view('admin.unit.add', compact('attributes','modules'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'module_id' => 'required',
            'attribute_id' => 'required',
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $unit = Unit::create([
                'module_id'       => $request->module_id,
                'attribute_id'    => $request->attribute_id,
                'name'            => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.unit.index')->with('message', 'Unit added successfully');
        }
    }

    public function edit($id)
    {
        $units = Unit::where('id',$id)->first();
        $attributes = Attribute::all();
        $modules = Module::all();
        return view('admin.unit.edit', compact('units','modules','attributes'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'module_id' => 'required',
            'attribute_id' => 'required',
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $unit = Unit::where('id', $request->unitID)->first();
            $unit->name = $request->name;
            $unit->module_id = $request->module_id;
            $unit->attribute_id = $request->attribute_id;
            $unit->save();

            DB::commit();
            return redirect()->route('admin.unit.index')->with('message', 'Unit updated successfully');
        }
    }

    public function delete($id)
    {
        $package = Unit::where('id',$id)->first();
        $package->destroy($id);
        return response()->json(['status' => true,'message' => 'Unit Deleted successfully']);
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Unit::with('module')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.unit.index');
    }
}
