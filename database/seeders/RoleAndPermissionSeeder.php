<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //user permissions
            'view users',
            'create users', 
            'edit users', 
            'delete users',
            //passenger permissions
            'view passengers', 
            'create passengers', 
            'edit passengers', 
            'delete passengers',
            //flight permissions
            'view flights', 
            'create flights', 
            'edit flights', 
            'delete flights',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);
        
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('view users');
        $userRole->givePermissionTo('view passengers');
        $userRole->givePermissionTo('view flights');
    }
}
