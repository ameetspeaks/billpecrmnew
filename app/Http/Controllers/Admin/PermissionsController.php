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

use DataTables;

class PermissionsController extends Controller
{
    public function index()
    {
       return view('admin.permission.index');
    }

    public function add()
    {
        return view('admin.permission.add');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:permissions',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $role = Permission::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);
            DB::commit();
            return redirect()->route('admin.permission.index')->with('message', 'Permission added successfully');
        }
    }

    public function getDatatable()
    {
        $data = Permission::get();

        if(\request()->ajax()){
            $data = Permission::get();
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.permission.index');
    }
}
