<?php

use App\Bank;
use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Banco Venezolano' ],
            [ 'description' => 'Banco de Venezuela' ],
            [ 'description' => 'Banesco' ],
            [ 'description' => 'Banco Occidental de Descuento' ],
            [ 'description' => 'Banco Exterior' ],
            [ 'description' => 'Banco Mercantil' ],
            [ 'description' => 'Banco del Sur' ],
            [ 'description' => 'Bancaribe' ],
            [ 'description' => 'Banco del Tesoro' ],
            [ 'description' => 'Banco Provincial' ],
        ];
        foreach ($data as $element) {
            Bank::create([
                'description' => $element['description'],
            ]);
        }
    }
}
