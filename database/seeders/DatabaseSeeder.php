<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Category::create([
            'name' => 'Category 1',
        ]);
        \App\Models\Category::create([
            'name' => 'Category 2',
        ]);


        \App\Models\Product::create([
            'category_id' => 1,
            'name' => 'Product 1',
            'price' => 100,
            'desc' => 'This is product 1',
        ]);

        \App\Models\Product::create([
            'category_id' => 1,
            'name' => 'Product 2',
            'price' => 200,
            'desc' => 'This is product 2',
        ]);

        \App\Models\Product::create([
            'category_id' => 2,
            'name' => 'Product 3',
            'price' => 300,
            'desc' => 'This is product 3',
        ]);

        \App\Models\Product::create([
            'category_id' => 2,
            'name' => 'Product 4',
            'price' => 400,
            'desc' => 'This is product 4',
        ]);
    }
}
