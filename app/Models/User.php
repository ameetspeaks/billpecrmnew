<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'store_id',
        'name',
        'vender_for',
        'email',
        'password',
        'role_type',
        'address',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
        'label',
        'locality',
        'dob',
        'gender',
        'notes',
        'whatsapp_no',
        'image',
        'unique_id',
        'aadhar_number',
        'driving_licence',
        'status',
        'device_token',
        'referral_code',
        'total_wallet_amount',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_type');
    }

    public function last_chat()
    {
        return $this->hasone(WebChat::class, 'sender_id')->latestOfMany();
    }

    public function chats()
    {
        return $this->hasmany(WebChat::class, 'user_id');
    }

    public function order()
    {
        return $this->hasmany(CustomerOrder::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
