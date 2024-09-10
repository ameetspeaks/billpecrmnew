<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use HasFactory;

    protected $table = 'sub_zones';

    protected $fillable = [
        'zone_id',
        'name',
        'store_id',
        'status',
    ];
}
