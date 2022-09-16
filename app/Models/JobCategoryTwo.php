<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategoryTwo extends Model
{
    protected $table = 'job_category_two';

    protected $fillable = [
        'job_category_one_id',
        'name',
        'created_by',
    ];

    public function jobCategoryOne()
    {
        return $this->belongsTo(JobCategoryOne::class, 'job_category_one_id', 'id');
    }

    public function jobCategoryThree()
    {
        return $this->hasMany(JobCategoryThree::class, 'job_category_two_id', 'id');
    }

    public function clientExperiences()
    {
        return $this->hasMany(ClientExperience::class, 'job_category_two_id', 'id');
    }
}
