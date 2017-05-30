<?php

use Illuminate\Database\Seeder;
use App\Models\Platform;
class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Platform::updateOrCreate(array(
            'name' => 'xbox_one',
            'type' => config('constants.PLATFORMS_TYPE.CONSOLE')
        ));

        Platform::updateOrCreate(array(
            'name' => 'ps3',
            'type' => config('constants.PLATFORMS_TYPE.CONSOLE')
        ));
        Platform::updateOrCreate(array(
            'name' => 'nintendo_wii',
            'type' => config('constants.PLATFORMS_TYPE.CONSOLE')
        ));
        Platform::updateOrCreate(array(
            'name' => 'nintendo_wiiu',
            'type' => config('constants.PLATFORMS_TYPE.CONSOLE')
        ));
        Platform::updateOrCreate(array(
            'name' => 'arcade',
            'type' => config('constants.PLATFORMS_TYPE.ARCADE')
        ));
        Platform::updateOrCreate(array(
            'name' => 'smartphone_game',
            'type' => config('constants.PLATFORMS_TYPE.MOBILE')
        ));
    }
}
