<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Duplicate is not allowed
        $categories = [
            [
                'name'          => 'PHP Programming',
                'created_at'    => NOW(),
                'updated_at'    => NOW(),
            ],
            [
                'name'          => 'Database Administration',
                'created_at'    => NOW(),
                'updated_at'    => NOW(),
            ],
            [
                'name'          => 'Laravel Framework',
                'created_at'    => NOW(),
                'updated_at'    => NOW(),
            ]
        ];

        $this->category->insert($categories);
    }
}
