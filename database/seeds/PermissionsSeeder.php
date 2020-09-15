<?php

use Illuminate\Database\Seeder;

use App\Permission;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slug = [ 'acl' => true ];
        $data = [
            [ 
                'name' => 'maestro-banco-ver', 
                'slug' => json_encode($slug), 
                'description' => 'Ver Banco' 
            ],
            [ 
                'name' => 'maestro-banco-crear', 
                'slug' => json_encode($slug), 
                'description' => 'Crear Banco' 
            ],
            [ 
                'name' => 'maestro-banco-editar', 
                'slug' => json_encode($slug), 
                'description' => 'Editar Banco' 
            ],
            [ 
                'name' => 'maestro-banco-borrar', 
                'slug' => json_encode($slug), 
                'description' => 'Borrar Banco' 
            ],

            //PAIS
            [ 
                'name' => 'maestro-pais-ver', 
                'slug' => json_encode($slug), 
                'description' => 'Ver Pais' 
            ],
            [ 
                'name' => 'maestro-pais-crear', 
                'slug' => json_encode($slug), 
                'description' => 'Crear Pais' 
            ],
            [ 
                'name' => 'maestro-pais-editar', 
                'slug' => json_encode($slug), 
                'description' => 'Editar Pais' 
            ],
            [ 
                'name' => 'maestro-pais-borrar', 
                'slug' => json_encode($slug), 
                'description' => 'Borrar Pais' 
            ],

            //Deportes
            [ 
                'name' => 'maestro-deporte-ver', 
                'slug' => json_encode($slug), 
                'description' => 'Ver Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-crear', 
                'slug' => json_encode($slug), 
                'description' => 'Crear Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-editar', 
                'slug' => json_encode($slug), 
                'description' => 'Editar Deporte' 
            ],
            [ 
                'name' => 'maestro-deporte-borrar', 
                'slug' => json_encode($slug), 
                'description' => 'Borrar Deporte' 
            ],
        ];
        foreach ($data as $element) {
            Permission::create([
                'name' => $element['name'],
                'slug' => $element['slug'],
                'description' => $element['description'],
            ]);
        }
    }
}
