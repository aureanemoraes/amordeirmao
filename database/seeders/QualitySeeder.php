<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('qualities')->insert([
            'name' => 'Qualidade 1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('qualities')->insert([
            'name' => 'Qualidade 2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('qualities')->insert([
            'name' => 'Qualidade 3',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
