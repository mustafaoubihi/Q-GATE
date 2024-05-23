<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUserId = DB::table('users')->where('email', 'admin@example.com')->value('id');
        $normalUserId = DB::table('users')->where('email', 'user@example.com')->value('id');

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
                'nbProblems' => 3,
                'isChecked' => false,
                'valideImgUrl' => 'https://example.com/valid2.jpg',
                'notValideImgUrl' => 'https://example.com/notvalid2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
