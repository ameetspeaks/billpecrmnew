<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use App\Models\NotificationHistory;
use DB;
use DataTables;

class NotificationController extends Controller
{
    public function index()
    {
        // $data = NotificationHistory::select(
        //     DB::raw('YEAR(created_at) as year'),
        //     DB::raw('MONTH(created_at) as month'),
        //     DB::raw('COUNT(*) as total_count'),
        //     DB::raw('SUM(CASE WHEN notification_status = 1 THEN 1 ELSE 0 END) as notification_delivered'),
        //     DB::raw('SUM(CASE WHEN notification_status = 0 THEN 1 ELSE 0 END) as notification_not_delivered')
        // )
        // ->groupBy('year', 'month')
        // ->orderBy('year', 'asc')
        // ->orderBy('month', 'asc')
        // ->get();

        // $chartData = $data->map(function ($item) {
        //     return [
        //         'label' => date("F", mktime(0, 0, 0, $item->month, 1)), // Convert the month number to a month name
        //     ];
        // });

        $data = NotificationHistory::select(
            'title','msg',
             DB::raw('DATE(created_at) as creation_date'),
             DB::raw('SUM(CASE WHEN notification_status = 1 THEN 1 ELSE 0 END) as notification_delivered'),
             DB::raw('SUM(CASE WHEN notification_status = 0 THEN 1 ELSE 0 END) as notification_not_delivered')
         )
         ->groupBy(DB::raw('DATE(created_at)'))
         ->orderBy('created_at', 'asc')
         ->get();


        // print_r($tableData->toarray()); die;

        return view('admin.notification.index' , compact('data'));
    }

    public function send(Request $request)
    {
        $stores = Store::all();
        $selectedPackage = $request->input('package', 'all');
        // print_r($selectedPackage); die;
        return view('admin.notification.sendNotification', compact('stores','selectedPackage'));
    }

    public function sendnotification(Request $request)
    {
        // Retrieve form inputs
        $package = $request->input('package');
        $selectedStores = $request->input('selected_stores');
        $title = $request->input('title');
        $message = $request->input('message');

        $stores = DB::table('stores');
        if ($package !== 'all') {
            $stores = $stores->where('package_id', $package === 'trial' ? 1 : 2);
        }
        if (!empty($selectedStores)) {
            $stores = $stores->whereIn('id', $selectedStores);
        }
        $stores = $stores->get()->unique('user_id')->pluck('user_id')->toarray();
        $users = User::whereIn('id',$stores)->get();

         #save image
         $image = $request->image;
         if ($image) {
             $path  = config('image.profile_image_path_view');
             $image = \App\Http\Controllers\CommonController::saveImage($image, $path, 'notification');
         }else{
             $image = null;
         }

        foreach ($users as $user) {
            $postdata = '{
                "to" : "'.$user->device_token.'",
                "notification" : {
                    "body" : "'.$message.'",
                    "title": "'.$title.'",
                    "image": "'.$image.'"
                },
                "data" : {
                    "type": "Dashboard"
                },
                }';

            // Assuming your Notification class accepts FCM tokens
            $sendNotification = \App\Helpers\Notification::send($postdata);
            $sendNotification = json_decode($sendNotification);
            $error = null;
            if($sendNotification->success == 0)
            {
                $error = $sendNotification->results[0]->error;
            }
         
            $notification_history = NotificationHistory::create([
                'whatsapp_no'          => $user->whatsapp_no,
                'msg'                  => $message,
                'title'                => $title,
                'notification_status'  => $sendNotification->success,
                'notification_error'   => $error,
            ]);
        }
        
        return redirect()->route('admin.notification')->with('message', 'Notifications sent successfully.');
    }

    public function getDatatable()
    {
        if(\request()->ajax()){
            $data = NotificationHistory::select(
                'title','msg',
                 DB::raw('DATE(created_at) as creation_date'),
                 DB::raw('SUM(CASE WHEN notification_status = 1 THEN 1 ELSE 0 END) as notification_delivered'),
                 DB::raw('SUM(CASE WHEN notification_status = 0 THEN 1 ELSE 0 END) as notification_not_delivered')
             )
             ->groupBy(DB::raw('DATE(created_at)'))
             ->orderBy('created_at', 'asc')
             ->get();
            return DataTables::of($data)
              ->make(true);
        // print_r($data); die;

        }
        return view('admin.notification.index');
    }
}
