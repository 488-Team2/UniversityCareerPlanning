<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\Http\Requests;
use App\Models\Degree;
use App\Http\Resources\Degree as DegreeResource;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       //get degress
       $degrees = Degree::orderBy('created_at', 'desc')->paginate(10);

       //return collection of degrees as a resource
       return DegreeResource::collection($degrees);
    }

    public function search($keyword)
    {
        
        $degrees = Degree::where("degree_name", "like", "%".$keyword."%")
                    ->orwhere("degree_description", "like", "%".$keyword."%")->get();

        return DegreeResource::collection($degrees);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $degree = $request->isMethod('put') ? Degree::findOrFail($request->degree_id) : new Degree;

        $degree->id = $request ->input('degree_id');
        $degree->degree_name = $request ->input('degree_name');
        $degree->degree_description = $request ->input('degree_description');
        $degree->department_id = $request ->input('department_id');
        $degree->graduation_rate = $request ->input('graduation_rate');
        $degree->job_demand = $request ->input('job_demand');

        if($degree->save()) {
            return new DegreeResource($degree);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get degree
        $degree = Degree::findOrFail($id);

        //return single degree as a resouce
        return new DegreeResource($degree);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get degree
        $degree = Degree::findOrFail($id);

        if($degree->delete()){
             return new DegreeResource($degree);
        }
    }


}
