<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonateSeeder extends Seeder
{

    public function run()
    {
        // 3 doações do ADMIN
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => 1
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => 1
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => 1
        ]);
        // 20 doações dos fiés
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);
        DB::table('donates')->insert([
            'description' => Str::random(20),
            'donate_type_id' => rand($min = 1, $max = 4),
            'user_id' => rand($min = 6, $max = 9)
        ]);

    }
}
