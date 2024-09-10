<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCoupan extends Model
{
    use HasFactory;

    protected $table = 'customer_coupans';

    protected $fillable= [
       'zone_id',
       'subzone_id',
       'store_id',
       'module_id',
       'category_id',
       'image',
       'title',
       'sub_heading',
       'discount',
       'discountType',
       'start_date',
       'end_date',
       'coupan_code',
       'maximum_discount_amount',
       'minimum_purchase',
    ];
}
