<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert(['name' => 'English', 'title' => 'English', 'description' => '', 'created_by' => 1, 'active' => 1 ]);
        DB::table('subjects')->insert(['name' => 'Urdu', 'title' => 'Urdu', 'description' => '', 'created_by' => 1, 'active' => 1 ]);
        DB::table('subjects')->insert(['name' => 'Science', 'title' => 'Science', 'description' => '', 'created_by' => 1, 'active' => 1 ]);
        DB::table('subjects')->insert(['name' => 'Mathematics', 'title' => 'Mathematics', 'description' => '', 'created_by' => 1, 'active' => 1 ]);
    }
}
