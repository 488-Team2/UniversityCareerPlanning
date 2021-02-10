<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_name',
        'job_description',
        'job_link',
        'degree_id'
    ];

    public function degrees() {
        return $this->belongsToMany(Degree::class);
    }
}
