<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori sudah ada (jaga-jaga jika seeder dijalankan terpisah)
        $this->call(CategoryTableSeeder::class);
 
        // Ambil id kategori berdasarkan nama agar mudah dipetakan
        $categories = Category::pluck('id', 'name');
 
        $products = [
            // Sembako
            ['category' => 'Sembako', 'name' => 'Beras Premium 5kg', 'sku' => 'SEM-001', 'price' => 65000, 'stock' => 30, 'unit' => 'karung', 'min_stock' => 5],
            ['category' => 'Sembako', 'name' => 'Minyak Goreng Bimoli 1L', 'sku' => 'SEM-002', 'price' => 19000, 'stock' => 40, 'unit' => 'botol', 'min_stock' => 8],
            ['category' => 'Sembako', 'name' => 'Gula Pasir 1kg', 'sku' => 'SEM-003', 'price' => 16000, 'stock' => 50, 'unit' => 'kg', 'min_stock' => 10],
            ['category' => 'Sembako', 'name' => 'Tepung Terigu Segitiga Biru 1kg', 'sku' => 'SEM-004', 'price' => 13000, 'stock' => 25, 'unit' => 'kg', 'min_stock' => 5],
            ['category' => 'Sembako', 'name' => 'Telur Ayam', 'sku' => 'SEM-005', 'price' => 2000, 'stock' => 120, 'unit' => 'butir', 'min_stock' => 20],
 
            // Minuman
            ['category' => 'Minuman', 'name' => 'Kopi Sachet Kapal Api', 'sku' => 'MIN-001', 'price' => 2000, 'stock' => 100, 'unit' => 'pcs', 'min_stock' => 15],
            ['category' => 'Minuman', 'name' => 'Teh Celup Sariwangi', 'sku' => 'MIN-002', 'price' => 1000, 'stock' => 150, 'unit' => 'pcs', 'min_stock' => 20],
            ['category' => 'Minuman', 'name' => 'Air Mineral Botol 600ml', 'sku' => 'MIN-003', 'price' => 4000, 'stock' => 80, 'unit' => 'botol', 'min_stock' => 15],
            ['category' => 'Minuman', 'name' => 'Teh Botol Sosro', 'sku' => 'MIN-004', 'price' => 5000, 'stock' => 60, 'unit' => 'botol', 'min_stock' => 10],
            ['category' => 'Minuman', 'name' => 'Susu Kental Manis Frisian Flag', 'sku' => 'MIN-005', 'price' => 12000, 'stock' => 35, 'unit' => 'kaleng', 'min_stock' => 8],
 
            // Makanan Ringan
            ['category' => 'Makanan Ringan', 'name' => 'Chitato Sapi Panggang 68g', 'sku' => 'SNK-001', 'price' => 11000, 'stock' => 40, 'unit' => 'pcs', 'min_stock' => 10],
            ['category' => 'Makanan Ringan', 'name' => 'Biskuit Roma Kelapa', 'sku' => 'SNK-002', 'price' => 9000, 'stock' => 45, 'unit' => 'pcs', 'min_stock' => 10],
            ['category' => 'Makanan Ringan', 'name' => 'Wafer Tango Coklat', 'sku' => 'SNK-003', 'price' => 7000, 'stock' => 55, 'unit' => 'pcs', 'min_stock' => 10],
            ['category' => 'Makanan Ringan', 'name' => 'Permen Kopiko', 'sku' => 'SNK-004', 'price' => 500, 'stock' => 200, 'unit' => 'pcs', 'min_stock' => 30],
 
            // Rokok
            ['category' => 'Rokok', 'name' => 'Rokok Sampoerna Mild 16', 'sku' => 'ROK-001', 'price' => 30000, 'stock' => 25, 'unit' => 'bungkus', 'min_stock' => 5],
            ['category' => 'Rokok', 'name' => 'Rokok Gudang Garam Filter', 'sku' => 'ROK-002', 'price' => 24000, 'stock' => 20, 'unit' => 'bungkus', 'min_stock' => 5],
 
            // Bumbu Dapur
            ['category' => 'Bumbu Dapur', 'name' => 'Bawang Merah', 'sku' => 'BMB-001', 'price' => 4000, 'stock' => 20, 'unit' => 'ons', 'min_stock' => 5],
            ['category' => 'Bumbu Dapur', 'name' => 'Bawang Putih', 'sku' => 'BMB-002', 'price' => 3500, 'stock' => 20, 'unit' => 'ons', 'min_stock' => 5],
            ['category' => 'Bumbu Dapur', 'name' => 'Cabai Merah Keriting', 'sku' => 'BMB-003', 'price' => 5000, 'stock' => 15, 'unit' => 'ons', 'min_stock' => 5],
            ['category' => 'Bumbu Dapur', 'name' => 'Garam Dapur Halus 250g', 'sku' => 'BMB-004', 'price' => 3000, 'stock' => 40, 'unit' => 'pcs', 'min_stock' => 8],
 
            // Perlengkapan Mandi
            ['category' => 'Perlengkapan Mandi', 'name' => 'Sabun Mandi Lifebuoy', 'sku' => 'MND-001', 'price' => 4000, 'stock' => 50, 'unit' => 'pcs', 'min_stock' => 10],
            ['category' => 'Perlengkapan Mandi', 'name' => 'Shampo Sachet Clear', 'sku' => 'MND-002', 'price' => 1000, 'stock' => 100, 'unit' => 'sachet', 'min_stock' => 20],
            ['category' => 'Perlengkapan Mandi', 'name' => 'Pasta Gigi Pepsodent 75g', 'sku' => 'MND-003', 'price' => 9000, 'stock' => 30, 'unit' => 'pcs', 'min_stock' => 8],
 
            // Perlengkapan Rumah Tangga
            ['category' => 'Perlengkapan Rumah Tangga', 'name' => 'Sabun Cuci Piring Sunlight 400ml', 'sku' => 'RMH-001', 'price' => 8500, 'stock' => 35, 'unit' => 'pcs', 'min_stock' => 8],
            ['category' => 'Perlengkapan Rumah Tangga', 'name' => 'Deterjen Rinso Sachet', 'sku' => 'RMH-002', 'price' => 1500, 'stock' => 80, 'unit' => 'sachet', 'min_stock' => 15],
            ['category' => 'Perlengkapan Rumah Tangga', 'name' => 'Baterai ABC AA (isi 2)', 'sku' => 'RMH-003', 'price' => 6000, 'stock' => 25, 'unit' => 'pack', 'min_stock' => 5],
 
            // Obat & Kesehatan
            ['category' => 'Obat & Kesehatan', 'name' => 'Paracetamol Tablet', 'sku' => 'OBT-001', 'price' => 5000, 'stock' => 30, 'unit' => 'strip', 'min_stock' => 5],
            ['category' => 'Obat & Kesehatan', 'name' => 'Minyak Kayu Putih Cap Lang 30ml', 'sku' => 'OBT-002', 'price' => 12000, 'stock' => 20, 'unit' => 'botol', 'min_stock' => 5],
 
            // Makanan Instan
            ['category' => 'Makanan Instan', 'name' => 'Indomie Goreng', 'sku' => 'INS-001', 'price' => 3000, 'stock' => 150, 'unit' => 'pcs', 'min_stock' => 25],
            ['category' => 'Makanan Instan', 'name' => 'Mie Sedaap Soto', 'sku' => 'INS-002', 'price' => 2800, 'stock' => 100, 'unit' => 'pcs', 'min_stock' => 20],
            ['category' => 'Makanan Instan', 'name' => 'Sarden Kaleng ABC', 'sku' => 'INS-003', 'price' => 14000, 'stock' => 20, 'unit' => 'kaleng', 'min_stock' => 5],
 
            // Alat Tulis
            ['category' => 'Alat Tulis', 'name' => 'Buku Tulis Sinar Dunia', 'sku' => 'ATK-001', 'price' => 4000, 'stock' => 40, 'unit' => 'pcs', 'min_stock' => 10],
            ['category' => 'Alat Tulis', 'name' => 'Pulpen Standard AE7', 'sku' => 'ATK-002', 'price' => 2500, 'stock' => 60, 'unit' => 'pcs', 'min_stock' => 15],
        ];
 
        foreach ($products as $item) {
            Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'category_id' => $categories[$item['category']] ?? null,
                    'name'        => $item['name'],
                    'description' => null,
                    'price'       => $item['price'],
                    'stock'       => $item['stock'],
                    'unit'        => $item['unit'],
                    'min_stock'   => $item['min_stock'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
