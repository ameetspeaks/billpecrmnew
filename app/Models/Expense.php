<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'store_id',
        'expense_category_id',
        'expense_name',
        'total_amount',
        'payment_mode',
        'expense_bill',
        'notes',
    ];
}
