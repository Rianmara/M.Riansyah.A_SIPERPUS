<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookshelfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("bookshelves")->insert([
            [
                'code' => 'RAK0A',
                'nama' => 'Mangga',
            ],
            [
                'code' => 'RAK1B',
                'nama' => 'Novel',
            ],
            [
                'code' => 'RAK2C',
                'nama' => 'Kitab Kuning',
            ],
        ]);

    }
}
