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
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'White',
            'color' => '#FFFFFF',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Green',
            'color' => '#008000',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Red',
            'color' => '#FF0000',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'Blue',
            'color' => '#0000FF',
            'status' => 1,
        ]);
        DB::table('color')->insert([
            'name' => 'No Color',
            'color' => '',
            'status' => 1,
        ]);
    }
}
