<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(['administrator', 'user'])
            ->map(function ($user) {
                Role::create(['name' => $user]);
            });
    }
}
