<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    public function run()
    {
        //1
        DB::table('users')->insert([
            'name' => 'Administrador',
            'cpf' => '17195876047',
            'email' => 'admin@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'is_admin' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //2
        DB::table('users')->insert([
            'name' => 'diretor um',
            'cpf' => '64373824061',
            'email' => 'diretorum@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //3
        DB::table('users')->insert([
            'name' => 'diretor dois',
            'cpf' => '84086205092',
            'email' => 'diretordois@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //4
        DB::table('users')->insert([
            'name' => 'gerente um',
            'cpf' => '67258289062',
            'email' => 'gerenteum@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //5
        DB::table('users')->insert([
            'name' => 'gerente dois',
            'cpf' => '82398824047',
            'email' => 'gerentedois@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //6
        DB::table('users')->insert([
            'name' => 'fiel um',
            'cpf' => '12498401040',
            'email' => 'fielum@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //7
        DB::table('users')->insert([
            'name' => 'fiel dois',
            'cpf' => '31723681067',
            'email' => 'fieldois@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //8
        DB::table('users')->insert([
            'name' => 'fiel tres',
            'cpf' => '32117286003',
            'email' => 'fieltres@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //9
        DB::table('users')->insert([
            'name' => 'fiel quatro',
            'cpf' => '49956753025',
            'email' => 'fielquatro@teste.com',
            'quality_id' => 1,
            'password' => Hash::make('12345678'),
            'is_validated' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
