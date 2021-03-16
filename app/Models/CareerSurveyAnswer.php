<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CareerSurveyAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer_text',
        'question_id'
    ];

    public function careerSurveyResponses(): HasOne
    {
        return $this->hasOne(CareerSurveyQuestion::class);
    }
}
