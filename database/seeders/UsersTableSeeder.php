<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'role' => 1, // 1 = admin
            'status' => 1, // 1 = active
            'location_id' => 1, // 1 = head office
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // You can change this to your desired password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
