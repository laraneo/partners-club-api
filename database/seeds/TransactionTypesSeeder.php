<?php

use App\Currency;
use App\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $data = [
                [ 
                    'description' => 'Traspaso', 
                    'rate' => 10000,
                    'apply_main' => 1,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                    'currency' => 'Dolar',
                ],
                [ 
                    'description' => 'Compra', 
                    'rate' => 20000,
                    'apply_main' => 0,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                    'currency' => 'Dolar',
                ],
                [ 
                    'description' => 'Revocacion', 
                    'rate' => 0,
                    'apply_main' => 1,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                    'currency' => 'Dolar',
                ],
                [ 
                    'description' => 'Carga Inicial', 
                    'rate' => 0,
                    'apply_main' => 0,
                    'apply_extension' => 0,
                    'apply_change_user' => 0,
                    'currency' => 'Euro',
                ],
                [ 
                    'description' => 'Cambio de Usuario', 
                    'rate' => 10000,
                    'apply_main' => 1,
                    'apply_extension' => 0,
                    'apply_change_user' => 1,
                    'currency' => 'Euro',
                ],
                [ 
                    'description' => 'Traspado Familiar', 
                    'rate' => 10000,
                    'apply_main' => 0,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                    'currency' => 'Dolar',
                ],
                [ 
                    'description' => 'Sucecion', 
                    'rate' => 0,
                    'apply_main' => 1,
                    'apply_extension' => 1,
                    'apply_change_user' => 0,
                    'currency' => 'Dolar',
                ],
            ];
            foreach ($data as $element) {
                $currency = Currency::where('description',$element['currency'])->first();
                TransactionType::create([
                    'description' => $element['description'],
                    'rate' => $element['rate'],
                    'apply_main' => $element['apply_main'],
                    'apply_extension' => $element['apply_extension'],
                    'apply_change_user' => $element['apply_change_user'],
                    'currency_id' => $currency ? $currency->id : null,
                ]);
            }
        }
    }
}
