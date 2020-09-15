<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'description' => 'Departamento 1'],
            [ 'description' => 'Departamento 2'],
            [ 'description' => 'Departamento 3'],
            [ 'description' => 'Departamento 4'],
        ];
        foreach ($data as $element) {
            Department::create([
                'description' => $element['description'],
            ]);
        }
    }
}
