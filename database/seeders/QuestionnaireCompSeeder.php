<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnaireCompSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Body PC',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Kipas',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Motherboard',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'RAM',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Storage',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Cabel',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Monitor',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Mouse',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'e',
            'questionnaire_items' => 'Keyboard',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'f',
            'questionnaire_items' => 'Application',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'f',
            'questionnaire_items' => 'Anti Virus',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'f',
            'questionnaire_items' => 'License',
        ]);
        DB::table('item_questionnaire_surveillances')->insert([
            'questionnaire_category_id' => 'g',
            'questionnaire_items' => 'Baik',
        ]);
    }
}
