<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = public_path('data/Assam_data.csv'); // Replace with the correct CSV path
        $citiesData = [];

        if (($handle = fopen($csvPath, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Read header row

            while (($row = fgetcsv($handle)) !== FALSE) {
                try {
                    $fromDate = Carbon::parse($row[0]);
                } catch (\Exception $e) {
                    $fromDate = Carbon::parse('2023-12-31'); // Fallback date
                }

                $cityName = $row[23]; // Assuming city column index is 23
                $stateName = 'Assam'; // Replace or adjust based on the CSV structure

                // Create or find the state
                $state = State::firstOrCreate(['name' => $stateName]);

                // Prepare city data
                $citiesData[] = [
                    'name' => $cityName,
                    'from_date' => $fromDate,
                    'state_id' => $state->id,
                    'pm25' =>is_numeric( $row[2]) ?  $row[2] : null,
                    'pm10' =>is_numeric( $row[3]) ?  $row[3] : null,
                    'No' => is_numeric( $row[4]) ?  $row[4] : null,    // NO value
                    'No2' => is_numeric( $row[5]) ?  $row[5] : null,     // NO2 value
                    'NOx' => is_numeric( $row[6]) ?  $row[6] : null,     // NO2 value
                    'NH3' => is_numeric( $row[7]) ?  $row[7] : null,     // NO2 value
                    'SO2' => is_numeric( $row[8]) ?  $row[8] : null,     // NO2 value
                    'CO' => is_numeric( $row[9]) ?  $row[9] : null,     // NO2 value
                    'AT' => is_numeric( $row[21]) ?  $row[21] : null,     // NO2 value
                    'Temp' => is_numeric( $row[25]) ?  $row[25] : null,     // NO2 value
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            fclose($handle);
        }

        if (!empty($citiesData)) {
            foreach (array_chunk($citiesData, 100) as $chunk) {
                City::insert($chunk);
            }
        }



    }
}
