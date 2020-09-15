<?php

use Illuminate\Database\Seeder;
use App\Product;
use Faker\Generator as Faker;

class ProductTableSeeder extends Seeder
{
    public function __construct(Faker $faker) 
    {
        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
	    	Product::create([
	            'name' => str_random(15),
	            'price' => 100,
	            'description' => $this->faker->text,
	            'photo' => 'product-empty.png',
	            'categories_id' => 1,
	            'user_id' => 1,
	        ]);
    	}
    }
}
