<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AllStateJob;
use App\Http\Resources\AllStateJob as AllStateJobResource;

class AllStateJobController extends Controller
{
   
     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($stateName, $jobName)
    {
        $stateJob = AllStateJob::where('job_name', $jobName)->where('state_name', $stateName)->first();
        return new AllStateJobResource($stateJob);
    }

    public function store(Request $request)
    {
        $stateJob = AllStateJob::create([
            'state_name' => $request->get('state_name'),
            'state_code' => $request->get('state_code'),
            'job_name' => $request->get('job_name'),
            'job_code' => $request->get('job_code'),
            'salary' => $request->get('salary')
          ]);
          
        return response([
            'stateJob' => $stateJob
        ], 200);
    }
}
