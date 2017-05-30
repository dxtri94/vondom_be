<?php

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use Carbon\Carbon;
class ChallengeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Challenge::create(array(
            'user_id' => 194,
            'opponent_id' => 187,
            'game_id' => 1,
            'amount' => 5.62,
            'description' => 'test',
            'user_status' => 1,
            'opponent_status' => 1,
            'start_at' => Carbon::now(),
            'status' => config('constants.CHALLENGE_STATUS.NEW'),
            'length' => 45
        ));
        Challenge::create(array(
            'user_id' => 179,
            'opponent_id' => 194,
            'game_id' => 2,
            'amount' => 500,
            'description' => 'test',
            'user_status' => 4,
            'opponent_status' => 1,
            'start_at' => Carbon::now(),
            'status' => config('constants.CHALLENGE_STATUS.WAITING'),
            'length' => 45
        ));
        Challenge::create(array(
            'user_id' => 194,
            'opponent_id' => 177,
            'game_id' => 3,
            'amount' => 123.56,
            'description' => 'test',
            'user_status' => 4,
            'opponent_status' => 4,
            'start_at' => Carbon::now(),
            'status' => config('constants.CHALLENGE_STATUS.ACTIVATED'),
            'length' => 45
        ));
    }
}
