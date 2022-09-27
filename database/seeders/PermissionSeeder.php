<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            
            // projects
            'create-project' , 
            'view-project',
            'update-project' ,
            'delete-project' ,

            // tasks
            'crerate-task' ,
            'view-task' ,
            'update-task' ,
            


        ];

        foreach ($permissions as $permission) {
            # code...
            Permission::create(['name' => $permission , 'guard_name' => 'api']);

        }
    }
}
