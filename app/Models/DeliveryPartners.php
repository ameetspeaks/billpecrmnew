<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPartners extends Model
{
    use HasFactory;

    protected $table = 'delivery_partners';

    protected $fillable= [
        'user_id',
        'refer_id',
        'work_shift_id',
        'aadhar_front_img',
        'aadhar_back_img',
        'pan_number',
        'pan_front_img',
        'dl_front_img',
        'dl_back_img',
        'rc_number',
        'rc_front_img',
        'rc_back_img',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc',
        'latitude',
        'longitude',
        'on_going_order',
        'current_work_status',
        'account_status',
        'created_at',
        'updated_at'
    ];

    public function delivery_boy_detail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function shift_detail()
    {
        return $this->belongsTo(ShiftTimings::class, 'work_shift_id');
    }
//    user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
