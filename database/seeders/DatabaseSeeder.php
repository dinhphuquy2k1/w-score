<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
             'name' => 'Admin',
             'email' => 'dinhphuquy2001@gmail.com',
             'user_code' => 'PQ',
             'password' =>  \Illuminate\Support\Facades\Hash::make('1'),
         ]);
    }
}
