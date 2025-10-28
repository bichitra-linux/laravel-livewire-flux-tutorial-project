<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [

        ['name' => 'Politics', 'slug' => 'politics'],
        ['name' => 'Tech', 'slug' => 'tech'],
        ['name' => 'Culture', 'slug' => 'culture'],
        ['name' => 'Business', 'slug' => 'business'],
        ['name' => 'World', 'slug' => 'world'],

        ];

        foreach ($items as $it) {
            Category::firstOrCreate(['slug' => $it['slug']], $it);
        }
    }
}
