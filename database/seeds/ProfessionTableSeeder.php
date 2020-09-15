<?php

use App\Profession;
use Illuminate\Database\Seeder;

class ProfessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Ingenieria de Sistemas' ],
            [ 'description' => 'Administrador' ],
            [ 'description' => 'Agricultor' ],
            [ 'description' => 'Asegurador' ],
            [ 'description' => 'Banquero' ],
            [ 'description' => 'Artista' ],
            [ 'description' => 'Artista Plastico' ],
            [ 'description' => 'Bionanalista' ],
            [ 'description' => 'Arquitecto' ],
        ];
        foreach ($data as $element) {
            Profession::create([
                'description' => $element['description'],
            ]);
        }
    }
}
