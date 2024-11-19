<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvPath = public_path('data/Arunachal_Pradesh_data.csv'); // Correct CSV path
        $citiesData = [];
        $start_date = Carbon::parse('2023-01-01'); // Replace with the desired start date
        $end_date = Carbon::parse('2023-12-31'); // Replace with the desired end date

        if (($handle = fopen($csvPath, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Read header row

            while (($row = fgetcsv($handle)) !== FALSE) {
                try {
                    $fromDate = Carbon::parse($row[0]);
                } catch (\Exception $e) {
                    $fromDate = Carbon::parse('2023-12-31'); // Fallback date
                }

                    $cityName = $row[25]; // Assuming the city column index is 25
                    $stateName = 'Arunachal Pradesh';

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
                        'No2' => is_numeric( $row[5]) ?  $row[5] : null,
                        'NOx' => is_numeric( $row[6]) ?  $row[6] : null,
                        'NH3' => is_numeric( $row[7]) ?  $row[7] : null,
                        'SO2' => is_numeric( $row[8]) ?  $row[8] : null,
                        'CO' => is_numeric( $row[9]) ?  $row[9] : null,
                        'AT' => is_numeric( $row[21]) ?  $row[21] : null,
                        'Temp' => is_numeric( $row[25]) ?  $row[25] : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

            }

            fclose($handle);
        }
        // Insert data into the database in chunks to optimize performance
        if (!empty($citiesData)) {
            foreach (array_chunk($citiesData, 100) as $chunk) {
                City::insert($chunk);
            }
        }
    }
}
