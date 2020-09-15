<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\Menu;
use App\MenuItem;
use App\Parameter;
use App\MenuItemRole;

class CreateMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuBase = Menu::create([
            'name' => 'menu-base',
            'slug' => 'menu-base',
            'description' => 'Menu Base',
        ]);

        Parameter::create([
            'description' => 'MENU PRINCIPAL',
            'parameter' => 'MENU_ID',
            'value' => $menuBase->id,
            'eliminable' => 1,
        ]);

        MenuItem::create([
            'name' => 'Inicio',
            'slug' => 'inicio',
            'parent' => 0,
            'order' => 0,
            'description' => 'Inicio',
            'route' => '/dashboard/main',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Socios',
            'slug' => 'socio',
            'parent' => 0,
            'order' => 1,
            'description' => 'Socios',
            'route' => '/dashboard/socio',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Acciones',
            'slug' => 'acciones',
            'parent' => 0,
            'order' => 2,
            'description' => 'Acciones',
            'route' => '/dashboard/share',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Movimiento de Acciones',
            'slug' => 'movimiento-acciones',
            'parent' => 0,
            'order' => 3,
            'description' => 'Movimiento de Acciones',
            'route' => '/dashboard/share-movement',
            'menu_id' => $menuBase->id,
        ]);

      $mant = MenuItem::create([
            'name' => 'Mantenimiento',
            'slug' => 'mantenimiento',
            'parent' => 0,
            'order' => 4,
            'description' => 'Mantenimiento',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Banco',
            'slug' => 'banco',
            'parent' => $mant->id,
            'order' => 1,
            'description' => 'Banco',
            'route' => '/dashboard/banco',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Pais',
            'slug' => 'pais',
            'parent' => $mant->id,
            'order' => 2,
            'description' => 'Pais',
            'route' => '/dashboard/pais',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Deporte',
            'slug' => 'deporte',
            'parent' => $mant->id,
            'order' => 3,
            'description' => 'Deporte',
            'route' => '/dashboard/deporte',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Profesion',
            'slug' => 'profesion',
            'parent' => $mant->id,
            'order' => 4,
            'description' => 'Profesion',
            'route' => '/dashboard/profesion',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Estado Civil',
            'slug' => 'estado-civil',
            'parent' => $mant->id,
            'order' => 5,
            'description' => 'Estado Civil',
            'route' => '/dashboard/estado-civil',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Estatus',
            'slug' => 'status-persona',
            'parent' => $mant->id,
            'order' => 6,
            'description' => 'Estatus',
            'route' => '/dashboard/status-persona',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Sexo',
            'slug' => 'sexo',
            'parent' => $mant->id,
            'order' => 7,
            'description' => 'Sexo',
            'route' => '/dashboard/sexo',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Tipo Relacion',
            'slug' => 'tipo-relacion',
            'parent' => $mant->id,
            'order' => 8,
            'description' => 'Tipo Relacion',
            'route' => '/dashboard/relation-type',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Metodo de Pago',
            'slug' => 'metodo-de-pago',
            'parent' => $mant->id,
            'order' => 9,
            'description' => 'Metodo de Pago',
            'route' => '/dashboard/payment-method',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Tipo de Tarjeta',
            'slug' => 'tipo-de-tarjeta',
            'parent' => $mant->id,
            'order' => 10,
            'description' => 'Tipo de Tarjeta',
            'route' => '/dashboard/card-type',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Tipo de Accion',
            'slug' => 'tipo-de-accion',
            'parent' => $mant->id,
            'order' => 11,
            'description' => 'Tipo de Accion',
            'route' => '/dashboard/share-type',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Parametros',
            'slug' => 'parametros',
            'parent' => $mant->id,
            'order' => 12,
            'description' => 'Parametros',
            'route' => '/dashboard/parameter',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Locker',
            'slug' => 'locker',
            'parent' => $mant->id,
            'order' => 13,
            'description' => 'Locker',
            'route' => '/dashboard/locker',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Tipo de Transacion',
            'slug' => 'tipo-de-transacion',
            'parent' => $mant->id,
            'order' => 14,
            'description' => 'Tipo de Transacion',
            'route' => '/dashboard/transaction-type',
            'menu_id' => $menuBase->id,
        ]);
        $reports = MenuItem::create([
            'name' => 'Reportes',
            'slug' => 'reportes',
            'parent' => 0,
            'order' => 0,
            'description' => 'Reportes',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

       MenuItem::create([
            'name' => 'General',
            'slug' => 'reporte-general',
            'parent' => $reports->id,
            'order' => 1,
            'description' => 'General',
            'route' => '/dashboard/report-general',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Acciones',
            'slug' => 'reporte-acciones',
            'parent' => $reports->id,
            'order' => 2,
            'description' => 'Acciones',
            'route' => '/dashboard/share-report',
            'menu_id' => $menuBase->id,
        ]);

       $sec = MenuItem::create([
            'name' => 'Seguridad',
            'slug' => 'seguridad',
            'parent' => 0,
            'order' => 1,
            'description' => 'Seguridad',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Roles',
            'slug' => 'roles',
            'parent' => $sec->id,
            'order' => 2,
            'description' => 'Roles',
            'route' => '/dashboard/role',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Permisos',
            'slug' => 'permisos',
            'parent' => $sec->id,
            'order' => 3,
            'description' => 'Permisos',
            'route' => '/dashboard/permission',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Usuarios',
            'slug' => 'usuarios',
            'parent' => $sec->id,
            'order' => 2,
            'description' => 'Usuarios',
            'route' => '/dashboard/user',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Widget',
            'slug' => 'widget',
            'parent' => $sec->id,
            'order' => 4,
            'description' => 'Widget',
            'route' => '/dashboard/widget',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Menu',
            'slug' => 'menu',
            'parent' => $sec->id,
            'order' => 5,
            'description' => 'Menu',
            'route' => '/dashboard/menu',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Menu Item',
            'slug' => 'menu-item',
            'parent' => $sec->id,
            'order' => 6,
            'description' => 'Menu',
            'route' => '/dashboard/menu-item',
            'menu_id' => $menuBase->id,
        ]);

       $access = MenuItem::create([
            'name' => 'Acceso',
            'slug' => 'acceso',
            'parent' => 0,
            'order' => 0,
            'description' => 'Acceso',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Control de acceso',
            'slug' => 'control-acceso',
            'parent' => $access->id,
            'order' => 1,
            'description' => 'Ubicaciones',
            'route' => '/dashboard/access-control',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Ubicaciones',
            'slug' => 'ubicacion',
            'parent' => $access->id,
            'order' => 1,
            'description' => 'Ubicaciones',
            'route' => '/dashboard/location',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Invitados',
            'slug' => 'invitados',
            'parent' => $access->id,
            'order' => 2,
            'description' => 'Invitados',
            'route' => '/dashboard/guest',
            'menu_id' => $menuBase->id,
        ]);

       $reports = MenuItem::create([
            'name' => 'Reportes',
            'slug' => 'acceso-reportes',
            'parent' => $access->id,
            'order' => 2,
            'description' => 'Reportes',
            'route' => '',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Control de Acceso',
            'slug' => 'reporte-control-acceso',
            'parent' => $reports->id,
            'order' => 1,
            'description' => 'Reportes',
            'route' => '/dashboard/access-control-report',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Invitados',
            'slug' => 'reporte-invitados',
            'parent' => $reports->id,
            'order' => 2,
            'description' => 'Reportes',
            'route' => '/dashboard/guest',
            'menu_id' => $menuBase->id,
        ]);

        $data = [ 
            ['menuItem' => 'socio', 'roles' => ['administrador', 'gerente'] ],
            ['menuItem' => 'acciones', 'roles' => ['administrador'] ],
            ['menuItem' => 'movimiento-acciones', 'roles' => ['administrador', 'gerente']],
            ['menuItem' => 'mantenimiento', 'roles' => ['administrador']],
            ['menuItem' => 'banco', 'roles' => ['administrador']],
            ['menuItem' => 'pais', 'roles' => ['administrador']],
            ['menuItem' => 'deporte', 'roles' => ['administrador']],
            ['menuItem' => 'profesion', 'roles' => ['administrador']],
            ['menuItem' => 'estado-civil', 'roles' => ['administrador']],
            ['menuItem' => 'status-persona', 'roles' => ['administrador']],
            ['menuItem' => 'sexo', 'roles' => ['administrador']],
            ['menuItem' => 'tipo-relacion', 'roles' => ['administrador']],
            ['menuItem' => 'metodo-de-pago', 'roles' => ['administrador']],
            ['menuItem' => 'tipo-de-tarjeta', 'roles' => ['administrador']],
            ['menuItem' => 'tipo-de-accion', 'roles' => ['administrador']],
            ['menuItem' => 'parametros', 'roles' => ['administrador']],
            ['menuItem' => 'locker', 'roles' => ['administrador']],
            ['menuItem' => 'tipo-de-transacion', 'roles' => ['administrador']],
            ['menuItem' => 'reportes', 'roles' => ['administrador']],
            ['menuItem' => 'reporte-general', 'roles' => ['administrador']],
            ['menuItem' => 'reporte-acciones', 'roles' => ['administrador']],
            ['menuItem' => 'seguridad', 'roles' => ['administrador']],
            ['menuItem' => 'roles', 'roles' => ['administrador']],
            ['menuItem' => 'usuarios', 'roles' => ['administrador']],
            ['menuItem' => 'permisos', 'roles' => ['administrador']],
            ['menuItem' => 'widget', 'roles' => ['administrador']],
            ['menuItem' => 'menu', 'roles' => ['administrador']],
            ['menuItem' => 'menu-item', 'roles' => ['administrador']],
            ['menuItem' => 'acceso', 'roles' => ['administrador']],
            ['menuItem' => 'control-acceso', 'roles' => ['administrador']],
            ['menuItem' => 'ubicacion', 'roles' => ['administrador']],
            ['menuItem' => 'invitados', 'roles' => ['administrador']],
            ['menuItem' => 'acceso-reportes', 'roles' => ['administrador']],
            ['menuItem' => 'reporte-control-acceso', 'roles' => ['administrador']],
            ['menuItem' => 'reporte-invitados', 'roles' => ['administrador']],
        ];
        foreach ($data as $key => $value) {
            foreach ($value['roles'] as $key => $role) {
                $menuItem = MenuItem::where('slug', $value['menuItem'])->first();
                $role = Role::where('slug', $role)->first();
                MenuItemRole::create([
                    'role_id' => $role->id,
                    'menu_item_id' => $menuItem ? $menuItem->id : null,
                ]);
            }
        }
        
    }
}
