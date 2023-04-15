<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NetworkPartnerCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'max_usage',
        'agent_commission',
        'partner_commission',
        'agent_code',
        'updated_at',
        'created_at',
    ];
}
