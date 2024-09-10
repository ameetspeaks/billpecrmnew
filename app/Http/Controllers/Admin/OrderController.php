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
use App\Models\Store;
use App\Models\Module;
use App\Models\Unit;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\CentralLibrary;
use App\Models\Attribute;
use App\Models\CustomerOrder;
use App\Models\OrderStatus;
use App\Models\User;

use DataTables;

class OrderController extends Controller
{
    public function allOrder()
    {
        if(\request()->ajax()){
            $data = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->orderBy('created_at', 'DESC')->get();
            foreach($data as $datas){
                $datas->date = date('Y-m-d H:i:s', strtotime($datas->created_at));
                // print_r($data); die;
            }
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.order.allOrder');
    }

    public function viewOrder($id)
    {
        $order  = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->where('id',$id)->first();
        $orderStatus = OrderStatus::where('id' , '>=', $order->order_status)->get();

        $deliveryAgents = User::where('role_type',5)->get();
        // print_r($orderStatus->toarray()); die;
        return view('admin.order.viewOrder', compact('order','orderStatus','deliveryAgents'));
    }

    public function orderStatusChange(Request $request)
    {
        $orderchange = CustomerOrder::where('id',$request->id)->update(['order_status' => $request->order_id]);
        return response()->json('success');
    }

    public function assignOrderToDeliveryBoy(Request $request)
    {
        CustomerOrder::where('id',$request->order_id)->update(['deliveryboy_id' => $request->agent_id]);
        return redirect()->back()->with('message', 'Order Assign Successfully.');
    }
}
