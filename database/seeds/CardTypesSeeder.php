<?php

use Illuminate\Database\Seeder;

use App\CardType;
class CardTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Visa' ],
            [ 'description' => 'Master Card' ],
            [ 'description' => 'American Express' ],
            [ 'description' => 'Diners Club' ],
        ];
        foreach ($data as $element) {
            CardType::create([
                'description' => $element['description'],
            ]);
        }
    }
}
