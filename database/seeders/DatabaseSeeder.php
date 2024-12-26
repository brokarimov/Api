<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeCharacteristic;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Post;
use App\Models\User;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        for ($i=0; $i < 10; $i++) { 
            Category::create([
                'name' => 'Category' . $i,
            ]);
        }
        for ($i=0; $i < 10; $i++) { 
            Attribute::create([
                'name' => 'Attribute' . $i,
                'category_id' => rand(1,10),
            ]);
        }
        for ($i=0; $i < 10; $i++) { 
            Characteristic::create([
                'name' => 'Characteristic' . $i,
            ]);
        }
        for ($i=0; $i < 100; $i++) { 
            AttributeCharacteristic::create([
                'attribute_id' => rand(1,10),
                'characteristic_id'=> rand(1,10),
            ]);
        }
        for ($i=1; $i <= 50; $i++) { 
            Post::create([
                'title' => 'Post' . $i,
                'category_id'=> rand(1,10),
                'description' => 'Post'. $i. ' Description',
                'text' => 'Post'. $i. ' Text',
                'image' => 'Post'. $i. ' Image',
            ]);
        }
    }
}
