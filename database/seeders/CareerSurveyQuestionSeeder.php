<?php

namespace Database\Seeders;

use App\Models\CareerSurveyQuestion;
use Illuminate\Database\Seeder;

class CareerSurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionArray = collect();
        $questionArray->push(array('question_text' => 'I like to work on cars', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I like to do puzzles', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I am good at working
independently', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I like to work in teams', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I am an ambitious person,
I set goals for myself', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I like to organize things,
(files, desks/offices)', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like to build things', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I like to read about art
and music', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I like to have clear
instructions to follow', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like to try to influence
  or persuade people', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I like to do experiments', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I like to teach or train people', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I like trying to help people
  solve their problems', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I like to take care of animals', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I wouldn\'t mind working 8
  hours per day in an office', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like selling things', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I enjoy creative writing', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I enjoy science', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I am quick to take on new
  responsibilities', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I am interested in healing
  people', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I enjoy trying to figure out
  how things work', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I like putting things together
  or assembling things', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I am a creative person', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I pay attention to details', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like to do filing or typing', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like to analyze things
  (problems/situations)', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I like to play instruments
  or sing', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I enjoy learning about
  other cultures', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I would like to start my
  own business', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I like to cook', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I like acting in plays', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I am a practical person', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I like working with numbers
  or charts', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I like to get into discussions
  about issues', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I am good at keeping records
  of my work', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I like to lead', 'question_code' => 'E'));
        $questionArray->push(array('question_text' => 'I like working outdoors', 'question_code' => 'R'));
        $questionArray->push(array('question_text' => 'I would like to work in
  an office', 'question_code' => 'C'));
        $questionArray->push(array('question_text' => 'I\'m good at math', 'question_code' => 'I'));
        $questionArray->push(array('question_text' => 'I like helping people', 'question_code' => 'S'));
        $questionArray->push(array('question_text' => 'I like to draw', 'question_code' => 'A'));
        $questionArray->push(array('question_text' => 'I like to give speeches', 'question_code' => 'E'));

        $questionArray->each(function ($item) {
            CareerSurveyQuestion::create(['question_text' => $item["question_text"], 'question_code' => $item["question_code"]])->save();
        });
    }
}
