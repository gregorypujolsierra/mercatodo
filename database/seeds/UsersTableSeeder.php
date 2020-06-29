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
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $staffRole = Role::where('name', 'staff')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create(
            [
                'name' => 'Greg Admin',
                'email' => 'admin@admin',
                'password' => Hash::make('1234'),
            ]
        );
        $staff = User::create(
            [
                'name' => 'Greg Staff',
                'email' => 'staff@staff',
                'password' => Hash::make('1234'),
            ]
        );
        $user = User::create(
            [
                'name' => 'Greg User',
                'email' => 'user@user',
                'password' => Hash::make('1234'),
            ]
        );

        $admin->roles()->attach($adminRole);
        $staff->roles()->attach($staffRole);
        $user->roles()->attach($userRole);
    }
}
