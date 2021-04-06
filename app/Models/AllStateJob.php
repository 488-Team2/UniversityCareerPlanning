<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllStateJob extends Model
{
    use HasFactory;
    protected $table = 'allStatesJobs';
    public $timestamps = false;

    protected $fillable = [
        'state_name',
        'state_code',
        'job_name',
        'job_code',
        'salary'
    ];
}
