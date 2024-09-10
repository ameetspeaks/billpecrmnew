<?php

namespace App\Http\Controllers\Store;


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
use App\Models\Store;
use App\Models\Module;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use App\Models\CentralLibrary;
use App\Models\Attribute;
use App\Models\User;

use Session;
use DataTables;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProduct;
use App\Imports\ImportProduct;
use Auth;

class UserController extends Controller
{
    public function customers()
    {
        $data = User::where('role_type',4)->get();
        if(\request()->ajax()){
            $data = User::where('role_type',4)->get();

            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.customers');
    }

    public function store(Request $request)
    {
       
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
            $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();

            $checkUserformultiple = User::where('whatsapp_no',$request->whatsapp_no)->where('role_type',$request->role_type)->first();
            if($checkUserformultiple){
                return redirect()->back()->with('error', 'The user of this role already exists.');
            }

            $store_id = null;
            if($request->role_type == '3' || $request->role_type == '4')
            {
                $merchant_id = $userLogin->id;
            }else if($request->role_type == '6' || $request->role_type == '7'){
                $merchant_id = $userLogin->id;
                $store_id = Session::get('store_id');
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

            $password = $request->password;
            if($request->password){
                $password = bcrypt($request->password);
            }
        
            if($request->role_type == '6'){
                $checkstaffforstore = User::where('store_id',$store_id)->count();
                if($checkstaffforstore == 5){
                    return redirect()->back()->with('error', 'A store can add just 5 staff. Your 5 staff are complete.');
                }
            }
            
            #add user
            $userAdd = User::create([
                'user_id'           => $merchant_id,
                'store_id'          => $store_id,
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => $password,
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

            $token = $userAdd->createToken('billpe.cloud')->accessToken;
            DB::commit();
            return redirect()->back()->with('message', ''.$request->type . ' ' . 'added successfully');
        }
    }

    public function update(Request $request)
    {
       
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
            $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();
            
            $store_id = null;
            if($request->role_type == '3' || $request->role_type == '4')
            {
                $merchant_id = $userLogin->id;
            }else if($request->role_type == '6' || $request->role_type == '7'){
                $merchant_id = $userLogin->id;
                $store_id = Session::get('store_id');
            }
            
            $userAdd = User::where('id',$request->id)->first();
            #save image
            $image = $request->image;
            if ($image) {
                $find = url('/storage');
                $pathurl = str_replace($find, "", $userAdd->image);

                if(File::exists('storage'.$pathurl))
                {
                    File::delete('storage'.$pathurl);
                }

                $path  = config('image.profile_image_path_view');
                $image = CommonController::saveImage($image, $path, 'user');
            }else{
                $image = $userAdd->image;
            }

            $roleID = Role::where('id',$request->role_type)->first();

            $password = $request->password;
            if($request->password){
                $password = bcrypt($request->password);
            }
        
            if($request->role_type == '6'){
                $checkstaffforstore = User::where('store_id',$store_id)->count();
                if($checkstaffforstore == 5){
                    return redirect()->back()->with('error', 'A store can add just 5 staff. Your 5 staff are complete.');
                }
            }

            
            $userAdd->user_id = $merchant_id;
            $userAdd->store_id = $store_id;
            $userAdd->name = $request->name;
            $userAdd->email = $request->email;
            $userAdd->password = $password;
            $userAdd->whatsapp_no = $request->whatsapp_no;
            $userAdd->image = $image;
            $userAdd->aadhar_number = $request->aadhar_number;
            $userAdd->driving_licence = $request->driving_licence;
            $userAdd->save();
        
            DB::commit();
            return redirect()->back()->with('message', ''.$request->type . ' ' . 'updated successfully');
        }
    }

    public function delete($id)
    {
        $user = User::where('id',$id)->first();
        $user->destroy($id);
        return response()->json(['status' => true,'message' => 'Deleted successfully']);
    }

    public function suppliers()
    {
        $data = User::where('role_type',3)->get();
        if(\request()->ajax()){
            $data = User::where('role_type',3)->get();

            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.suppliers');
    }

    public function staff()
    {
        $data = User::where('role_type',6)->get();
        if(\request()->ajax()){
            $data = User::where('role_type',6)->get();

            return DataTables::of($data)
                ->make(true);
        }
        return view('store.storeAdmin.staff');
    }
}
