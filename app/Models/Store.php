<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $fillable = [
        'zone_id',
        'user_id',
        'store_id',
        'store_type',
        'module_id',
        'store_image',
        'shop_name',
        'address',
        'latitude',
        'longitude',
        'pincode',
        'city',
        'gst',
        'owner_name',
        'package_id',
        'package_active_date',
        'package_valid_date',
        'package_amount',
        'package_status',
        'store_status',
        'store_open_time',
        'store_close_time',
        'store_days',
        'last_homepage_video_datetime',
        'featured',
        'title',
        'description',
        'rating',
        'online_status',
        'store_wallet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function store_id()
    {
        return $this->belongsTo(Module::class, 'store_id');
    }
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function type()
    {
        return $this->belongsTo(StoreType::class, 'store_type');
    }

    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function billHistory()
    {
        return $this->hasMany(BillDetail::class, 'store_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'store_id');
    }

    public function customer_orders()
    {
        return $this->hasMany(CustomerOrder::class, 'store_id');
    }
    public function homeDeliveryDetail(): HasOne
    {
        return $this->hasOne(HomeDeliveryDetail::class, 'store_id');
    }
}
