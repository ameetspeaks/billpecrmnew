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
use App\Events\OrderStatusUpdated;
use App\Events\NotificationToDP;


use DataTables;

class OrderController extends Controller
{
    public function allOrder()
    {
        if(\request()->ajax()){
            $data = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->orderBy('created_at', 'DESC');
            // foreach($data as $datas){
            //     $datas->date = date('Y-m-d H:i:s', strtotime($datas->created_at));
            //     // print_r($data); die;
            // }
            return  Datatables::of($data)
           
            // ->editColumn('order_number', function ($row) {
            //     return @$row->id;
            // })
            ->editColumn('date', function ($row) {
                return @$row->date;
            })
            ->editColumn('customer_name', function ($row) {
                return @$row->customer->name;
            })
            ->editColumn('shop_name', function ($row) {
                return @$row->store->shop_name;
            })
            ->editColumn('total_amount', function ($row) {
                return @$row->total_amount;
            })
            ->editColumn('order_status', function ($row) {
                
                return '<button class="btn btn-primary btn-sm">'.@$row->orderStatus->name.'<button> ';
            })
            ->addColumn('action',function($row){
                return ' <ul>  <li ><a href="'.url('admin/ViewOrder').'/' . $row->id .'" " ><button class="btn btn-success btn-sm">View<button></a></li>  <li><a href="#" > </ul>';
            })
            ->rawColumns(['action','order_status'])
            ->make(true);
        }
        return view('admin.order.allOrder');
    }

    public function viewOrder($id)
    {
        $order = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->where('id',$id)->first();
        $orderStatus = OrderStatus::where('id' , '>=', $order->order_status)->get();

        $deliveryAgents = User::where('role_type',5)->get();
        // print_r($orderStatus->toarray()); die;
        return view('admin.order.viewOrder', compact('order','orderStatus','deliveryAgents'));
    }

    public function orderTracking()
    {
        $orders  = CustomerOrder::with('customer','store','address','orderStatus','delivery_boy')->orderBy('id', 'DESC')->get();
        $allOrderStatus = OrderStatus::get();
        return view('admin.order.trackOrder', compact('orders','allOrderStatus'));
    }

    public function updateOrderStatus(Request $request)
    {
        return response()->json('API Removed');
    }

    public function orderStatusChange(Request $request)
    {
        $updateStatus = CommonController::orderStatusChangeCommon($request->order_id, $request->order_status_id, "merchant_order_status");

        if ($updateStatus['success']) {
            $response = ['success' => true, 'message' => 'Order Status Update Successfully.'];
        } else {
            $response = $updateStatus;
        }
        return response()->json($response, 200);
    }

    public function assignOrderToDeliveryBoy(Request $request)
    {
        $rules = [
            'order_id' => 'required|numeric|exists:customer_orders,id',
            'agent_id' => 'required|numeric',
        ];

        $requestData = $request->all();
        $validator = Validator::make($requestData, $rules);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->all()[0]);
        } else {
            CommonController::assignOrderToDeliveryBoyCommon($request->order_id, $request->agent_id);
            
            return redirect()->back()->with('message', 'Order Assign Successfully.');
        }
    }
}