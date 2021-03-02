<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Http\Requests;
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
    public function display(Request $request)
    {

       return Degree::orderBy('created_at', 'desc')->paginate(10);
    }


    public function search($keyword)
    {

        $degrees = Degree::where("degree_name", "like", "%".$keyword."%")
                    ->orwhere("degree_description", "like", "%".$keyword."%")->get();

        return DegreeResource::collection($degrees);
    }


    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $this->validate($request, [
            'degree_name' => 'required|min:5',
            'degree_description' => 'required|min:5',
            'department_id' => 'required|numeric|gt:0',
            'graduation_rate' => 'required|numeric|gt:0',
            'job_demand' => 'required|numeric|gt:0'
        ]);
        $degree = Degree::create([
            'degree_name' => $request->get('degree_name'),
            'degree_description' => $request->get('degree_description'),
            'department_id' => $request->get('department_id'),
            'graduation_rate' => $request->get('graduation_rate'),
            'job_demand' => $request->get('job_demand'),
          ]);
        return response([
            'degree' => $degree
        ], 200);
       

    }


    public function show($id)
    {
        //get degree
        $degree = Degree::findOrFail($id);

        //return single degree as a resouce
        return new DegreeResource($degree);
    }
    public function showAll()
    {
      return DegreeResource::collection(Degree::all());
    }
  

    public function edit($id)
    {
        $degree = Degree::find($id);
        return response()->json($degree);

    }

  
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'degree_name' => 'required|min:5',
            'degree_description' => 'required|min:5',
            'department_id' => 'required|numeric|gt:0',
            'graduation_rate' => 'required|numeric|gt:0',
            'job_demand' => 'required|numeric|gt:0'
        ]);
        $degree = Degree::find($id);

        $degree->degree_name = $request->input('degree_name');
        $degree->degree_description = $request->input('degree_description');
        $degree->department_id = $request ->input('department_id');
        $degree->graduation_rate = $request ->input('graduation_rate');
        $degree->job_demand = $request ->input('job_demand');

        $degree->save();
        return response([
            'degree' => $degree
        ], 200);
    }


    public function destroy($id)
    {

        $degree = Degree::find($id);
        $degree->delete();
        return response([
            'result' => 'success'
        ], 200);
    }


}
