<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário Administrador de Teste
        DB::table('users')->insert([
            'name' => 'Thalles',
            'email' => 'thalles_leopoldino@outlook.com',
            'password' => bcrypt('1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Mais um usuário de teste
        DB::table('users')->insert([
            'name' => 'Leitor Comum',
            'email' => 'leitor@teste.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
