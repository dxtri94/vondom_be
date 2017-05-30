<?php

use Illuminate\Database\Seeder;
use App\Models\Game;
class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::updateOrCreate(array(
            'name' => 'top game 1',
            'platform_id' => 1,
            'user_id' => 2,
            'path' => '/upload/games/game1.jpg',
            'description' => '',
            'rate' => 10,
        ));

        Game::updateOrCreate(array(
            'name' => 'top game 2',
            'platform_id' => 2,
            'user_id' => 2,
            'path' => '/upload/games/game2.jpg',
            'description' => '',
            'rate' => 7,
        ));

        Game::updateOrCreate(array(
            'name' => 'top game 3',
            'platform_id' => 3,
            'user_id' => 2,
            'path' => '/upload/games/game3.jpg',
            'description' => '',
            'rate' => 8,
        ));

        Game::updateOrCreate(array(
            'name' => 'top game 4',
            'platform_id' => 3,
            'user_id' => 2,
            'path' => '/upload/games/game4.jpg',
            'description' => '',
            'rate' => 9,
        ));
        Game::updateOrCreate(array(
            'name' => 'Call of duty',
            'platform_id' => 1,
            'user_id' => 2,
            'path' => '/upload/games/game5.jpg',
            'description' => '',
            'rate' => 9,
        ));
    }
}
