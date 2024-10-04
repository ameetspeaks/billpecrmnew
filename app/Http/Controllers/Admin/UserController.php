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

use App\Models\Module;
use App\Models\Coupan;

use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\ChangePackageSubscription;
use App\Models\PackageExtentDate;
use Carbon\Carbon;
use DataTables;

use Auth;
use App\Models\PackageOrder;
use App\Models\PackageTransection;

use App\Exports\StoreExport;
use App\Exports\UserExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str; 

class UserController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = User::with('role');
            return DataTables::of($data)
                ->make(true);
        }
       return view('admin.user.index');
    }

    public function add()
    {
       $roles = Role::where('id' , '!=', 1)->get();
       return view('admin.user.add', compact('roles'));
    }

    public function store(Request $request)
    {        
        DB::beginTransaction();
       
        $rules = [
            'whatsapp_no' => 'required|numeric|digits:10',
            'role_type' => 'required|numeric',
        ];
            if($request->role_type == '5'){
                $rules['aadhar_number'] = 'required';
                $rules['driving_licence'] = 'required';
            }
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $user_id = Auth::user()->id;

            $checkUserformultiple = User::where('whatsapp_no',$request->whatsapp_no)->where('role_type',$request->role_type)->first();
            if($checkUserformultiple){
                return redirect()->back()->with('error', 'The user of this role already exists.');
            }

            #save image
            $image = $request->image;
            if ($image) {
                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path, 'user');
            }else{
                $image = null;
            }

            $roleID = Role::where('id',$request->role_type)->first();
            #add user
            $userAdd = User::create([
                'user_id'           => $user_id,
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => bcrypt($request->password),
                'role_type'         => $roleID->id,
                'whatsapp_no'       => $request->whatsapp_no,
                'image'             => $image,
                'unique_id'         => CommonController::generate_uuid('users'),
                'aadhar_number'     => $request->aadhar_number,
                'driving_licence'   => $request->driving_licence,
            ]);
            #assign role to user
            $userAdd->syncRoles($roleID->id);
            $userAdd->save();

            DB::commit();
            return redirect()->route('admin.user.index')->with('message', 'User added successfully');
        }
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        $roles = Role::where('id' , '!=', 1)->get();
        return view('admin.user.edit', compact('roles','user'));
    }

    public function update(Request $request)
    {        
        DB::beginTransaction();
       
        $rules = [
            'whatsapp_no' => 'required|numeric|digits:10',
            'role_type' => 'required|numeric',
        ];
            if($request->role_type == '5'){
                $rules['aadhar_number'] = 'required';
                $rules['driving_licence'] = 'required';
            }
        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {

            $checkUserformultiple = User::where('id', '!=',$request->user_id)->where('whatsapp_no',$request->whatsapp_no)->where('role_type',$request->role_type)->first();
            if($checkUserformultiple){
                return redirect()->back()->with('error', 'The user of this role already exists.');
            }
            $roleID = Role::where('id',$request->role_type)->first();
            $user = User::where('id',$request->user_id)->first();
            #save image
            $image = $request->image;
            if ($image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $user->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path, 'user');
            }else{
                $image = $user->image;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_type = $roleID->id;
            $user->whatsapp_no = $request->whatsapp_no;
            $user->image = $image;
            $user->aadhar_number = $request->aadhar_number;
            $user->driving_licence = $request->driving_licence;
            $user->save();

            $user->syncRoles($roleID->id);
            DB::commit();
            return redirect()->route('admin.user.index')->with('message', 'User updated successfully');
        }
    }

    public function export()
    {
        return Excel::download(new UserExport, 'user.xlsx');
    }
}
