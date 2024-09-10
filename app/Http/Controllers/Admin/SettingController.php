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

use App\Models\Setting;
use App\Models\AppVersion;

use App\Models\Module;
use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use App\Models\SubscriptionPackage;
use App\Models\ChangePackageSubscription;
use App\Models\PackageExtentDate;
use Carbon\Carbon;
use DataTables;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function updateUser(Request $request)
    {
        try {
            $rules = [
                'name'  => 'required',
                'email'  => 'required',
                'number'  => 'required|min:10|max:10', 
                'password_confirmation' => 'required_with:password|same:password'
            ];
             
            $requestData = $request->all();
            $validator = Validator::make($requestData, $rules);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            } else {

                

                $user = User::where('id',$request->id)->first();
                $user->name =  $request->name;
                $user->whatsapp_no = $request->number;
                if($user->email!= $request->email)
                {
                    $user->email = $request->email;
                }

                if ($request->has('password')) {
                    $encrptPassword = Hash::make($request->password);
                    $user->password = $encrptPassword;
                }

                #save image
                $image = $request->image;
                if ($image) {
                    $path  = config('image.profile_image_path_view');
                    $image = CommonController::saveImage($image, $path, 'user');
                }else{
                    $image = $user->image;
                }

                $user->image = $image;
                $user->save();
                DB::commit();

                return redirect()->route('admin.setting')->with('message', 'User setting added successfully');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updatesetup(Request $request)
    {
        Setting::where('type','company_business_name')->update(['value' => $request->name]);
        Setting::where('type','company_email')->update(['value' => $request->email]);
        Setting::where('type','company_phone')->update(['value' => $request->phone]);
        Setting::where('type','company_address')->update(['value' => $request->address]);
        Setting::where('type','company_footer_text')->update(['value' => $request->footer_text]);

        if($request->logo)
        {
            $data = Setting::where('type','company_logo')->first();

            if($data->value)
            {
                if(File::exists('public/admin/upload/'.$data->value))
                {
                    File::delete('public/admin/upload/'.$data->value);
                }
            }

            $image= $request->file('logo');
            $imagename= time() ."-" . uniqid() . '.png';
            $image->move(('public/admin/upload'), $imagename);
            $data->value = $imagename;
            $data->save();
        }

        if($request->fav_icon)
        {
            $data = Setting::where('type','company_fav_icon')->first();

            if($data->value)
            {
                if(File::exists('public/admin/upload/'.$data->value))
                {
                    File::delete('public/admin/upload/'.$data->value);
                }
            }

            $image= $request->file('fav_icon');
            $imagename= time() ."-" . uniqid() . '.png';
            $image->move(('public/admin/upload'), $imagename);
            $data->value = $imagename;
            $data->save();
        }
        
        $version = AppVersion::first();
        if ($version) {    
            $newVersionName = $request->input('version_name');
            if ($newVersionName) {
                $version->name = $newVersionName;
                $version->save();   
                                
            }
        }
        return redirect()->route('admin.setting')->with('message', 'App setting added successfully');
    }
}
