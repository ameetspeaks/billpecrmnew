<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\webappchat;
use App\Models\User;
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

class ChatController extends Controller
{
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
        $users = User::with('last_chat')->whereIn('id',$webchatsids)->orderBy('id',"desc")->get();

        return response()->json(['users' => $users]);

    }

    public function getchat(Request $request)
    {
        $usersAndChat = User::with('chats')->where('id',$request->id)->first();

        return response()->json(['usersAndChat' => $usersAndChat]);
    }
}
