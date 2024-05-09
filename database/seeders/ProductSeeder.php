<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'title' => 'چای لاهیجان ممتاز',
            'description' => 'چای سیاه',
            'price' => 250_000,
            'pic_url' => "black-tea.webp",
            'stock' => 10,
            'amount' => 1,
            'category_id' => 1,
        ]);

        Product::factory()->create([
            'title' => 'چای لاهیجان درجه یک',
            'description' => 'چای سبز',
            'price' => 350_000,
            'pic_url' => "green-tea.webp",
            'stock' => 15,
            'amount' => 1,
            'category_id' => 1,
        ]);

        Product::factory()->create([
            'title' => 'بادام تازه',
            'description' => 'محصول آستانه اشرفیه',
            'price' => 300_000,
            'pic_url' => "peanut.jpeg",
            'stock' => 20,
            'amount' => 5,
            'category_id' => 2,
        ]);

        Product::factory()->create([
            'title' => 'برنج هاشمی',
            'description' => 'محصول آستانه اشرفیه',
            'price' => 120_000,
            'pic_url' => "rice.jpg",
            'stock' => 20,
            'amount' => 10,
            'category_id' => 3,
        ]);
    }
}
