<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        DB::table('managers')->insert([
            'user_id' => 4,
            'director_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('managers')->insert([
            'user_id' => 5,
            'director_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
