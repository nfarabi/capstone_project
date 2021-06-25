<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'delete pages']);
        Permission::create(['name' => 'publish pages']);
        Permission::create(['name' => 'unpublish pages']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // or may be done by chaining
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['edit pages', 'publish pages', 'unpublish pages']);
        Role::create(['name' => 'merchant']);
        Role::create(['name' => 'user']);
    }
}
