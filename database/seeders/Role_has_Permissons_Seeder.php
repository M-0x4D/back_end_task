<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Role;
use App\models\Permission;

class Role_has_Permissons_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission =new  Permission();
        $roleId = [4];
        $permissions = [13,15];

        foreach ($permissions as $per) {
            # code...
            $permission->permission_role()->attach($roleId , ['permission_id' => $per ]);

        }
    }
}
