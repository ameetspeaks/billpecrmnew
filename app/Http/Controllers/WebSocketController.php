<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\webappchat;
use App\Models\WebChat;
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

class WebSocketController extends Controller
{
    public function UserSendChat()
    {
       $user =  Auth::user();
       $chats = WebChat::where('user_id', $user->id)->get();

       return view('UserSendChat', compact('chats'));
    }

    public function eventfire(Request $request)
    {
        $type = 'user';
        if(Auth::user()->role_type == 1)
        {
            $type = 'admin';
        }

        $user_id = 1;
        $chatUserid = Auth::user()->id;

        if(isset($request->user_id)){
            $user_id = $request->user_id;
            $chatUserid = $request->user_id;
        }


        $data = WebChat::create([
            'sender_name' => Auth::user()->name,
            'sender_id'   => Auth::user()->id,
            'reciver_id'  => $user_id,
            'message'     => $request->chatMsg,
            'message_type'=> $type,
            'user_id'     => $chatUserid,
        ]);
        event(new webappchat($data));
    }
}
