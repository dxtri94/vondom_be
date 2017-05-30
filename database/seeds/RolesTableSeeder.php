<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $roles = array(
            array(
                'id' => config('constants.ROLEs.SUPER_ADMIN'),
                'role' => 'Super Administrator'
            ),
            array(
                'id' => config('constants.ROLEs.ADMIN'),
                'role' => 'Administrator'
            ),
            array(
                'id' => config('constants.ROLEs.USER'),
                'role' => 'Normally User'
            )
        );

        foreach ($roles as $index => $role) {
            Role::updateOrCreate($role);
        }
    }
}
