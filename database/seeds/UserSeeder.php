<?php

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
        \App\User::query()->truncate();

        \App\User::insert([
            'name'     => 'admin',
            'email'    => 'admin',
            'password' => Hash::make('admin')
        ]);
    }
}
