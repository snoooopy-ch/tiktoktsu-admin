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
        $show_users_permission = Permission::create(['name' => 'show users']);
        $post_news_permission = Permission::create(['name' => 'post news']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $admin_role = Role::create(['name' => 'admin']);
        $writer_role = Role::create(['name' => 'writer']);

        $admin_role->givePermissionTo($show_users_permission);
        $admin_role->givePermissionTo($post_news_permission);

        $writer_role->syncPermissions($post_news_permission);
    }
}
