<?php

use App\RelationType;
use Illuminate\Database\Seeder;

class RelationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'OTROS', 'inverse_relation' => 'OTROS' ],
            [ 'description' => 'HIJO/HIJA', 'inverse_relation' => 'PADRE/MADRE' ],
            [ 'description' => 'CONYUGE', 'inverse_relation' => 'CONYUGE' ],
            [ 'description' => 'PADRE/MADRE', 'inverse_relation' => 'HIJO/HIJA' ],
            [ 'description' => 'NIETO/NIETA', 'inverse_relation' => 'ABUELO/ABUELA' ],
            [ 'description' => 'SUEGRO/SUEGRA', 'inverse_relation' => 'YERNO/NUERA' ],
        ];
        foreach ($data as $element) {
            RelationType::create([
                'description' => $element['description'],
                'inverse_relation' => $element['inverse_relation'],
            ]);
        }
    }
}
