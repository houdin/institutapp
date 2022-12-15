<?php

namespace Database\Seeders\Auth;

use App\Models\Team;
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
        User::factory()->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create([
            // 'name'              => 'admin',
            'name'         => 'Administrator',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'          => '0000',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::factory()->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create([
            // 'name'              => 'teacher',
            'name'              => 'Teacher User',
            'email'             => 'teacher@lms.com',
            'password'          => '0000',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::factory()->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create([
            // 'name'              => 'teacher',
            'name'        => 'Instructor User',
            'email'             => 'instructor@lms.com',
            'password'          => '0000',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::factory()->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create([
            // 'name'              => 'student',
            'name'        => 'Student User',
            'email'             => 'student@lms.com',
            'password'          => '0000',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::factory()->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create([
            // 'name'              => 'normal',
            'name'        => 'Normal User',
            'email'             => 'user@lms.com',
            'password'          => '0000',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed'         => true,
        ]);

        User::factory(10)->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id, 'personal_team' => true];
                }),
        )->create();

        $this->enableForeignKeys();
    }
}
