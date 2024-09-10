<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillToken extends Model
{
    use HasFactory;

    protected $table = 'bill_tokens';

    protected $fillable = [
        'store_id',
        'bill_id',
        'token_no',
        'order_type',
        'order_details',
        'staff_name',
    ];
}
