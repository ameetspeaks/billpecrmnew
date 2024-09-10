<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangePackageSubscription extends Model
{
    use HasFactory;

    protected $table = 'change_package_subscriptions';

    protected $fillable = [
        'store_id',
        'last_package',
        'last_package_price',
        'last_package_date',
        'new_package',
        'new_package_price',
        'new_package_date',
    ];
}
