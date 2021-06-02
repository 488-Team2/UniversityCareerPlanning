<?php

namespace App\Http\Controllers;

use App\Http\Resources\DegreeApiImportInfoResource;
use App\Models\Degree;
use App\Models\DegreeApiImportInfo;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DegreeApiImportInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $attributes = DegreeApiImportInfo::all();

        return DegreeApiImportInfoResource::collection($attributes);
    }

    /**
     * Stores API info in the database. Each 'data_type' stores a 'data_label' corresponding to the
     * item label in the admin user's API
     * Will be used later when importing degree information from the college's API
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $this->validate($request, [
            'submittedAttributes' => 'array',
            'submittedAttributes.*.*' => 'string|required'
        ],
            [
                'string' => 'Error: attribute must be a string',
                'required' => 'Error: attribute cannot be empty'
            ]
        );
        $input = $request->all();
        $attributes = $input['submittedAttributes'];
        foreach ($attributes as $item) {
            DegreeApiImportInfo::updateOrCreate(
                ['data_type' => $item['itemName']],
                ['data_label' => $item['itemValue']]
            );
        }
        return response([
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return Response
     */
    public function show(DegreeApiImportInfo $degreeApiImportInfo): Response
    {
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'itemName' => 'string|required',
        ],
            [
                'string' => 'Error: attribute must be a string'
            ]
        );
        $input = $request->all();
        $attribute = $input['itemName'];
        DegreeApiImportInfo::where('data_type', $attribute
        )->delete();

        return response([
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return Response
     */
    public function update(Request $request, DegreeApiImportInfo $degreeApiImportInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DegreeApiImportInfo $degreeApiImportInfo
     * @return Response
     */
    public function destroy(DegreeApiImportInfo $degreeApiImportInfo): Response
    {
        //
    }

    public function runImport()
    {
        $this->parseDegreeInformation();
    }

    public function setUrl($url)
    {

    }

    public function findJsonValue($item, $itemKey)
    {
        $itemKeyArray = explode(".", $itemKey);
        if (count($itemKeyArray) > 1) {
            if (Arr::isAssoc($item)) {
                return $this->findJsonValue($item[$itemKeyArray[0]], implode(".", array_slice($itemKeyArray, 1)));
            } else {
                return $this->findJsonValue($item[0], implode(".", array_slice($itemKeyArray, 1)));
            }
        } else {
            if (Arr::isAssoc($item)) {
                return $item[$itemKey];
            } else {
                return $item[0][$itemKey];
            }
        }
    }

    public function parseDegreeInformation()
    {
        $degreeApiImportInfoEntries = DegreeApiImportInfo::all();
        $response = Http::get(DegreeApiImportInfo::where('data_type', 'apiURL')->first()->data_label);
        $decoded = json_decode($response->body(), true);
        $degreeCollection = collect($decoded['data']);
        $degreeCollection->each(function ($item) use ($degreeApiImportInfoEntries) {
            $faker = Faker::create();

            //creates an associative array
            $itemArray = [];

            //For each item in $degreeApiImportInfoEntries, use findJsonValue function to assign to associative array
            $degreeApiImportInfoEntries->each(function ($entry) use ($item, &$itemArray) {
                if ($entry->data_type != 'apiURL') {
                    if ($entry->data_type == 'department_id') {
                        $itemArray['department_id'] = Department::firstOrCreate([
                            'department_name' => $this->findJsonValue($item, $entry->data_label)
                        ])->id;
                    } else {
                        $itemArray[$entry->data_type] = $this->findJsonValue($item, $entry->data_label);
                    }
                }
            });

            $itemArray['degree_code'] = $this->classifyDegreeCodes($itemArray['degree_name']);
            $itemArray['graduation_rate'] = $faker->numberBetween(0, 100);
            $itemArray['job_demand'] = $faker->numberBetween(0, 100);
            Degree::create($itemArray)->save();
        });

        return response([
        ], 200);
    }

    /**
     * Uses k nearest-neighbor classifier to produce the top three Holland codes for a given
     * Degree name. Uses data from previously classified degree names and their associated codes
     *
     * @param $degree
     *
     * @return String
     */
    public function classifyDegreeCodes($degree): string
    {
        $hollandDegreeFile = Storage::get('holland-codes.csv');

        $trainingDegrees = collect();
        $hollandDegreeCollection = collect(explode("\n", $hollandDegreeFile));
        $hollandDegreeCollection->each(function ($item) use ($trainingDegrees) {
            if ($item !== NULL && strlen($item) > 0) {
                $itemArray = preg_split("~,(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)~", $item);
                $trainingDegrees->add($itemArray);
            }
        });

        $neighbors = collect();
        $largestNeighborIndex = 0;
        $smallestNeighborIndex = 0;

        $trainingDegrees->each(function ($trainingDegree) use ($degree, &$neighbors, &$largestNeighborIndex, &$smallestNeighborIndex) {
            $distance = levenshtein($degree, $trainingDegree[0]);

            if ($neighbors->count() < 3) {
                $neighbors->add($trainingDegree);
                $largestNeighborIndex = $neighbors->search($trainingDegree);
            } else if ($distance < levenshtein($degree, $neighbors[$largestNeighborIndex][0])) {
                $neighbors->splice($largestNeighborIndex, 1);
                $neighbors->add($trainingDegree);
                $largestNeighborIndex = $neighbors->search($trainingDegree);
            }
            $neighbors->each(function ($neighbor) use ($degree, &$neighbors, &$largestNeighborIndex, &$smallestNeighborIndex) {
                if (levenshtein($degree, $neighbor[0]) > levenshtein($degree, $neighbors->get($largestNeighborIndex)[0])) {
                    $largestNeighborIndex = $neighbors->search($neighbor);
                }
                if (levenshtein($degree, $neighbor[0]) < levenshtein($degree, $neighbors[$smallestNeighborIndex][0])) {
                    $smallestNeighborIndex = $neighbors->search($neighbor);
                }
            });
        });

        return $neighbors[$smallestNeighborIndex][1];
    }
}
