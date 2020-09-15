<?php


use App\Menu;
use App\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
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

        MenuItem::create([
            'name' => 'Inicio',
            'slug' => 'inicio',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Socios',
            'slug' => 'socios',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Acciones',
            'slug' => 'acciones',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

         MenuItem::create([
            'name' => 'Movimiento Acciones',
            'slug' => 'movimiento-acciones',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

        $mantenimiento = MenuItem::create([
            'name' => 'Mantenimiento',
            'slug' => 'mantenimiento',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);


        // submenu mantenimiento start

        $banco = MenuItem::create([
            'name' => 'Banco',
            'slug' => 'banco',
            'parent' => $mantenimiento->id,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

        $profesion = MenuItem::create([
            'name' => 'Profesion',
            'slug' => 'profesion',
            'parent' => $mantenimiento->id,
            'order' => 1,
            'menu_id' => $menuBase->id,
        ]);

         // submenu mantenimiento end

        $acceso = MenuItem::create([
            'name' => 'Acceso',
            'slug' => 'acceso',
            'parent' => 0,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);


        // submenu acceso start

        $controlacceso = MenuItem::create([
            'name' => 'Control de Acceso',
            'slug' => 'control-de-acceso',
            'parent' => $acceso->id,
            'order' => 0,
            'menu_id' => $menuBase->id,
        ]);

        $reportes = MenuItem::create([
            'name' => 'Reportes',
            'slug' => 'acceso-reportes',
            'parent' => $acceso->id,
            'order' => 1,
            'menu_id' => $menuBase->id,
        ]);      

        // submenu acceso end

        // submenu acceso reportes start

            $reportes = MenuItem::create([
                'name' => 'Control de Acceso',
                'slug' => 'reporte-control-de-acceso',
                'parent' => $reportes->id,
                'order' => 1,
                'menu_id' => $menuBase->id,
            ]);  
        // submenu acceso reportes end
    }
}
