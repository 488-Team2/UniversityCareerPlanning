<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Http\Requests;
use App\Models\Degree;
use App\Http\Resources\Degree as DegreeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

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
        $degrees = Degree::orderBy('created_at', 'desc')->paginate(9);

        //return collection of degrees as a resource
        return DegreeResource::collection($degrees);

    }

    public function display(Request $request)
    {
        return Degree::orderBy('created_at', 'desc')->paginate(6);
    }

    public function hollandCodeDegrees($codes)
    {
        $codeArray = str_split($codes);
        $degrees = collect(Degree::all()->filter(function ($degree) use ($codeArray) {
            $degreeCodes = str_split($degree->degree_code);
            return count(array_intersect($degreeCodes, $codeArray)) > 0;
        }));

        $randomDegrees = $degrees->random(min($degrees->count(), 12));
        //return collection of degrees as a resource
        return DegreeResource::collection($randomDegrees);
    }

    /**
     * Get database column names from degrees database table
     *
     * @return array
     */
    public function getDegreeColumnNames(): array
    {
        $degree = new Degree();
        return $degree->getColumns();
    }

    public function set($ids)
    {
        $idArr = explode(" ", $ids);

        $degrees = Degree::whereIn("id", $idArr)->paginate(10);

        //return collection of degrees as a resource
        return DegreeResource::collection($degrees);
    }

    public function search($keyword)
    {

        $degrees = Degree::where("degree_name", "like", "%" . $keyword . "%")
            ->orwhere("degree_description", "like", "%" . $keyword . "%")
            ->orwhere("keywords", "like", "%" . $keyword . "%")
            ->orwhere("job_prospects", "like", "%" . $keyword . "%")->paginate(10);

        return DegreeResource::collection($degrees);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'degree_name' => 'required|min:5',
            'degree_description' => 'required|min:5',
            'degree_type' => 'required|min:1',
            'degree_code' => 'required|min:1',
            'department_id' => 'required|numeric|gt:0',
            'graduation_rate' => 'required|numeric|gt:0',
            'job_prospects' => 'required|min:1'
        ]);
        $degree = Degree::create([
            'degree_name' => $request->input('degree_name'),
            'degree_description' => $request->input('degree_description'),
            'degree_type' => $request->input('degree_type'),
            'degree_code' => $request->input('degree_code'),
            'department_id' => $request->input('department_id'),
            'graduation_rate' => $request->input('graduation_rate'),
            'job_prospects' => $request->input('job_prospects')
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

        $degree = Degree::findOrFail($id);
        $degree->update($request->all());
        return response([
            'degree' => $degree
        ], 200);

    /*
        $this->validate($request, [
            'degree_name' => 'required|min:5',
            'degree_description' => 'required|min:5',
            'department_id' => 'required|numeric|gt:0',
            'graduation_rate' => 'required|numeric|gt:0',
            'job_prospects' => 'required|min:1'
        ]);
        $degree = Degree::find($id);

        $degree->degree_name = $request->input('degree_name');
        $degree->degree_description = $request->input('degree_description');
        $degree->department_id = $request ->input('department_id');
        $degree->graduation_rate = $request ->input('graduation_rate');
        $degree->job_prospects = $request->input('job_prospects');

        $degree->save();
        return response([
            'degree' => $degree
        ], 200);
    */
    }


    public function destroy($id)
    {

        $degree = Degree::find($id);
        $degree->delete();
        return response([
            'result' => 'success'
        ], 200);
    }
    public function degreeSearch(Request $request)
    {
        $search = $request->get('q');
        return Degree::where('program_type', 'like', '%'.$search.'%')->get();
    }



}
