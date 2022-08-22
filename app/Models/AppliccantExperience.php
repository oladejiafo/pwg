<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliccantExperience extends Model
{
    use HasFactory;
    protected $fillable = [
        'applicant_id',
        'job_category_one_id',
        'job_category_two_id',
        'job_category_three_id',
        'job_category_four_id',
        'created_by',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function jobCategoryOne()
    {
        return $this->belongsTo(JobCategoryOne::class, 'job_category_one_id', 'id');
    }
    public function jobCategoryTwo()
    {
        return $this->belongsTo(JobCategoryTwo::class, 'job_category_two_id', 'id');
    }
    public function jobCategoryThree()
    {
        return $this->belongsTo(JobCategoryThree::class, 'job_category_three_id', 'id');
    }
    public function jobCategoryFour()
    {
        return $this->belongsTo(JobCategoryFour::class, 'job_category_four_id', 'id');
    }

    static function filterKey(): string
    {
        return 'name';
    }
}
