<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'question_id',
        'response_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function careerSurveyQuestion()
    {
        return $this->belongsTo(CareerSurveyQuestion::class);
    }

}
