<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdralStatus extends Model
{
    use HasFactory;

    protected $table = 'withdral_statuses';

    protected $fillable = [
       'name',
    ];
}
