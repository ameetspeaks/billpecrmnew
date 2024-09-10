<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    use HasFactory;

    protected $table = 'notification_histories';

    protected $fillable = [
        'store_id',
        'whatsapp_no',
        'msg',
        'title',
        'notification_status',
        'notification_error',
    ];
}
