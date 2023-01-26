<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \Spatie\Permission\Models\Role::create(['name' => 'super_admin']);
        // check if role exsit
        if (! \Spatie\Permission\Models\Role::where('name', 'super_admin')->exists()) {
            \Spatie\Permission\Models\Role::create(['name' => 'super_admin']);
        }

        // get all model

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_verified' => 1,
            'password' => Hash::make('admin'),
        ])->assignRole('super_admin');
    }
}
