<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [ 
                'name' => 'Admin Test ',
                'username' => 'admin',
                'email' => 'admin@test.com',
                'password' => '123456',
                'role' => 'administrador',
            ],
            [ 
                'name' => 'Gerente Test 1',
                'username' => 'gerente',
                'email' => 'gerente@test.com',
                'password' => '123456',
                'role' => 'gerente',
            ],
            [ 
                'name' => 'Secretaria Test 2',
                'username' => 'secretaria',
                'email' => 'secretaria@test.com',
                'password' => '123456',
                'role' => 'secretaria',
            ],
            [ 
                'name' => 'Partner Test',
                'username' => '120610',
                'email' => 'partnertest@test.com',
                'password' => '123456',
                'role' => 'socio',
            ],
            [ 
                'name' => 'Partner Test 1',
                'username' => 'A-1713',
                'email' => 'partnertes1t@test.com',
                'password' => '123456',
                'role' => 'socio',
            ],
        ];
        foreach ($users as $user) {
           $role = Role::where('slug',$user['role'])->first();
           $user = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
            $user->assignRole($role->id);
        }
    }
}
