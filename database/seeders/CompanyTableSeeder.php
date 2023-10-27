<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'company_name' => 'Test Pharmacy',
            'company_address' => 'test location',
            'company_email' => 'testemail@gmail.com',
            'company_phone' =>  '0708080808',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
