<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Brand')->insert([
            'name' => 'Philip',
            'status' => 1,
            'photo' => 'uploads/brand/Philips.png',
        ]);
        DB::table('Brand')->insert([
            'name' => 'Schneider',
            'status' => 1,
            'photo' => 'uploads/brand/Schneider.png',
        ]);
        DB::table('Brand')->insert([
            'name' => 'Nippon',
            'status' => 1,
            'photo' => 'uploads/brand/Nippon.png',
        ]);
        DB::table('Brand')->insert([
            'name' => 'Avian',
            'status' => 1,
            'photo' => 'uploads/brand/Avian.png',
        ]);
        DB::table('Brand')->insert([
            'name' => 'Jotun',
            'status' => 1,
            'photo' => 'uploads/brand/Jotun.png',
        ]);
        DB::table('Brand')->insert([
            'name' => 'Tanpa Brand',
            'status' => 1,
            'photo' => 'uploads/brand/Lainnya.jpeg',
        ]);
    }
}
