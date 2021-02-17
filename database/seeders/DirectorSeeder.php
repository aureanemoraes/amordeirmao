<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectorSeeder extends Seeder
{
    public function run()
    {
        DB::table('directors')->insert([
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('directors')->insert([
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
