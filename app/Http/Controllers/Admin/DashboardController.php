<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PaidUserExport;
use App\Exports\TrialUserExport;
use App\Http\Controllers\Controller;
use App\Models\AppActivity;
use App\Models\BillDetail;
use App\Models\CustomerOrder;
use App\Models\Store;
use App\Models\Zone;
use Carbon\Carbon;
use DataTables;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $todayDate = date('Y-m-d');

        $store = Store::count();
        $storeCountToday = Store::whereDate('created_at', $todayDate)->count();

        $bill = BillDetail::count();
        $billCountToday = BillDetail::whereDate('created_at', $todayDate)->count();

        $totalAmount = BillDetail::sum('amount');
        $totalAmountToday = BillDetail::whereDate('created_at', $todayDate)->sum('amount');

        $totalCustomer = BillDetail::distinct()->count('customer_name');
        $totalUniqueCustomers = BillDetail::whereDate('created_at', $todayDate)->distinct()->count('customer_name');

        $paidPackageCounts = Store::where('package_id', '<>', 1)->count();
        $todayPaidPackageCount = Store::where('package_id', '<>', 1)->whereDate('created_at', $todayDate)->count();

        $trialPackage = Store::where('package_id', 1)->count();
        $todayTrailPackage = Store::where('package_id', 1)->whereDate('created_at', $todayDate)->count();

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


        $totalFee = CustomerOrder::whereNotNull('any_other_fee')
            ->whereRaw("JSON_LENGTH(any_other_fee) > 0")
            ->select(DB::raw("JSON_EXTRACT(any_other_fee, '$[*].amount') as amounts"))
            ->get()
            ->flatMap(function ($order) {
                $amounts = json_decode($order->amounts, true);
                return is_array($amounts) ? array_map('floatval', $amounts) : [];
            });



        $totalFeeToday = CustomerOrder::whereNotNull('any_other_fee')
            ->whereRaw("JSON_LENGTH(any_other_fee) > 0")
            ->whereDate('created_at', Carbon::today()) // Filter for today's orders
            ->select(DB::raw("JSON_EXTRACT(any_other_fee, '$[*].amount') as amounts"))
            ->get()
            ->flatMap(function ($order) {
                return array_map('floatval', json_decode($order->amounts, true));
            });


        $activeStores = Store::where('package_id', '<>', 1)->where('package_id', '!=', null)->get();
        $earningData['totalActiveStore'] = $activeStores->count();
        $earningData['totalActiveStoreToday'] = $activeStores->where('package_active_date', $todayDate)->count();
        $earningData['totalOrders'] = CustomerOrder::count();
        $earningData['totalOrdersToday'] = CustomerOrder::whereDate('created_at', $todayDate)->count();
        $earningData['totalFee'] = $totalFee->sum();
        $earningData['totalFeeToday'] = $totalFeeToday->sum();
        $earningData['totalAmount'] = CustomerOrder::sum('total_amount');
        $earningData['totalAmountToday'] = CustomerOrder::whereDate('created_at', $todayDate)->sum('total_amount');
        //        dd($earningData);

        return view('admin.dashboard', compact('earningData', 'store', 'storeCountToday', 'bill', 'billCountToday', 'totalAmount', 'totalAmountToday', 'totalCustomer', 'totalUniqueCustomers', 'paidPackageCounts', 'todayPaidPackageCount', 'trialPackage', 'todayTrailPackage', 'topSoldItems', 'topSellingStores', 'dataBillChart', 'chartData'));
    }

    public function storeDetails()
    {
        return view('admin.storeDetails');
    }

    public function activeStoreDetails()
    {
        $zones = Zone::get();
        return view('admin.activeStoreDetails', compact('zones'));
    }

    public function activeStoreDetailsApi(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $zoneId = $request->input('zone_id');

            $query = Store::with('package')->orderBy('id', 'DESC');
            if ($zoneId) {
                $query = $query->where('zone_id', $zoneId);
            }

            if ($startDate && $endDate) {
                $query = $query->whereBetween('package_active_date', [$startDate, $endDate]);
            } elseif ($startDate && !$endDate) {
                $query = $query->where('package_active_date', '>=', $startDate);
            }

            $data = $query->get();


            return DataTables::of($data)
                ->make(true);
        }

        return view('admin.viewTable');
    }

    public function totalOrderDetails()
    {
        $zones = Zone::get();
        return view('admin.totalOrderDetails', compact('zones'));
    }

    public function totalOrderDetailsApi(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $zoneId = $request->input('zone_id');

            $query = Store::with('package', 'customer_orders')->orderBy('id', 'DESC');

            if ($zoneId) {
                $query = $query->where('zone_id', $zoneId);
            }

            if ($startDate && $endDate) {
                $query = $query->whereHas('customer_orders', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                });
            } elseif ($startDate && !$endDate) {
                $query = $query->whereHas('customer_orders', function ($q) use ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                });
            }


            $data = $query->get()->map(function ($item) {
                // Add orderCount and orderAmount to each item
                $item->orderCount = $item->customer_orders->count();
                $item->orderAmount = $item->customer_orders->sum('total_amount');
                $item->orderAmount = number_format($item->orderAmount, 2);
                return $item;
            });


            return DataTables::of($data)
                ->make(true);
        }

        return null;
    }


    public function totalFeeDetails()
    {
        $zones = Zone::get();
        return view('admin.totalFeeDetails', compact('zones'));
    }

    public function totalFeeDetailsApi(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $zoneId = $request->input('zone_id');

            $query = Store::with('package', 'customer_orders')->orderBy('id', 'DESC');
            if ($zoneId) {
                $query = $query->where('zone_id', $zoneId);
            }

            if ($startDate && $endDate) {
                $query = $query->whereBetween('package_active_date', [$startDate, $endDate]);
            } elseif ($startDate && !$endDate) {
                $query = $query->where('package_active_date', '>=', $startDate);
            }


            $data = $query->get()->map(function ($item) {
                $handlingCharge = 0;
                $otherFees = 0;
                foreach ($item->customer_orders as $order) {
                    $anyOtherFee = json_decode($order->any_other_fee);
                    foreach ($anyOtherFee as $fee) {
                        if (isset($fee->id, $fee->amount)) {
                            if ($fee->id == 1) {
                                $handlingCharge += floatval($fee->amount);
                            } else {
                                $otherFees += floatval($fee->amount);
                            }
                        }
                    }
                }

                // Attach the calculated totals to the store item
                $item->handlingChargeTotal = number_format($handlingCharge, 2);
                $item->otherFeesTotal = number_format($otherFees, 2);
                $item->total = number_format($handlingCharge + $otherFees, 2);
                return $item;
            });


            return DataTables::of($data)
                ->make(true);
        }

        return null;
        //                return response()->json($data);
    }

    public function totalOrderAmountDetails()
    {
        $zones = Zone::get();
        return view('admin.totalOrderAmountDetails', compact('zones'));
    }

    public function totalOrderAmountDetailsApi(Request $request)
    {
        if ($request->ajax()) {
            $dateRange = $request->input('date_range');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $zoneId = $request->input('zone_id');

            $query = Store::with('package', 'customer_orders')->orderBy('id', 'DESC');
            if ($zoneId) {
                $query = $query->where('zone_id', $zoneId);
            }

            if ($startDate && $endDate) {
                $query = $query->whereBetween('package_active_date', [$startDate, $endDate]);
            } elseif ($startDate && !$endDate) {
                $query = $query->where('package_active_date', '>=', $startDate);
            }

            $data = $query->get()->map(function ($item) {
                // Add orderCount and orderAmount to each item
                $item->orderCount = $item->customer_orders->count();
                $item->orderAmount = $item->customer_orders->sum('amount');
                $item->orderAmount = number_format($item->orderAmount, 2);
                return $item;
            });


            return DataTables::of($data)
                ->make(true);
        }

        return null;

        return null;
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
            foreach ($data as $datas) {
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

            $query = BillDetail::with('store')->select('store_id', DB::raw('SUM(amount) as totalAmount'), DB::raw('count(bill_number) as totalBill'));


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
            $data = Store::with('user', 'module')->where('package_id', 1)->orderby('created_at', 'DESC')->get();

            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.viewTrialUser');
    }

    public function activity(Request $request)
    {
        if ($request->ajax()) {
            $data = AppActivity::orderBy('created_at', 'DESC')->get();
            foreach ($data as $d) {
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
            $data = Store::with('user', 'module')->where('package_id', '<>', 1)->orderby('created_at', 'DESC')->get();

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
