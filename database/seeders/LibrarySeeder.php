<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarySeeder extends Seeder
{
    public function run()
    {
        // 1. Add Categories
        DB::table('category')->insert([
            ['category_name' => 'Technology'],
            ['category_name' => 'Science'],
            ['category_name' => 'Fiction'],
            ['category_name' => 'History'],
        ]);

        // 2. Add Patrons
        DB::table('patron')->insert([
            ['first_name' => 'Mark', 'last_name' => 'De Guzman', 'email' => 'mark@test.com', 'account_status' => 'active'],
            ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@test.com', 'account_status' => 'active'],
            ['first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane@test.com', 'account_status' => 'active'],
        ]);

        // 3. Add Books
        DB::table('book')->insert([
            [
                'title' => 'Introduction to Laravel',
                'author' => 'Taylor Otwell',
                'isbn' => '978-1234567890',
                'category_id' => 1, // Technology
                'location' => 'Shelf A1',
                'availability_status' => 'available'
            ],
            [
                'title' => 'Physics for Engineers',
                'author' => 'Albert Einstein',
                'isbn' => '978-0987654321',
                'category_id' => 2, // Science
                'location' => 'Shelf B2',
                'availability_status' => 'available'
            ],
            [
                'title' => 'Philippine History',
                'author' => 'Teodoro Agoncillo',
                'isbn' => '978-1122334455',
                'category_id' => 4, // History
                'location' => 'Shelf C3',
                'availability_status' => 'available'
            ]
        ]);
    }
}