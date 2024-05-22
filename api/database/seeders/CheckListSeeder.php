<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('check_lists')->insert([
            [
                'problem' => 'Issue with lighting',
                'zone' => 'Zone 1',
                'post' => 'Post 1',
                'nbProblems' => 5,
                'isChecked' => true,
                'valideImgUrl' => 'https://example.com/valid1.jpg',
                'notValideImgUrl' => 'https://example.com/notvalid1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'problem' => 'Broken window',
                'zone' => 'Zone 2',
                'post' => 'Post 2',
                'isChecked' => false,
                'nbProblems' => 3,
                'valideImgUrl' => 'https://example.com/valid2.jpg',
                'notValideImgUrl' => 'https://example.com/notvalid2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}
