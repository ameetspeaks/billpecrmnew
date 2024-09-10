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

use Auth;
use DataTables;

class ModuleController extends Controller
{
    public function index()
    {
        return view('admin.module.index');
    }

    public function add()
    {
        $StoreTypes = StoreType::all();
        return view('admin.module.add', compact('StoreTypes'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
            'store_type_id' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $package = Module::create([
                'user_id'                 => Auth::user()->id,
                'store_type_id'           => $request->store_type_id,
                'name'                    => $request->name,
                'status'                  => '1',  
            ]);
            DB::commit();
            return redirect()->route('admin.module.index')->with('message', 'Module added successfully');
        }
    }

    public function edit($id)
    {
        $module = Module::where('id',$id)->first();
        $StoreTypes = StoreType::all();
        return view('admin.module.edit', compact('module','StoreTypes'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $module = Module::where('id', $request->moduleId)->first();
            $module->store_type_id      = $request->store_type_id;
            $module->name               = $request->name;
            $module->save();
            DB::commit();
            return redirect()->route('admin.module.index')->with('message', 'Module updated successfully');
        }
    }
    
    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = Module::with('store_type')->get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.module.index');
    }

    public function changeOnlineStatus(Request $request)
    {
        if($request->statusName == 'module')
        {
            $module = Module::where('id', $request->id)->first();
            if ($module->online == '1') {
                $module->online = '0';
            } else {
                $module->online = '1';
            }
            $module->save();
        }

        return response()->json(['status' => true, 'message' => 'Online Module Status Change successfully']);
    }
}
