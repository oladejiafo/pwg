<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_id',
        'invoice_no',
        'invoice_id',
        'currency',
        'transaction_id',
        'bank_reference_no',
        'paid_amount'
    ];
}
