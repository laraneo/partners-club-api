<?php

use App\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Entrada 1', 'status' => 1 ],
            [ 'description' => 'Salida 1', 'status' => 1 ],
        ];
        foreach ($data as $element) {
            Location::create([
                'description' => $element['description'],
                'status' => $element['status'],
            ]);
        }
    }
}
