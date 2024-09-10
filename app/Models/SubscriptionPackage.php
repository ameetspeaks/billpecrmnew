<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $table = 'subscription_packages';

    protected $fillable= [
        'name',
        'discription',
        'image',
        'subscription_price',
        'discount_price',
        'validity_days',
        'benefits',
        'termsandcondition',
        'offer',
        'coupan_no',
        'coupan_title',
        'coupan_logo',
        'status',
    ];
}
