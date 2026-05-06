<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Hash;

class UserSesder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        /* Permission::create([
            'name' => 'permission-create',
            'group'=>'permission'
        ]);
        Permission::create([
            'name' => 'permission-list',
            'group'=>'permission'
        ]);
        Permission::create([
            'name' => 'permission-edit',
            'group'=>'permission'
        ]);
        Permission::create([
            'name' => 'permission-delete',
            'group'=>'permission'
        ]);
        
        Permission::create([
            'name' => 'role-create',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-list',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-edit',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-delete',
            'group'=>'role'
        ]); */

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $user = User::create([
            'name' =>"Admin",
            'email'=>"hrbo@gmail.com",
            'password'=>Hash::make('Hrbo@123#')
        ]); 

        $user->assignRole('super-admin');

    }
}
