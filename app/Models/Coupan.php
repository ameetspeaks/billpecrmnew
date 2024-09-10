<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupan extends Model
{
    use HasFactory;

    protected $table = 'coupans';

    protected $fillable = [

        'name',
        'code',
        'discount',
        'discountType',
        'start_date',
        'end_date',
        'package_type',
        'minimum_purchase',
        'store_id',
    ];
}
