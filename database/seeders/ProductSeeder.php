<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('products')->insert([
            'category_id' => 1,
            'name' => 'Tiga Roda',
            'slug' => "Tiga-Roda",
            'brand_id' => 6,
            'photo' => 'uploads/products/3Roda.jpeg',
            'weight' => '50',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Avian',
            'slug' => "Avian",
            'brand_id' => 4,
            'photo' => 'uploads/products/Avian.jpeg',
            'weight' => '5',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Avitex',
            'slug' => "Avitex",
            'brand_id' => 4,
            'photo' => 'uploads/products/Avitex.jpeg',
            'weight' => '5',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Fres',
            'slug' => "Fres",
            'brand_id' => 4,
            'photo' => 'uploads/products/Fres.jpeg',
            'weight' => '5',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Jotun',
            'slug' => "Jotun",
            'brand_id' => 5,
            'photo' => 'uploads/brand/Jotun.png',
            'weight' => '5',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 2,
            'name' => 'Nippon',
            'slug' => "Nippon",
            'brand_id' => 3,
            'photo' => 'uploads/brand/Nippon.png',
            'weight' => '5',
            'unit' => 'Kg',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 4,
            'name' => 'Philips Lampu',
            'slug' => "Philips Lampu",
            'brand_id' => 1,
            'photo' => 'uploads/brand/Philips.png',
            'weight' => '1',
            'unit' => 'Pcs',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 5,
            'name' => 'Philips Shaver',
            'slug' => "Philips Shaver",
            'brand_id' => 1,
            'photo' => 'uploads/brand/Philips.png',
            'weight' => '1',
            'unit' => 'Pcs',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 4,
            'name' => 'Stop Kontak',
            'slug' => "Stop Kontak",
            'brand_id' => 1,
            'photo' => 'uploads/brand/Schneider.png',
            'weight' => '1',
            'unit' => 'Pcs',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);

        DB::table('products')->insert([
            'category_id' => 3,
            'name' => 'Kayu Andang',
            'slug' => "Kayu Andang",
            'brand_id' => 6,
            'photo' => 'uploads/category/Kayu.jpg',
            'weight' => '1',
            'unit' => 'Pcs',
            'description' => "What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            'trending' => 1,
            'status' => 1,
        ]);
    }
}
