<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
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

        // Add the master administrator, user id of 1
        User::create([
            // 'name'              => 'admin',
            'first_name'        => 'Admin',
            'last_name'         => 'Istrator',
            'email'             => 'admin@lms.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('0000'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            // 'name'              => 'teacher',
            'first_name'        => 'Teacher',
            'last_name'         => 'User',
            'email'             => 'teacher@lms.com',
            'password'          => Hash::make('0000'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            // 'name'              => 'teacher',
            'first_name'        => 'Instructor',
            'last_name'         => 'User',
            'email'             => 'instructor@lms.com',
            'password'          => Hash::make('0000'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            // 'name'              => 'student',
            'first_name'        => 'Student',
            'last_name'         => 'User',
            'email'             => 'student@lms.com',
            'password'          => Hash::make('0000'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::create([
            // 'name'              => 'normal',
            'first_name'        => 'Normal',
            'last_name'         => 'User',
            'email'             => 'user@lms.com',
            'password'          => Hash::make('0000'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        $users = \App\Library\Data\FetchJsonFile::open('users.json');
        foreach ($users as $user)
        {
            \App\Models\Auth\User::create([
                // 'username' => $user['first_name'] . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($user['password']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
            ]);
        }

        $this->enableForeignKeys();
    }
}
