<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('donate_types')->insert([
            'name' => 'Oração',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('donate_types')->insert([
            'name' => 'Financeira',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('donate_types')->insert([
            'name' => 'Alimentícia',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('donate_types')->insert([
            'name' => 'Vestimenta',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
