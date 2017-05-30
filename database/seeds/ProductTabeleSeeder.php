<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTabeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	Product::create(array(
    		'collection_id' => 1,
    		'categories_id' => 1,
    		'name' => "iphone",
    		'description' => 'test',
    		'image' => '',
    		'detail' => ''
    	));
    }
}
