<?php

namespace App\Http\Controllers;

use App\Models\DegreeApiImportInfo;
use Illuminate\Http\Request;

class DegreeApiImportInfoController extends Controller
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
     * Stores API info in the database. Each 'data_type' stores a 'data_label' corresponding to the
     * item label in the admin user's API
     * Will be used later when importing degree information from the college's API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $attributes = $input['submittedAttributes'];
        foreach ($attributes as $item) {
            DegreeApiImportInfo::updateOrCreate(
                ['data_type' => $item['itemName']],
                ['data_label' => $item['itemValue']]
            );
        }
        return response([
            'data' => $attributes
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return \Illuminate\Http\Response
     */
    public function show(DegreeApiImportInfo $degreeApiImportInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DegreeApiImportInfo $degreeApiImportInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(DegreeApiImportInfo $degreeApiImportInfo)
    {
        //
    }
}
