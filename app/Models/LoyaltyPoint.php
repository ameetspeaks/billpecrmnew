<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $table = 'loyalty_points';

    protected $fillable = [
        'modules_id',
        'one_INR_point_amount',
        'min_point_per_order',
        'max_point_to_convert',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'modules_id');
    }
}
