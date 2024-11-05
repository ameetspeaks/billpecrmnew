<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $table = 'customer_orders';

    protected $fillable= [
        'user_id',
        'store_id',
        'address_id',
        'product_details',
        'amount',
        'coupan_amount',
        'any_other_fee',
        'tip',
        'total_amount',
        'payment_mode',
        'instruction',
        'order_status',
        'merchant_order_status',
        'd_p_order_status',
        'unique_id',
        'combined_id',
        'order_number',
        'deliveryboy_id',
        'transection_id',
        'store_to_customer_distance',
        'dp_to_store_distance',
        'order_expires_at',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id')->withCount('order');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->with('user')->withCount('customer_orders');
    }

    public function address()
    {
        return $this->belongsTo(MultipleAddress::class, 'address_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status');
    }



    public function merchantOrderStatus()
    {
        return $this->belongsTo(MerchantOrderStatus::class, 'merchant_order_status');
    }

    public function DPOrderStatus()
    {
        return $this->belongsTo(DPOrderStatus::class, 'd_p_order_status');
    }

    public function delivery_boy()
    {
        return $this->belongsTo(User::class, 'deliveryboy_id');
    }
}
