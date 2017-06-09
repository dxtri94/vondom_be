<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role_id' => config('constants.ROLEs.ADMIN')
            ));

    }
}
