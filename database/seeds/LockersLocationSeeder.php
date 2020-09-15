<?php

use App\LockerLocation;
use Illuminate\Database\Seeder;

class LockersLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Ubicacion 1' ],
            [ 'description' => 'Ubicacion 2' ],
            [ 'description' => 'Ubicacion 3' ],
            [ 'description' => 'Ubicacion 4' ],
            [ 'description' => 'Ubicacion 5' ],
            [ 'description' => 'Ubicacion 6' ],
        ];
        foreach ($data as $element) {
            LockerLocation::create([
                'description' => $element['description'],
            ]);
        }
    }
}
