<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    //use SoftDeletes;

    protected $connection = 'mysql';

    public const PARTNER_TYPE = [
        'DRIVERS' => 'DRIVERS',
        'ACCOMODATIONS' => 'ACCOMODATIONS',
        'CAFE & RESTAURANTS' => 'CAFE & RESTAURANTS',
    ];

    protected $casts = [
        'contract_date' => 'date',
    ];

    protected $fillable = [
        'id',
        'partner_code',
        'partner_name',
        'partner_email',
        'phone_number',
        'partner_rep',
        'location',
        'contract_date',
        'partner_type',
        'created_at',
        'updated_at',
    ];

    public function CouponAssignments()
    {
        return $this->hasMany(promo::class, 'partner_id', 'id');
    }
}
