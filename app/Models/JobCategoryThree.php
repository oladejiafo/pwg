<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategoryThree extends Model
{
    protected $table = 'job_category_three';

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function jobCategoryTwo()
    {
        return $this->belongsTo(JobCategoryTwo::class, 'job_category_two_id', 'id');
    }

    public function jobCategoryFour()
    {
        return $this->hasMany(JobCategoryFour::class, 'job_category_three_id', 'id');
    }

    public function clientExperiences()
    {
        return $this->hasMany(ClientExperience::class, 'job_category_three_id', 'id');
    }
}
