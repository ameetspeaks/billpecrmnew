<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table = 'stock_transfers';

    protected $fillable = [
        'product_id',
        'staff_id',
        'assign_stock',
        'assign_sub_stock'
    ];

    public function staffProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
