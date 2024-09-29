<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftTimings extends Model
{
    use HasFactory;

    protected $table = 'shift_timings';

    protected $fillable= [
        'type',
        'name',
        'from',
        'to',
        'status',
        'created_at',
        'updated_at'
    ];
}
