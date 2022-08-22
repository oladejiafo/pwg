<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategoryOne extends Model
{
    protected $table = 'job_category_one';

    protected $fillable = [
        'name',
        'created_by',
    ];


    public function jobCategoryTwo()
    {
        return $this->hasMany(JobCategoryTwo::class, 'job_category_one_id', 'id');
    }

    public function ApplicantExperience()
    {
        return $this->hasMany(ApplicantExperience::class, 'job_category_one_id', 'id');
    }
}
