<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddtoCart extends Model
{
    use HasFactory;

    protected $table = 'addto_carts';

    protected $fillable= [
        'user_id',
        'store_id',
        'product_id',
        'product_qty',
        'product_amount',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
