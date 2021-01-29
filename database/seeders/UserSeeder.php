<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'nane',
            'cpf' => '00607092270',
            'email' => 'nane@nane.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
