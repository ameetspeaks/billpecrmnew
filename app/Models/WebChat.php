<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebChat extends Model
{
    use HasFactory;

    protected $table = 'web_chats';

    protected $fillable = [
        'sender_name',
        'sender_id',
        'reciver_id',
        'message',
        'message_type',
        'user_id',
    ];
}
