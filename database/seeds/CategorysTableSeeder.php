<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [ 'name' => 'shoes ' ],
            [ 'name' => 'clothing' ],
            [ 'name' => 'accessories' ],
        ];
        foreach ($categories as $categorie) {
            Category::create([
                'name' => $categorie['name'],
            ]);
        }
    }
}
