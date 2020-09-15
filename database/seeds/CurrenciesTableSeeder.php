<?php

use App\Currency;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Dolar', 'unicode' => '\u0024' ],
            [ 'description' => 'Euro', 'unicode' => '\u20A0' ],
            [ 'description' => 'Bitcoin', 'unicode' => '\u20BF' ],
        ];
        foreach ($data as $element) {
            Currency::create([
                'description' => $element['description'],
                'unicode' => $element['unicode'],
            ]);
        }
    }
}
