<?php

namespace App\Http\Controllers\Frontend;


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
use App\Models\Addon;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $subscriptions = SubscriptionPackage::where('id', '!=', 1)->where('status',1)->get();
        return view('billpeapp.index', compact('subscriptions'));
    }

    public function checkoutdata(Request $request)
    {
        Session::put('selectpackage',$request->packageSelectID);
        return redirect('checkout-1');
    }
}
