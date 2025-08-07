<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['category_code' => '11', 'category_name' => 'Sains Alam'],
            ['category_code' => '12', 'category_name' => 'Ilmu Komputer'],
            ['category_code' => '13', 'category_name' => 'Teknik Industri'],
            ['category_code' => '14', 'category_name' => 'Sosial dan Humaniora'],
        ]);
    }
}
