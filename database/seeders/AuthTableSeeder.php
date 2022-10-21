<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Class AuthTableSeeder.
 */
class AuthTableSeeder extends Seeder
{
    use Traits\DisableForeignKeys, Traits\TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->truncateMultiple([
            config('permission.table_names.model_has_permissions'),
            config('permission.table_names.model_has_roles'),
            config('permission.table_names.role_has_permissions'),
            config('permission.table_names.permissions'),
            config('permission.table_names.roles'),
            config('access.table_names.users'),
            config('access.table_names.password_histories'),
            'password_resets',
            'social_accounts',
        ]);

        $this->call(Auth\UserTableSeeder::class);
        $this->call(Auth\PermissionRoleTableSeeder::class);
        $this->call(Auth\UserRoleTableSeeder::class);

        $this->enableForeignKeys();
    }
}
