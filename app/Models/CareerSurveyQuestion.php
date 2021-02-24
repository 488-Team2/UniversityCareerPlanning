<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CareerSurveyQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_text',
        'question_code'
    ];

    public function careerSurveyResponses(): HasMany
    {
        return $this->hasMany(CareerSurveyResponse::class);
    }

    public function careerSurveyAnswers(): HasMany
    {
        return $this->hasMany(CareerSurveyAnswer::class);
    }
}
