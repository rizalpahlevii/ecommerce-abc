<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $products = Product::factory()->count(100)->create();
        foreach ($products as $product) $product->addMedia(
            UploadedFile::fake()->image('image.png', 100, 100)
                ->size(100)
        )->toMediaCollection('image');
    }
}
