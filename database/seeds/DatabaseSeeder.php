<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RolesTableSeeder::class);
        //$this->call(LocationsTableSeeder::class);
        //$this->call(UserTableSeeder::class);
        //$this->call(PlatformsTableSeeder::class);
        //$this->call(GamesTableSeeder::class);
        //$this->call(NewsletterTableSeeder::class);
        //$this->call(ChallengeTableSeeder::class);
        //$this->call(CategoriesSeederTable::class);
        $this->call(ProductTabeleSeeder::class);
    }
}
