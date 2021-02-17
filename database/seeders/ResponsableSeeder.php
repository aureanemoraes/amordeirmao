<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponsableSeeder extends Seeder
{
    public function run()
    {
        DB::table('responsables')->insert([
            'user_id' => 6,
            'responsable_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('responsables')->insert([
            'user_id' => 7,
            'responsable_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('responsables')->insert([
            'user_id' => 8,
            'responsable_id' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('responsables')->insert([
            'user_id' => 9,
            'responsable_id' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
