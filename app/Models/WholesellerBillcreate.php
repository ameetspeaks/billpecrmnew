<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholesellerBillcreate extends Model
{
    use HasFactory;

    protected $table = 'wholeseller_billcreates';

    protected $fillable = [
        'store_id',
        'product_detail',
        'wholeseller_name',
        'wholeseller_number',
        'amount',
        'discount',
        'total_amount',
        'due_amount',
        'due_date',
        'payment_methord',
        'unique_id',
        'combined_id',
        'bill_number',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->with('user');
    }
}
