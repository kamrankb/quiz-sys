<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Company Information
        DB::table('brand_settings')->insert([ 'key_name' => 'logo', 'key_value' => '', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'logo_white', 'key_value' => '', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'company_alias', 'key_value' => 'QZ', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'company_name', 'key_value' => 'Quiz Sys', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'company_phone', 'key_value' => '', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'company_email', 'key_value' => '', 'created_by' => 1 ]);
        DB::table('brand_settings')->insert([ 'key_name' => 'company_address', 'key_value' => '', 'created_by' => 1 ]);
        
    }
}
