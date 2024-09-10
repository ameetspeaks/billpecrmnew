<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Store;
use App\Models\Module;
use App\Models\Product;
use App\Models\Category;
use App\Models\BillDetail;
use App\Models\Attribute;
use App\Models\AppActivity;
use App\Exports\PaidUserExport;
use App\Exports\TrialUserExport;

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
use Excel;
use PDF;

class DashboardController extends Controller
{
    
    public function dashboard()
    {
        $todatDate = date('Y-m-d');

        $store = Store::count();
        $storeCountToday = Store::whereDate('created_at', $todatDate)->count();

        $bill = BillDetail::count();
        $billCountToday = BillDetail::whereDate('created_at', $todatDate)->count();

        $totalAmount = BillDetail::sum('amount');
        $totalAmountToday = BillDetail::whereDate('created_at', $todatDate)->sum('amount');

        $totalCustomer = BillDetail::distinct()->count('customer_name');
        $totalUniqueCustomers = BillDetail::whereDate('created_at', $todatDate)->distinct()->count('customer_name');

        $paidPackageCounts = Store::where('package_id', '<>', 1)->count();
        $todayPaidPackageCount = Store::where('package_id', '<>', 1)->whereDate('created_at', $todatDate)->count();

        $trialPackage = Store::where('package_id', 1)->count();
        $todayTrailPackage = Store::where('package_id', 1)->whereDate('created_at', $todatDate)->count();

        $billHistories = BillDetail::all();
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
            ->orderBy('bill_history_count', 'desc')
            ->limit(10)
            ->get();

        $dataBillChart = BillDetail::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(total_amount) AS total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $data = BillDetail::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total'))
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

       return view('admin.dashboard', compact('store','storeCountToday','bill','billCountToday','totalAmount','totalAmountToday','totalCustomer','totalUniqueCustomers','paidPackageCounts','todayPaidPackageCount','trialPackage','todayTrailPackage','topSoldItems','topSellingStores','dataBillChart','chartData'));
    }

    public function storeDetails()
    {
        return view('admin.storeDetails');
    }

    public function viewTable(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $query = Store::with('billHistory')->orderBy('id', 'DESC');
    
            if ($startDate && $endDate) {
                $query = Store::with('billHistory')->orderBy('id', 'DESC')->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate && !$endDate) {
                $query = Store::with('billHistory')->orderBy('id', 'DESC')->whereDate('created_at', $startDate);
            }
            
            $data = $query->get();
            foreach($data as $datas){
                $datas->billcount = $datas->billHistory->count();
                $datas->billamount = $datas->billHistory->sum('amount');
                $datas->customers = $datas->billHistory->pluck('customer_name')->unique()->count();
            }
          
            return DataTables::of($data)
                ->make(true);
        }
        
        return view('admin.viewTable');
    }

    public function totalbilldetail(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            $query = BillDetail::with('store')->select('store_id', DB::raw('SUM(amount) as totalAmount') , DB::raw('count(bill_number) as totalBill'));

            
            if ($startDate && $endDate) {
                $query = $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate && !$endDate) {
                $query = $query->whereDate('created_at', $startDate);
            }
            
            $data = $query->groupBy('store_id')->get();

            return DataTables::of($data)
                ->make(true);
        }
        
        return view('admin.totalBillDetail');
    }

    public function trialStoreDetails()
    {
        return view('admin.trialStoreDetails');
    }

    public function viewTrialUser(Request $request)
    {
        if ($request->ajax()) {
            $data = Store::with('user','module')->where('package_id', 1)->orderby('created_at', 'DESC')->get();
            
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.viewTrialUser');
    }

    public function activity(Request $request)
    {
        if ($request->ajax()) {
            $data = AppActivity::orderBy('created_at','DESC')->get();
            foreach($data as $d)
            {
                $d->datecurrent = $d->created_at->format('Y-m-d H:i:s');
            }
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.activity');
    }

    public function totalPaidUser(Request $request)
    {
        if ($request->ajax()) {
            $data = Store::with('user','module')->where('package_id', '<>', 1)->orderby('created_at', 'DESC')->get();
            
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.totalPaidUser');
    }

    public function exportPaidUser() 
    {
        // use Excel facade to export data, by passing in the UserExport class and the desired file name as arguments
        return Excel::download(new PaidUserExport, 'paidusers.xlsx');
    }

    public function exportTrialUser() 
    {
        // use Excel facade to export data, by passing in the UserExport class and the desired file name as arguments
        return Excel::download(new TrialUserExport, 'trialusers.xlsx');
    }


    public function dwnloadpdf()
    {
        $data = ['title' => 'domPDF in Laravel 10'];
        $pdf = PDF::loadView('checkpdf', $data);
        return $pdf->download('tt.pdf');
    }
}
