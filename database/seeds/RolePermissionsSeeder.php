<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('slug', 'administrador')->first();
        $admin->assignPermission(Permission::all());
    }
}
