<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(2)->create();

        DB::table('master_tahun_ajars')->insert([
            ['tahun' => 2022, "semester"=>"Genap", "sebutan"=>"Tahun Anggaran 2022 Genap","kode"=>"20222"],
        ]);

        DB::table('user_roles')->insert([
            ['nama_role' => 'administrator', "keterangan"=>"admin utama"],
            ['nama_role' => 'admin_fakultas', "keterangan"=>"admin untuk mengelola fakultas"],
            ['nama_role' => 'mahasiswa', "keterangan"=>"akun mahasiswa"],
            ['nama_role' => 'pembimbing', "keterangan"=>"akun pembimbing"],
        ]);
        DB::table('users')->insert([
            [
                'user_role_id' => 1,
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('1234qwer'),
            ]
        ]);


    }
}
