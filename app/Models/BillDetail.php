<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $table = 'bill_details';

    protected $fillable = [
        'store_id',
        'staff_id',
        'product_detail',
        'customer_name',
        'customer_number',
        'amount',
        'discount',
        'total_amount',
        'due_amount',
        'due_date',
        'payment_methord',
        'is_gst',
        'GST5',
        'GST12',
        'GST18',
        'GST28',
        'GST5BeforeAmount',
        'GST12BeforeAmount',
        'GST18BeforeAmount',
        'GST28BeforeAmount',
        'totalcessAmount',
        'totalcessBeforeAmount',
        'unique_id',
        'combined_id',
        'bill_number',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->with('user');
    }

    public function token()
    {
        return $this->belongsTo(BillToken::class, 'id', 'bill_id');
    }
}
