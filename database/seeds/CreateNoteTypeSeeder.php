<?php

use App\NoteType;
use Illuminate\Database\Seeder;

class CreateNoteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Tipo Nota Prueba 1' ],
            [ 'description' => 'Tipo Nota Prueba 2' ],
            [ 'description' => 'Tipo Nota Prueba 3' ],
        ];
        foreach ($data as $element) {
            NoteType::create([
                'description' => $element['description'],
            ]);
        }
    }
}
