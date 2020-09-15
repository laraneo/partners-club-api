<?php

use App\Sport;
use Illuminate\Database\Seeder;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Baseball' ],
            [ 'description' => 'Basketball' ],
            [ 'description' => 'Esgrima' ],
            [ 'description' => 'Football' ],
        ];
        foreach ($data as $element) {
            Sport::create([
                'description' => $element['description'],
            ]);
        }
    }
}
