<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id',
        'total_paid',
        'product_payment_id',
        'total',
        'currency_code',
        'payment_status',
        'payment_type',
        'card_type'
    ];
}
