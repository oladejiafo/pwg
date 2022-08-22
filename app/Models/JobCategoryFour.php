<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategoryFour extends Model
{
    protected $table = 'job_category_four';

    protected $fillable = [
        'name',
        'description',
        'example_titles',
        'main_duties',
        'employement_requirements',
        'created_by',
    ];

    public function jobCategoryThree()
    {
        return $this->belongsTo(JobCategoryThree::class, 'job_category_three_id', 'id');
    }

    public function ApplicantExperiences()
    {
        return $this->hasMany(ApplicantExperience::class, 'job_category_four_id', 'id');
    }
}
