<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Venezuela', 'citizenship' => 'Venezolana' ],
            [ 'description' => 'Colombia', 'citizenship' => 'Colombiana'  ],
            [ 'description' => 'España', 'citizenship' => 'Española'  ],
        ];
        foreach ($data as $element) {
            Country::create([
                'description' => $element['description'],
                'citizenship' => $element['citizenship'],
            ]);
        }
    }
}
