<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartnerEarnings extends Model
{
    use HasFactory;

    protected $table = 'delivery_partner_earnings';

    protected $fillable= [
        'user_id',
        'order_id',
        'amount',
        'created_at',
        'updated_at'
    ];

    public function user_detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function customer_orders_detail()
    {
        return $this->belongsTo(CustomerOrder::class, 'order_id');
    }
}
