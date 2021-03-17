<?php

namespace App\Http\Controllers;

use App\Models\CareerSurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CareerSurveyResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): void
    {
        $user = Auth::user();
        $data = $request->all();
        foreach ($data as $item) {
            error_log($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CareerSurveyResponse $careerSurveyResponse
     * @return \Illuminate\Http\Response
     */
    public function show(CareerSurveyResponse $careerSurveyResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CareerSurveyResponse $careerSurveyResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CareerSurveyResponse $careerSurveyResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\CareerSurveyResponse $careerSurveyResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareerSurveyResponse $careerSurveyResponse)
    {
        //
    }
}
