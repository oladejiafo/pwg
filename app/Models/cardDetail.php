<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cardDetail extends Model
{
    use HasFactory;

    protected $table = 'card_details';
    protected $fillable = [
            'client_id',
            'application_id',
            'card_number',
            'card_holder_name',
            'month',
            'year',
            'cvv'
        ];
}
