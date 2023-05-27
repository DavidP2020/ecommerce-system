<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Semen',
            'slug' => 'Semen',
            'description' => "Semen adalah zat yang digunakan untuk merekat batu, bata, batako, maupun bahan bangunan lainnya. Sedangkan kata semen sendiri berasal dari caementum, yang artinya memotong menjadi bagian-bagian kecil tak beraturan.",
            'photo' => 'uploads/category/Semen.jpg',
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => 'Cat',
            'slug' => 'Cat',
            'description' => "Cat adalah suatu cairan yang dipakai untuk melapisi permukaan ... Cat merupakan unsur yang penting untuk menutupi bagian luar bangunan.",
            'photo' => 'uploads/category/Cat.png',
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => 'Kayu',
            'slug' => 'Kayu',
            'description' => "Kayu yang diperoleh dengan jalan mengkonversikan kayu bulat menjadi kayu berbentuk balok, papan ataupun bentuk-bentuk lain sesuai dengan tujuan penggunaannya.",
            'photo' => 'uploads/category/Kayu.jpg',
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => 'Peralatan Listrik',
            'slug' => 'Peralatan-Listrik',
            'description' => "Peralatan elektronik dan kelengkapannya bisa Anda dapatkan di toko terdekat. Karena kebutuhannya sederhana, Anda bisa membeli dalam jumlah terbatas. Berikut yang wajib Anda sediakan di rumah.",
            'photo' => 'uploads/category/Listrik.jpg',
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => 'Tidak Terkategori',
            'slug' => 'Tidak-Terkategori',
            'description' => "Lainnya",
            'photo' => 'uploads/brand/Lainnya.jpeg',
            'status' => 1,
        ]);
    }
}
