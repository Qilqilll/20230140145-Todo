<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);

        $category = Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Fashion']);

        Product::create([
            'name' => 'Laptop',
            'category_id' => $category->id,
            'qty' => 10,
            'price' => 15000000,
            'user_id' => 1, // Admin
        ]);

        Product::create([
            'name' => 'Smartphone',
            'category_id' => $category->id,
            'qty' => 5,
            'price' => 5000000,
            'user_id' => 2, // Regular User
        ]);
    }
}
