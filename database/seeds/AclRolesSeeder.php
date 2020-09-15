<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;

class AclRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//or create array method

// $role = new Role();
// $roleAdmin = $role->create([
//     'name' => 'Administrator',
//     'slug' => 'administrator',
//     'description' => 'manage administration privileges'
// ]);

// $role = new Role();
// $roleModerator = $role->create([
//     'name' => 'Moderator',
//     'slug' => 'moderator',
//     'description' => 'manage moderator privileges'
// ]);


// $user = User::find(1);
// $user->assignRole($roleAdmin->id);

// $user = User::find(2);
// $user->assignRole($roleModerator->id);





// $permission = new Permission();
// $permUser = $permission->create([ 
//     'name'        => 'otheruser',
//     'slug'        => 'create',
//     'description' => 'manage user permissions'
// ]);

// $roleAdmin = Role::find(1); // administrator
// $roleAdmin->assignPermission(Permission::all());

// $roleModerator = Role::find(2); // moderator
// $roleModerator->assignPermission('maestro-banco-ver');


// $user = User::find(1);
// $user->getPermissions();

// dd($user->getPermissions());
//$activity = Activity::inLog('profession')->get();

//dd($activity);

// $user = User::where('username', 'admin')->first();
// $admin = Role::where('slug', 'administrador')->first();
// $user->assignRole($admin->id);
// dd($user->getRoles());
// $database = \DB::connection()->getDatabaseName();
// dd(env('APP_URL'));

    }
}
