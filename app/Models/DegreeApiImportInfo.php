<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeApiImportInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_type',
        'data_label'
    ];
}
