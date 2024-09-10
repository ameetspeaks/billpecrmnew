<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Store;
use App\Models\Module;
use App\Models\Product;
use App\Models\Category;
use App\Models\BillDetail;
use App\Models\Attribute;
use App\Models\WholesellerBillcreate;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Models\CentralLibrary;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use App;
use Session;
use DataTables;

class DashboardController extends Controller
{
    public function storeDashboard($store_id ,$user_unique_id)
    {
        Session::put('store_id', $store_id);
        Session::put('user_unique_id', $user_unique_id);

        $storeData = Store::where('id',$store_id)->first();
        $todatDate = date('Y-m-d');

        $store = Store::where('id',$store_id)->count();
        $storeCountToday = Store::where('id',$store_id)->whereDate('created_at', $todatDate)->count();

        $bill = BillDetail::where('store_id',$store_id)->count();
        $billCountToday = BillDetail::where('store_id',$store_id)->whereDate('created_at', $todatDate)->count();

        $totalAmount = BillDetail::where('store_id',$store_id)->sum('amount');
        $totalAmountToday = BillDetail::where('store_id',$store_id)->whereDate('created_at', $todatDate)->sum('amount');

        $totalCustomer = BillDetail::where('store_id',$store_id)->distinct()->count('customer_name');
        $totalUniqueCustomers = BillDetail::where('store_id',$store_id)->whereDate('created_at', $todatDate)->distinct()->count('customer_name');

        $topSoldItems = array();

        $billHistories = BillDetail::where('store_id',$store_id)->get();
        $itemCounts = [];
        foreach ($billHistories as $history) {
            $productDetails = json_decode($history->product_detail, true);
            if ($productDetails && is_array($productDetails)) {
                foreach ($productDetails as $item) {
                    $itemName = strtolower($item['product_name']);
                    if (isset($itemCounts[$itemName])) {
                        $itemCounts[$itemName]++;
                    } else {
                        $itemCounts[$itemName] = 1;
                    }
                }
            }
        }

        // Sort items by sold count in descending order
        arsort($itemCounts);

        // Get the top eight sold items
        $topSoldItems = array_slice($itemCounts, 0, 8);
        // print_r($topSoldItems); die;

        $topSellingStores = Store::withCount('billHistory')
            ->where('id',$store_id)
            ->orderBy('bill_history_count', 'desc')
            ->limit(10)
            ->get();

        $dataBillChart = BillDetail::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(total_amount) AS total')
        ->where('store_id',$store_id)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $data = BillDetail::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
        ->where('store_id',$store_id)
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $chartData = $data->map(function ($item) {
            return [
                'label' => date("F", mktime(0, 0, 0, $item->month, 1)), // Convert the month number to a month name
                'total' => $item->total,
            ];
        });
        
       return view('store.dashboard', compact('storeData','store','storeCountToday','bill','billCountToday','totalAmount','totalAmountToday','totalCustomer','totalUniqueCustomers',    'topSoldItems','topSellingStores','dataBillChart','chartData'));
    }

    public function directStoreLogin($store_id ,$user_unique_id)
    {
        $store = Store::where('id',$store_id)->first();
        $user = User::where('unique_id',$user_unique_id)->first();

        Session::put('store_id', $store_id);
        Session::put('user_unique_id', $user_unique_id);
       return redirect('store/dashboard');
    }

    public function dashboard()
    {
        $userLogin = User::where('unique_id',Session::get('user_unique_id'))->first();
        $stores = Store::where('user_id',$userLogin->id)->get();
        $storeids = $stores->pluck('id');
        $expiryProducts = Product::with('category','store','module')->whereIn('store_id', $storeids)->where('expiry', '<', date('Y-m-d'))->get();
        $recentProducts = Product::whereIn('store_id', $storeids)->orderBy('created_at','DESC')->get()->take(5);

        $totalCustomer = User::where('user_id',$userLogin->id)->where('role_type',4)->count();
        $totalSupplier = User::where('user_id',$userLogin->id)->where('role_type',3)->count();
        $totalSupplierBill = WholesellerBillcreate::whereIn('store_id', $storeids)->count();
        $totalSaleBill= BillDetail::whereIn('store_id', $storeids)->count();

        $totalPurchaseDue = WholesellerBillcreate::whereIn('store_id', $storeids)->sum('due_amount');
        $totalSalesDue = BillDetail::whereIn('store_id', $storeids)->sum('due_amount');
        $totalPurchaseAmount = WholesellerBillcreate::whereIn('store_id', $storeids)->sum('amount');
        $totalSalesAmount = BillDetail::whereIn('store_id', $storeids)->sum('amount');

        // print_r($totalsupplier); die;
        return view('store.storeAdmin.dashboard',compact('expiryProducts','recentProducts','totalCustomer','totalSupplier','totalSupplierBill','totalSaleBill','totalPurchaseDue','totalSalesDue','totalPurchaseAmount','totalSalesAmount'));
    } 

    public function changeStore($id)
    {
        Session::put('store_id', $id);
        return response()->json('success');
    }
}
