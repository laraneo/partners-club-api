<?php

use App\Nacionality;
use Illuminate\Database\Seeder;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Venezolana' ],
            [ 'description' => 'Colombiana' ],
            [ 'description' => 'Ecuatoriana' ],
            [ 'description' => 'Asegurador' ],
        ];
        foreach ($data as $element) {
            Nacionality::create([
                'description' => $element['description'],
            ]);
        }
    }
}
