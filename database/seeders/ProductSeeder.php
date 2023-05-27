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
    }
}
