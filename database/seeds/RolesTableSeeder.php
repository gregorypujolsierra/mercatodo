<?php

use Illuminate\Database\Seeder;
use App\Role;
use Illuminate\Support\Facades\Schema;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        foreach (config('app.roles') as $role) {
            Role::create(['name' => $role]);
        }
    }
}
