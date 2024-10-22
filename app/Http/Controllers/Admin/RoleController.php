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

class RoleController extends Controller
{
    
    public function index()
    {
       return view('admin.role.index');
    }

    public function add()
    {
        $permissions = CommonController::showRolePermission(null);
        return view('admin.role.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:roles',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if($request->permissions){
                $permissions = Permission::whereIn('id',$request->permissions)->get()->pluck('id');
            }else{
                $permissions = array();
            }
            $role->syncPermissions($permissions);
            DB::commit();
            return redirect()->route('admin.role.index')->with('message', 'Role added successfully');
        }
    }

    public function edit($id)
    {
        $role = Role::where('id', $id)->first();
        $permissions = CommonController::showRolePermission($role->id);

        return view('admin.role.edit', compact('permissions','role'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        
        $rules = [
            'name' => 'required|unique:roles,name,'.$request->roleID,
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $role = Role::where('id', $request->roleID)->first();
            $role->name       = $request->name;
            $role->guard_name = 'web';
            $role->save();

           
            if($request->permissions){
                $permissions = Permission::whereIn('id',$request->permissions)->get()->pluck('id');
            }else{
                $permissions = array();
            }
            // print_r($permissions); die;
            $role->syncPermissions($permissions);
            
            DB::commit();
            return redirect()->route('admin.role.index')->with('message', 'Role updated successfully');
        }
    }

    public function getDatatable()
    {
        $data = Role::get();

        if(\request()->ajax()){
            $data = Role::get();
            return DataTables::of($data)
                // ->addIndexColumn()
                // ->addColumn('action', function($row){
                //     // $actionBtn = '<a href="'.route("role.edit",["id" => $row->id]).'" class="edit btn btn-success btn-sm"> Edit </a> ';
                //     $actionBtn ="  @can('Edit Role') '<button>Edit</button>' @endcan ";

                //     return $actionBtn;
                // })
                // ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role.index');
    }
}
