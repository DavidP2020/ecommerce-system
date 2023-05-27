<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('color')->insert([
            'name' => 'Black',
            'color' => '#000000',
            'photo' => '',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'White',
            'color' => '#FFFFFF',
            'photo' => '',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Green',
            'color' => '#008000',
            'photo' => '',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Red',
            'color' => '#FF0000',
            'photo' => '',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Blue',
            'color' => '#0000FF',
            'photo' => '',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'No Color',
            'color' => '',
            'photo' => '',
            'status' => 1,
        ]);
    }
}
