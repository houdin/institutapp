<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    use \Database\Seeders\Traits\DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        User::find(1)->assignRole(config('access.users.admin_role'));
        User::find(2)->assignRole('teacher');
        User::find(3)->assignRole('instructor');
        User::find(4)->assignRole('student');
        User::find(5)->assignRole(config('access.users.default_role'));
        $index = 1;
        foreach (User::all() as $user ){
            if($index > 5){
                User::find($index)->assignRole(config('access.users.default_role'));
            }
            $index++;
        }
        $this->enableForeignKeys();
    }
}
