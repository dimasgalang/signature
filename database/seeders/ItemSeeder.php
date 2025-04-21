<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            'productName' => 'Benang',
        ]);
        DB::table('items')->insert([
            'productName' => 'Kain',
        ]);
        DB::table('items')->insert([
            'productName' => 'PC Baru',
        ]);
    }
}
