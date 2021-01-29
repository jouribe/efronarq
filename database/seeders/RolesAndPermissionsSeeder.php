<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        Permission::create(['name' => 'read projects']);
        Permission::create(['name' => 'create projects']);

        Permission::create(['name' => 'edit visits']);
        Permission::create(['name' => 'delete visits']);
        Permission::create(['name' => 'read visits']);
        Permission::create(['name' => 'create visits']);

        Permission::create(['name' => 'edit pull aparts']);
        Permission::create(['name' => 'delete pull aparts']);
        Permission::create(['name' => 'read pull aparts']);
        Permission::create(['name' => 'create pull aparts']);

        Permission::create(['name' => 'edit reports']);
        Permission::create(['name' => 'delete reports']);
        Permission::create(['name' => 'read reports']);
        Permission::create(['name' => 'create reports']);

        Permission::create(['name' => 'edit sales']);
        Permission::create(['name' => 'delete sales']);
        Permission::create(['name' => 'read sales']);
        Permission::create(['name' => 'create sales']);

        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'create users']);

        Permission::create(['name' => 'edit origins']);
        Permission::create(['name' => 'delete origins']);
        Permission::create(['name' => 'read origins']);
        Permission::create(['name' => 'create origins']);

        Permission::create(['name' => 'edit banks']);
        Permission::create(['name' => 'delete banks']);
        Permission::create(['name' => 'read banks']);
        Permission::create(['name' => 'create banks']);

        Permission::create(['name' => 'edit promotions']);
        Permission::create(['name' => 'delete promotions']);
        Permission::create(['name' => 'read promotions']);
        Permission::create(['name' => 'create promotions']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // Vendedor
        $vendedor = Role::create(['name' => 'vendedor']);
        $vendedor->givePermissionTo([
            'read projects',
            'create visits',
            'edit visits',
            'read visits',
            'delete visits',
            'edit pull aparts',
            'delete pull aparts',
            'read pull aparts',
            'create pull aparts',
            'read reports'
        ]);

        // Asistente Administrativo
        $asistente = Role::create(['name' => 'asistente']);
        $asistente->givePermissionTo([
            'create projects',
            'read projects',
            'delete projects',
            'edit projects',
            'read visits',
            'read pull aparts',
            'edit pull aparts',
            'read reports',
            'read sales',
            'edit sales',
            'create sales',
            'create banks',
            'edit banks',
            'delete banks',
            'read banks',
            'create origins',
            'edit origins',
            'delete origins',
            'read origins',
            'create promotions',
            'read promotions',
            'edit promotions',
            'delete promotions',
            'read users'
        ]);
    }
}
