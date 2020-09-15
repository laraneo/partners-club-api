<?php

use App\Role;
use App\MenuItem;
use App\MenuItemRole;
use Illuminate\Database\Seeder;

class MenuItemRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [ 
            ['menuItem' => 'inicio', 'role' => ['administrador', 'gerente'] ],
            ['menuItem' => 'socios', 'role' => ['administrador', 'gerente'] ],
            ['menuItem' => 'acciones', 'role' => ['administrador']],
            ['menuItem' => 'movimiento-acciones', 'role' => ['administrador']],
            ['menuItem' => 'movimiento-acciones', 'role' => ['administrador']],
            ['menuItem' => 'banco', 'role' => ['administrador']],
            ['menuItem' => 'pais', 'role' => ['administrador']],
            ['menuItem' => 'deporte', 'role' => ['administrador']],
            ['menuItem' => 'profesion', 'role' => ['administrador']],
            ['menuItem' => 'estado-civil', 'role' => ['administrador']],
            ['menuItem' => 'status-persona', 'role' => ['administrador']],
            ['menuItem' => 'sexo', 'role' => ['administrador']],
            ['menuItem' => 'tipo-repacion', 'role' => ['administrador']],
            ['menuItem' => 'metodo-de-pago', 'role' => ['administrador']],
            ['menuItem' => 'tipo-de-tarjeta', 'role' => ['administrador']],
            ['menuItem' => 'tipo-de-accion', 'role' => ['administrador']],
            ['menuItem' => 'parametros', 'role' => ['administrador']],
            ['menuItem' => 'locker', 'role' => ['administrador']],
            ['menuItem' => 'tipo-de-transacion', 'role' => ['administrador']],
            ['menuItem' => 'reportes', 'role' => ['administrador']],
            ['menuItem' => 'reporte-general', 'role' => ['administrador']],
            ['menuItem' => 'reporte-acciones', 'role' => ['administrador']],
            ['menuItem' => 'seguridad', 'role' => ['administrador']],
            ['menuItem' => 'roles', 'role' => ['administrador']],
            ['menuItem' => 'permisos', 'role' => ['administrador']],
            ['menuItem' => 'widget', 'role' => ['administrador']],
            ['menuItem' => 'menu', 'role' => ['administrador']],
            ['menuItem' => 'menu-item', 'role' => ['administrador']],
            ['menuItem' => 'acceso', 'role' => ['administrador']],
            ['menuItem' => 'control-acceso', 'role' => ['administrador']],
            ['menuItem' => 'ubicacion', 'role' => ['administrador']],
            ['menuItem' => 'invitados', 'role' => ['administrador']],
            ['menuItem' => 'acceso-reportes', 'role' => ['administrador']],
            ['menuItem' => 'reporte-control-acceso', 'role' => ['administrador']],
            ['menuItem' => 'reporte-invitados', 'role' => ['administrador']],
        ];
        foreach ($data as $key => $value) {
            $menuItem = MenuItem::where('slug', $value['menuItem'])->first();
            foreach ($variable as $key => $value) {
                $admin = Role::where('slug', $value['role'])->first();
                MenuItemRole::create([
                    'role_id' => $admin->id,
                    'menu_item_id' => $menuItem->id,
                ]);
            }
        }



        $admin = Role::where('slug', 'gerente')->first();
        $menuItem = MenuItem::where('slug', 'socios')->first();
        MenuItemRole::create([
            'role_id' => $admin->id,
            'menu_item_id' => $menuItem->id,
        ]);

        // $menuItems = MenuItem::all();
        // foreach ($menuItems as $key => $value) {
        //     MenuItemRole::create([
        //         'role_id' => $admin->id,
        //         'menu_item_id' => $value->id,
        //     ]);
        // }
    }
}
