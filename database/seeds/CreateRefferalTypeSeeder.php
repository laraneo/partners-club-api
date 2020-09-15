<?php

use App\RefferalType;
use Illuminate\Database\Seeder;

class CreateRefferalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'PARTNER' ],
            [ 'description' => 'LOCALCLUB' ],
            [ 'description' => 'INTERNATIONALCLUB' ],
            [ 'description' => 'CREDITCARD' ],
            [ 'description' => 'BANKREFERRAL' ],
            [ 'description' => 'COMMERCIALREFERRAL' ],
            [ 'description' => 'PARTNERSIGNED' ],
            [ 'description' => 'PARNERGUARANTOR' ],
            [ 'description' => 'PARTNERRESPONSIBLE' ],
        ];
        foreach ($data as $element) {
            RefferalType::create([
                'description' => $element['description'],
            ]);
        }
    }
}
