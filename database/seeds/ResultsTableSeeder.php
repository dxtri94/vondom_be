<?php

use Illuminate\Database\Seeder;
use App\Models\Result;
class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Result::create(array(
            'user_id' => 4,
            'challenge_id' => 8,
            'type' => '',
            'link' => '',
            'status' => config('constants.RESULT_STATUS.WON'),
            'is_positive' => false,
            'reason' => ''
        ));

    }
}
