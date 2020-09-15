<?php

use App\Parameter;

use Illuminate\Database\Seeder;

class CreateDefaultSystemParamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
                // [
                //     'description' => 'Nombre del cliente',
                //     'parameter' => 'CLIENT_NAME',
                //     'value' => 'Cliente Demo',
                //     'eliminable' => 1,
                // ],
                // [
                //     'description' => 'logoweb.jpg',
                //     'parameter' => 'CLIENT_LOGO',
                //     'value' => 'logoweb.jpg',
                //     'eliminable' => 1,
                // ],
                // [
                //     'description' => 'Sitio offline',
                //     'parameter' => 'SITE_OFFLINE',
                //     'value' => '0',
                //     'eliminable' => 1,
                // ],
                // [
                //     'description' => 'Version Base de datos',
                //     'parameter' => 'DB_VERSION',
                //     'value' => '1.1.0',
                //     'eliminable' => 1,
                // ],
                // [
                //     'description' => 'Version Interfaz',
                //     'parameter' => 'FRONTEND_VERSION',
                //     'value' => '1.1.1',
                //     'eliminable' => 1,
                // ],
                // [
                //     'description' => 'Version Backend',
                //     'parameter' => 'BACKEND_VERSION',
                //     'value' => '1.1.2',
                //     'eliminable' => 1,
                // ],
                [
                    'description' => 'Endpoint API URL',
                    'parameter' => 'ENDPOINT_API_URL',
                    'value' => 'http://192.168.0.252:9001',
                    'eliminable' => 1,
                ],
                // [
                //     'description' => 'Nombre de Base de Datos',
                //     'parameter' => 'DB_NAME',
                //     'value' => 'partnersControl',
                //     'eliminable' => 1,
                // ],                
                //  [
                //      'description' => 'Servidor de Base de datos',
                //      'parameter' => 'DB_SERVER',
                //      'value' => 'http://192.168.0.11',
                //      'eliminable' => 1,
                //  ]
        ];
        foreach ($data as $element) {
            Parameter::create([
                'description' => $element['description'],
                'parameter' => $element['parameter'],
                'value' => $element['value'],
                'eliminable' => $element['eliminable'],
            ]);
        }
    }
}
