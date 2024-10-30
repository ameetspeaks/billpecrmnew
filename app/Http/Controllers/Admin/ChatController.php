<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebChat;
use App\Services\FirebaseService;
use App\Traits\FireBaseNotification;
use App\Traits\NotifiesUsers;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function sendNotification(Request $request)
    {
        //        $deviceToken = $request->input('device_token');
        $deviceToken = 'dljxvzIVQ9q5QOB92ZaMU1:APA91bFGGZg1n_riDIs9k6HiHP_JSxf_SoVOf-kQKBY_kukVE30vYwQx-A2Tb-sEXOx27k87vb4XKA9rZER0YH94iUR6Eag0Q8Q-APmfyeqq1dhjYP9Rdtk';
        $title = 'New Message';
        $body = 'You have received a new message';
        $data = [
            'event_type' => 'chat',
            'key' => 'value'
        ];

        $firebaseService = new FirebaseService();
        $response = $firebaseService->sendNotification($deviceToken, $title, $body, $data);
        return response()->json(['success' => true, 'response' => $response]);
    }

    public function chat()
    {
        // $webchatsids = WebChat::where('sender_id', '<>', 1)->get()->unique('sender_id')->pluck('sender_id');
        // $users = User::with('last_chat')->whereIn('id',$webchatsids)->get();
        // // print_R($users->toarray()); die;

        return view('admin.chat.index');
    }

    public function chatUsers()
    {
        $webchatsids = WebChat::where('sender_id', '<>', 1)->get()->unique('sender_id')->pluck('sender_id');
        $users = User::with('last_chat')->whereIn('id', $webchatsids)->orderBy('id', "desc")->get();

        return response()->json(['users' => $users]);

    }

    public function getchat(Request $request)
    {
        $usersAndChat = User::with('chats')->where('id', $request->id)->first();

        return response()->json(['usersAndChat' => $usersAndChat]);
    }
}
