<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('11221122'),
                'role' => 'admin',
            ],
            [
                'nama' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('11221122'),
                'role' => 'user',
            ],
        ];

        DB::table('users')->insert($userData);

        DB::table('harga_pokoks')->insert([
            'admin_id' => '1',
            'harga_pokok' => '5000',
            'keuntungan' => '1000',
            'insentif' => '1000',
        ]);

        DB::table('harga_juals')->insert([
            'user_id' => '2',
            'harga_pokok_id' => '1',
            'harga_jual' => '1000',
        ]);
    }
}
