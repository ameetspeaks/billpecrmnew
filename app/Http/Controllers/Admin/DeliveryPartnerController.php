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

use App\Models\User;
use App\Models\DeliveryPartners;

use DataTables;

class DeliveryPartnerController extends Controller
{
    public function index()
    {
        if(\request()->ajax()){
            $data = DeliveryPartners::with(["delivery_boy_detail", "shift_detail"]);
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.deliveryPartner.index');
    }

    public function view($id)
    {
        $user = DeliveryPartners::with(["delivery_boy_detail", "shift_detail"])->where('user_id',$id)->first();
        if(empty($user)){
            return redirect()->back();
        }
        return view('admin.deliveryPartner.view', compact('user'));
    }

    public function accountStatusChange(Request $request)
    {
        DeliveryPartners::where('user_id', $request->id)
            ->update(['account_status' => $request->account_status]);

        return response()->json('success');
    }
}
