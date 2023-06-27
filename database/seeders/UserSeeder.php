<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'Admin@admin.com',
            'password' => bcrypt('admin123'),
            'gender' => 'male',
            'is_verified' => 1,
            'date_of_birth' => '1995-09-23',
            'address' => 'Jln.Kh Syahdan no 123',
            'role' => 'ADMIN'
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('useruser12'),
            'gender' => 'male',
            'is_verified' => 1,
            'date_of_birth' => '1999-09-23',
            'address' => 'Jln.Kh Syahdan no 155',
            'role' => 'USER'
        ]);
    }
}
