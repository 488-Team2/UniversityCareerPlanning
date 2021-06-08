<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = [
        'degree_name',
        'degree_type',
        'degree_description',
        'degree_code',
        'department_id',
        'graduation_rate',
        'job_prospects',
        'keywords',
        'program_type',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function getColumns(): array
    {
        $columns = $this->getFillable();
        return $columns;
    }
}
