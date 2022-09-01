<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrenDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'first_name',
        'middle_name',
        'surname',
        'dob',
        'gender'
    ];
}
