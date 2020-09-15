<?php

use App\StatusPerson;
use Illuminate\Database\Seeder;

class StatusPeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Activo' ],
            [ 'description' => 'Inactivo' ],
        ];
        foreach ($data as $element) {
            StatusPerson::create([
                'description' => $element['description'],
            ]);
        }
    }
}
