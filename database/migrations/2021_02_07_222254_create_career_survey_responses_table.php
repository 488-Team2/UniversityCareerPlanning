<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_survey_responses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('session_id');
            $table->integer('career_survey_question_id');
            $table->foreign('career_survey_question_id')->references('id')->on('career_survey_questions');
            $table->integer('response_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_survey_responses');
    }
}
