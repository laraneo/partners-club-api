<?php

use App\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Cargo Automatico (Mensual)' ],
            [ 'description' => 'Deposito en cuenta' ],
            [ 'description' => 'Oficinas del club (Mensual)' ],
        ];
        foreach ($data as $element) {
            PaymentMethod::create([
                'description' => $element['description'],
            ]);
        }
    }
}
