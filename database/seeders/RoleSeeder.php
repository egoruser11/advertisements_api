<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => User::ROLE_ADMIN]);
        Role::create(['name' => User::ROLE_SELLER]);
        Role::create(['name' => User::ROLE_CUSTOMER]);
    }
}
