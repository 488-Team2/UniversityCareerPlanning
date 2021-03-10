<?php

namespace App\Http\Controllers;

use App\Models\CareerSurveyQuestion;
use Illuminate\Http\Request;

class CareerSurveyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Http\Resources\CareerSurveyQuestion::collection(\App\Models\CareerSurveyQuestion::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \App\Http\Resources\CareerSurveyQuestion
     */
    public function show($id): \App\Http\Resources\CareerSurveyQuestion
    {
        return new \App\Http\Resources\CareerSurveyQuestion(\App\Models\CareerSurveyQuestion::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\CareerSurveyQuestion $careerSurveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(CareerSurveyQuestion $careerSurveyQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CareerSurveyQuestion $careerSurveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CareerSurveyQuestion $careerSurveyQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CareerSurveyQuestion $careerSurveyQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareerSurveyQuestion $careerSurveyQuestion)
    {
        //
    }
}
