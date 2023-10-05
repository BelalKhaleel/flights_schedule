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
        Permission::create(['name' => 'get-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'get-flights']);
        Permission::create(['name' => 'create-flights']);
        Permission::create(['name' => 'edit-flights']);
        Permission::create(['name' => 'delete-flights']);

        $adminRole = Role::create(['name' => 'Admin']);
        $editorRole = Role::create(['name' => 'Editor']);

        $adminRole->givePermissionTo([
            'get-users',
            'create-users',
            'edit-users',
            'delete-users',
            'get-flights',
            'create-flights',
            'edit-flights',
            'delete-flights',
        ]);

        $editorRole->givePermissionTo([
            'get-flights',
            'create-users',
            'get-users',
            'edit-users',
            'delete-users',
        ]);
    }
}
