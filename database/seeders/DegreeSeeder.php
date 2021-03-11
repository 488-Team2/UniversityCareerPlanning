<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use  Illuminate\Http\Client\Response;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://www.keene.edu/catalog/api/programs/');
        $decoded = json_decode($response->body(), true);
        $degreeCollection = collect($decoded['data']);
        $degreeCollection->each(function ($item) {
            echo $item['name'] . " | ";
        });
    }
}
