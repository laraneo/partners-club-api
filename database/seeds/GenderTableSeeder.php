<?php

use App\Gender;
use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Masculino' ],
            [ 'description' => 'Femenino' ],
        ];
        foreach ($data as $element) {
            Gender::create([
                'description' => $element['description'],
            ]);
        }
    }
}
