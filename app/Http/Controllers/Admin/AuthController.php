<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function loginInsert(Request $request)
    {
        // VALIDATION START
            $rules = array(
                'email'     => 'required',
                'password'     => 'required',
                );

            $validatorMesssages = array(
                'email.required'=>'Please Enter Email.',
                'password.required'=>'Please Enter Password.',
                );

            $validator = Validator::make($request->all(), $rules, $validatorMesssages);

            if ($validator->fails()) {

                $error=json_decode($validator->errors());
                return response()->json(['status' => 401,'error1' => $error]);
            }
        // VALIDATION END

        $checkUser = User::where('email', '=', $request->email)->first();
       
        if(empty($checkUser))
        {
            $error = array('email'=>'Mail Not Match.');
            return response()->json(['status' => 401,'error1' => $error]);
        }

        $credentials = ['email'=>$request->email,'password'=>$request->password];
        // if(Auth::guard('admin')->attempt($credentials))
        if (Auth::attempt($credentials))
        {
            $redirect = route('admin.dashboard');
            // if($checkUser->role_type == 7 || $checkUser->role_type == 8)
            // {
            //     $redirect = route('admin.store.manualPayment');
            // }else{
            //     $redirect = route('admin.dashboard');
            // }
  
            return response()->json(['status' => 1,'data' => "", 'redirect' => $redirect]);
        }
        else
        {
            $error = array('password'=>'Password Not Match.');
            return response()->json(['status' => 401,'error1' => $error]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

}
