<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'guest',
            'email' => 'guest'.'@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Merchant
        DB::table('users')->insert([
            'id' => '2',
            'name' => 'merchant',
            'email' => 'merchant'.'@gmail.com',
            'password' => Hash::make('password'),
        ]);
        
        DB::table('merchants')->insert([
            'user_id' => '2',
            'description' => 'I am a merchant',
            'role' => 'Merchant',
        ]);
    }
}
