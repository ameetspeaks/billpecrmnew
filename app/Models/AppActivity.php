<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppActivity extends Model
{
    use HasFactory;

    protected $table = 'app_activities';

    protected $fillable = [
        'action',
        'message',
    ];
}
