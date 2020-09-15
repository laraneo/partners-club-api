<?php

use App\ShareType;
use Illuminate\Database\Seeder;

class ShareTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Propietario', 'code' => 'P' ],
            [ 'description' => 'Familiar', 'code' => 'F' ],
            [ 'description' => 'Honorario', 'code' => 'H' ],
        ];
        foreach ($data as $element) {
            ShareType::create([
                'description' => $element['description'],
                'code' => $element['code'],
            ]);
        }
    }
}
