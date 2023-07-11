<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('product_color')->insert([
            'product_id' => 1,
            'color_id' => 6,
            'qty' => 50,
            'original_price' => 860000,
            'price' => 950000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 2,
            'color_id' => 1,
            'qty' => 20,
            'original_price' => 800000,
            'price' => 100000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 2,
            'color_id' => 2,
            'qty' => 20,
            'original_price' => 800000,
            'price' => 100000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 2,
            'color_id' => 3,
            'qty' => 20,
            'original_price' => 800000,
            'price' => 100000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 2,
            'color_id' => 4,
            'qty' => 20,
            'original_price' => 800000,
            'price' => 100000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 2,
            'color_id' => 5,
            'qty' => 20,
            'original_price' => 800000,
            'price' => 100000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 3,
            'color_id' => 1,
            'qty' => 25,
            'original_price' => 1000000,
            'price' => 120000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 3,
            'color_id' => 2,
            'qty' => 25,
            'original_price' => 100000,
            'price' => 120000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 4,
            'color_id' => 1,
            'qty' => 30,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 4,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 5,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 6,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 7,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 8,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
        DB::table('product_color')->insert([
            'product_id' => 9,
            'color_id' => 2,
            'qty' => 50,
            'original_price' => 120000,
            'price' => 150000,
            'status' => 1,
        ]);
    }
}
