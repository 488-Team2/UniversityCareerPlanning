<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\DegreeApiImportInfo;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DegreeImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->parseDegreeInformation();
    }

    public function findJsonValue($item, $itemKey)
    {
        $itemKeyArray = explode(".", $itemKey);
        if (count($itemKeyArray) > 1) {
            if ($this->has_string_keys($item))
                return $this->findJsonValue($item[$itemKeyArray[0]], implode(".", array_slice($itemKeyArray, 1)));
            else
                return $this->findJsonValue($item[0], implode(".", array_slice($itemKeyArray, 1)));
        } else {
            if ($this->has_string_keys($item))
                return $item[$itemKey];
            else
                return $item[0][$itemKey];
        }
    }

    public function parseDegreeInformation()
    {
        $degreeApiImportInfoEntries = DegreeApiImportInfo::all();
        $response = Http::get('https://www.keene.edu/catalog/api/programs/');
        $decoded = json_decode($response->body(), true);
        $degreeCollection = collect($decoded['data']);
        $degreeCollection->each(function ($item) use ($degreeApiImportInfoEntries) {
            $faker = Faker::create();

            //creates an associative array
            $itemArray = [];

            //For each item in $degreeApiImportInfoEntries, use findJsonValue function to assign to associative array
            $degreeApiImportInfoEntries->each(function ($entry) use ($item) {
                echo $entry->data_type;
                if ($entry == 'department_id') {
                    $itemArray[$entry] = Department::firstOrCreate([
                        'department_name' => $this->findJsonValue($item, $entry->data_label)
                    ])->id;
                }
                $itemArray[$entry->data_type] = $this->findJsonValue($item, $entry->data_label);
            });


            $itemArray['degree_code'] = ['R', 'I', 'A', 'S', 'E', 'C'][array_rand(['R', 'I', 'A', 'S', 'E', 'C'])];
            Degree::create($itemArray);

            /*                            'degree_name' => $item['name'],
                            'department_id' => Department::firstOrCreate([
                            'department_name' => $item['disciplines'][0]['name'],
                        ])->id,
                            'degree_code' => ['R', 'I', 'A', 'S', 'E', 'C'][array_rand(['R', 'I', 'A', 'S', 'E', 'C'])],
                            'degree_description' => $faker->sentence,
                            'degree_type' => $item['classification']['name'],
                            'graduation_rate' => $faker->numberBetween(0, 100),
                            'job_demand' => $faker->numberBetween(0, 100),
                            'job_prospects' => $faker->jobTitle,
                            'keywords' => $item['disciplines'][0]['name']*/
        });
    }

    function has_string_keys(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
