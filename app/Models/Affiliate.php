<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = [
        'first_name',
        'email',
        'phone_number',
        'password',
    ];
}
