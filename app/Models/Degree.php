<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree_name',
        'degree_description',
        'degree_code',
        'department_id',
        'graduation_rate',
        'job_demand',
        'job_prospects',
        'keywords'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
