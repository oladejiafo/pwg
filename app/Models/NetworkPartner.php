<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NetworkPartner extends Model
{
    use HasFactory;

    protected $table = 'network_partner';

    protected $fillable = [
        'client_id',
        'partner_code',
        'partner_type',
        'partner_name',
        'payment_method',
        'bank_name',
        'bank_iban_number',
        'bank_swift_code',
        'partner_location',
        'partner_phone_number',
        'partner_email',
        'partner_address',
        'created_by',
        'partner_city'
    ];
}
