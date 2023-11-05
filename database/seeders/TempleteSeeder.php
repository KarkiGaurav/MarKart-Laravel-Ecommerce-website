<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    DB::table('templates')->insert([
        [
            'template_title' => 'default',
            'template_name' => 'default',
            'current_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'template_title' => 'lpv23',
            'template_name' => 'lpv23',
            'current_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}

}
