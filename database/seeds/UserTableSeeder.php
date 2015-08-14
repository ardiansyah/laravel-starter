<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
        $roleUser = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'User',
            'slug' => 'user',
        ]);

        $user = Sentinel::registerAndActivate([
            'email'    => 'admin@admin.com',
            'password' => 'admin',
        ]);

        $roleAdmin->users()->attach($user);
    }
}
