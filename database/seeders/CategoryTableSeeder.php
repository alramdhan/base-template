<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Sembako',
            'Minuman',
            'Makanan Ringan',
            'Rokok',
            'Bumbu Dapur',
            'Perlengkapan Mandi',
            'Perlengkapan Rumah Tangga',
            'Obat & Kesehatan',
            'Makanan Instan',
            'Alat Tulis',
        ];
 
        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
