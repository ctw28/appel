<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanFakultasSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(2)->create();

        DB::table('kuliah_lapangan_fakultas')->insert([
            [
                'master_fakultas_id' => 1,
                'sebutan' => 'Pengenalan Lapangan Persekolahan',
                'singkatan' => 'PLP',
                'sebutan_eksternal' => 'Pamong',
            ],
            [
                'master_fakultas_id' => 2,
                'sebutan' => 'Program Pengalaman Lapangan',
                'singkatan' => 'PPL / Magang',
                'sebutan_eksternal' => 'Supervisor',
            ],
            [
                'master_fakultas_id' => 3,
                'sebutan' => 'Program Pengalaman Lapangan',
                'singkatan' => 'PPL / Magang',
                'sebutan_eksternal' => 'Supervisor',
            ],
            [
                'master_fakultas_id' => 4,
                'sebutan' => 'Program Pengalaman Lapangan',
                'singkatan' => 'PPL / Magang',
                'sebutan_eksternal' => 'Supervisor',
            ],
        ]);
    }
}
