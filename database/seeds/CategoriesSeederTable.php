<?php

use Illuminate\Database\Seeder;
use App\Models\Categories;
class CategoriesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Categories::Create(array(
            'name' => 'phone'
        ));
        Categories::Create(array(
            'name' => 'tablet'
        ));
    }
}
