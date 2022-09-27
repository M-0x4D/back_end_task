<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Supervisor' ,
            'employee'

        ];

        foreach ($roles as $role) {
            # code...
            Role::create(['name' => $role , 'guard_name' => 'token']);

        }
    }
}
