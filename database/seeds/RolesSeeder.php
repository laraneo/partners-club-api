<?php

use Illuminate\Database\Seeder;

use App\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 
                'name' => 'Administrador', 
                'slug' => 'administrador', 
                'description' => 'Tiene todos los permisos' 
            ],
            [ 
                'name' => 'Gerente', 
                'slug' => 'gerente', 
                'description' => 'Gerencia' 
            ],
            [ 
                'name' => 'Secreataria', 
                'slug' => 'secretaria', 
                'description' => 'Secreataria' 
            ],
            [ 
                'name' => 'Socio', 
                'slug' => 'socio', 
                'description' => 'Permisos para socios' 
            ],
        ];
        foreach ($data as $element) {
            Role::create([
                'name' => $element['name'],
                'slug' => $element['slug'],
                'description' => $element['description'],
            ]);
        }
    }
}
