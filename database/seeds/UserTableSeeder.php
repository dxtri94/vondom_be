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
        User::delete();

        $users = array(
            array(
                'username' => 'sup_admin',
                'first_name' => 'Supper',
                'surname' => 'Administrator',
                'email' => 'sup_admin@mail.com',
                'password' => Hash::make('12345678'),
                'role_id' => config('constants.ROLEs.SUPER_ADMIN'),
                'location_id' => 1
            ),
            array(
                'username' => 'admin',
                'first_name' => 'Admin',
                'surname' => 'Administrator',
                'email' => 'admin@mail.com',
                'password' => Hash::make('12345678'),
                'role_id' => config('constants.ROLEs.ADMIN'),
                'location_id' => 1
            ),
            array(
                'username' => 'test_user',
                'first_name' => 'Test',
                'surname' => 'User',
                'email' => 'test@mail.com',
                'password' => Hash::make('12345678'),
                'role_id' => config('constants.ROLEs.USER'),
                'location_id' => 1
            )
        );

        foreach ($users as $index => $user) {
            $user['id'] = $index + 1;
            User::updateOrCreate($user);
        }
        User::updateOrCreate(array(
            'username' => 'admin2',
            'first_name' => 'Admin2',
            'surname' => 'Admin2',
            'email' => 'admin2@mail.com',
            'password' => Hash::make('12345678'),
            'role_id' => config('constants.ROLEs.ADMIN'),
            'location_id' => 1
        ));
    }
}
