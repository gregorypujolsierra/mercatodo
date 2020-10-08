<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $userRole = Role::where('name', 'user')->first();

        User::create(
            [
                'name' => 'Greg Admin',
                'email' => 'admin@admin',
                'password' => Hash::make('1234'),
                'enabled' => 1,
                'role_id' => $adminRole->id,
            ]
        );
        User::create(
            [
                'name' => 'Greg Staff',
                'email' => 'staff@staff',
                'password' => Hash::make('1234'),
                'enabled' => 1,
                'role_id' => $staffRole->id,
            ]
        );
        User::create(
            [
                'name' => 'Greg User',
                'email' => 'user@user',
                'password' => Hash::make('1234'),
                'enabled' => 1,
                'role_id' => $userRole->id,
            ]
        );
        factory(User::class, 8)->create();
    }
}
