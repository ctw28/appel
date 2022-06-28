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
            ['tahun' => 2022, "semester" => "Genap", "sebutan" => "Tahun Akademik 2021/2022 Genap", "kode" => "20212"],
        ]);


        DB::table('user_roles')->insert([
            ['nama_role' => 'administrator', "keterangan" => "admin utama"],
            ['nama_role' => 'admin_fakultas', "keterangan" => "admin untuk mengelola fakultas"],
            ['nama_role' => 'mahasiswa', "keterangan" => "akun mahasiswa"],
            ['nama_role' => 'pembimbing', "keterangan" => "akun pembimbing"],
            ['nama_role' => 'eksternal', "keterangan" => "akun pembimbing dari luar kampus"],
        ]);
        DB::table('users')->insert([
            [
                'user_role_id' => 1,
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('1234qwer'),
            ],
            [
                'user_role_id' => 3,
                'name' => 'Mahasiswa',
                'username' => 'mhs',
                'email' => 'mhs@mail.com',
                'password' => bcrypt('1234qwer'),
            ],
            [
                'user_role_id' => 4,
                'name' => 'Pembimbing',
                'username' => 'pembimbing',
                'email' => 'pembimbing@mail.com',
                'password' => bcrypt('1234qwer'),
            ],
        ]);

        DB::table('kelompok_jabatans')->insert([
            ['nama_jabatan' => 'Peserta', "keterangan" => "sebagai peserta"],
        ]);
    }
}
