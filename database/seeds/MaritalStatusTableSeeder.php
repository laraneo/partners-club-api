<?php

use App\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Casado' ],
            [ 'description' => 'Soltero' ],
        ];
        foreach ($data as $element) {
            MaritalStatus::create([
                'description' => $element['description'],
            ]);
        }
    }
}
