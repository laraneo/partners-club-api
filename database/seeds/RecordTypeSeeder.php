<?php

use App\RecordType;
use Illuminate\Database\Seeder;

class RecordTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Utilizacion de Puestos', 'days' => 30, 'blocked' => 0 ],
            [ 'description' => 'Daños contra la propiedad', 'days' => 90, 'blocked' => 0 ],
            [ 'description' => 'Incumplimiento de Normas', 'days' => 120, 'blocked' => 0 ],
            [ 'description' => 'Exceso de velovidad', 'days' => 90, 'blocked' => 0 ],
            [ 'description' => 'Problemas con empleados', 'days' => 90, 'blocked' => 0 ],
            [ 'description' => 'Problemas con socios', 'days' => 90, 'blocked' => 0 ],
            [ 'description' => 'Incumplimiento de eventos', 'days' => 90, 'blocked' => 0 ],
        ];
        foreach ($data as $element) {
            RecordType::create([
                'description' => $element['description'],
                'days' => $element['days'],
                'blocked' => $element['blocked'],
            ]);
        }
    }
}
