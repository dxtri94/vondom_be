<?php

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = realpath(__DIR__ . '/../../database/country.json');
        $countries = json_decode(file_get_contents($file_path), true);

        foreach ($countries as $index => $item) {
            Location::create(array(
                'id' => $index + 1,
                'location' => $item['name'],
                'short_name' => $item['alpha_2'],
                'region' => $item['continent'],
                'phone_code' => $item['phone'],
                'path' => $item['tld']
            ));
        }
    }
}
