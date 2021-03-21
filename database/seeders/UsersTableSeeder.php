<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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

        User::create([
            'name'     => 'administrator',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id'  => 1,
        ]);

        User::create([
            'name'     => 'user 1',
            'email'    => 'user@test.com',
            'password' => Hash::make('password'),
            'role_id'  => 2,
        ]);

        User::factory(8)->create();
    }
}
