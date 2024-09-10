<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifications extends Model
{
    use HasFactory;

    protected $table = 'verifications';

    protected $fillable = [
        'user_id',
        'upi_id',
        'account_holder',
        'bank_name',
        'account_no',
        'ifsc',
    ];
}
