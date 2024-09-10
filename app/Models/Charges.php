<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;

    protected $table = 'charges';

    protected $fillable= [
       'zone_id',
       'subzone_id',
       'name',
       'amount',
       'minimum_cart_value',
       'start_time',
       'end_time',
       'occurring',
       'image',
       'status',
    ];
}
