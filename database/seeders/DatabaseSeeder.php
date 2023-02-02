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

        DB::table('provinsis')->insert([
            [
                'provinsi_nama' => 'Sulawesi Tenggara',
            ],
            [
                'provinsi_nama' => 'Sulawesi Selatan',
            ],
        ]);

        DB::table('jenis_kabupatens')->insert([
            [
                'jenis' => 'Kota',
            ],
            [
                'jenis' => 'Kabupaten',
            ],
        ]);


        DB::table('kabupatens')->insert([
            [
                'id_provinsi' => 1,
                'jenis_kabupaten_id' => 1,
                'kabupaten_nama' => 'Kota Kendari',
            ],
            [
                'id_provinsi' => 1,
                'jenis_kabupaten_id' => 2,
                'kabupaten_nama' => 'Konawe Selatan',
            ],
            [
                'id_provinsi' => 2,
                'jenis_kabupaten_id' => 2,
                'kabupaten_nama' => 'Gowa',
            ],
            [
                'id_provinsi' => 2,
                'jenis_kabupaten_id' => 1,
                'kabupaten_nama' => 'Kota Pare-Pare',
            ],
        ]);
        DB::table('kecamatans')->insert([
            [
                'kabupaten_id' => 1,
                'kecamatan_nama' => 'Wua-Wua',
            ],
            [
                'kabupaten_id' => 1,
                'kecamatan_nama' => 'Kendari Barat',
            ],
            [
                'kabupaten_id' => 2,
                'kecamatan_nama' => 'Ranomeeto',
            ],
            [
                'kabupaten_id' => 3,
                'kecamatan_nama' => 'Gowa Kecamatan',
            ],
            [
                'kabupaten_id' => 4,
                'kecamatan_nama' => 'Pare Kecamatan',
            ],


        ]);
        // \App\Models\User::factory(2)->create();

        // $fatik = "Fakultas Tarbiyah dan Ilmu Keguruan";
        // $febi = "Fakultas Ekonomi dan Bisnis Islam";
        // $fasya = "Fakultas Syariah";
        // $fuad = "Fakultas Ushuluddin Adab dan Dakwah";
        // $pascasarjana = "Pascasarjana";

        // DB::table('master_tahun_akademiks')->insert([
        //     ['tahun' => 2022, "semester" => "Genap", "sebutan" => "Tahun Akademik 2021/2022 Genap", "kode" => "20212"],
        // ]);
        // DB::table('master_jabatan_pegawais')->insert([
        //     [
        //         'jabatan_nama' => "Rektor",
        //         "jabatan_singkatan" => "Rektor",
        //         "jabatan_keterangan" => "Pimpinan Universitas",
        //         "jabatan_untuk" => "pegawai",
        //         "jabatan_urutan" => "1",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Rektor 1",
        //         "jabatan_singkatan" => "Warek 1",
        //         "jabatan_keterangan" => "Wakil Rektor Urusan ....",
        //         "jabatan_untuk" => "pegawai",
        //         "jabatan_urutan" => "2",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Rektor 2",
        //         "jabatan_singkatan" => "Rektor",
        //         "jabatan_keterangan" => "Wakil Rektor Urusan ....",
        //         "jabatan_untuk" => "pegawai",
        //         "jabatan_urutan" => "3",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Rektor 3",
        //         "jabatan_singkatan" => "Rektor",
        //         "jabatan_keterangan" => "Wakil Rektor Urusan ....",
        //         "jabatan_untuk" => "pegawai",
        //         "jabatan_urutan" => "4",
        //     ],
        //     [
        //         'jabatan_nama' => "Kepala Biro AUAK",
        //         "jabatan_singkatan" => "Karo",
        //         "jabatan_keterangan" => "Kepala Pegawai",
        //         "jabatan_untuk" => "pegawai",
        //         "jabatan_urutan" => "5",
        //     ],
        //     [
        //         'jabatan_nama' => "Dekan",
        //         "jabatan_singkatan" => "Dekan",
        //         "jabatan_keterangan" => "Pimpinan Fakultas",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "20",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Dekan 1",
        //         'jabatan_singkatan' => "Wadek 1",
        //         "jabatan_keterangan" => "Wakil Pimpinan Fakultas 1",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "21",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Dekan 2",
        //         'jabatan_singkatan' => "Wadek 2",
        //         "jabatan_keterangan" => "Wakil Pimpinan Fakultas 2",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "22",
        //     ],
        //     [
        //         'jabatan_nama' => "Wakil Dekan 3",
        //         'jabatan_singkatan' => "Wadek 1",
        //         "jabatan_keterangan" => "Wakil Pimpinan Fakultas 3",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "23",
        //     ],
        //     [
        //         'jabatan_nama' => "Direktur",
        //         'jabatan_singkatan' => "Direktur",
        //         "jabatan_keterangan" => "Pimpinan Pascasarjana",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "24",
        //     ],
        //     [
        //         'jabatan_nama' => "Kepala Prodi",
        //         'jabatan_singkatan' => "Kaprodi",
        //         "jabatan_keterangan" => "Pimpinan Prodi",
        //         "jabatan_untuk" => "fakultas",
        //         "jabatan_urutan" => "25",
        //     ],
        // ]);

        // DB::table('master_jenjangs')->insert([
        //     [
        //         "jenjang_nama" => "Strata 1",
        //         "jenjang_singkatan" => "S1",
        //         "jenjang_gelar" => "Sarjana",
        //         "jenjang_kode_dikti" => "30",
        //         "sebutan_tugas_akhir" => "Skripsi",
        //     ],
        //     [
        //         "jenjang_nama" => "Strata 2",
        //         "jenjang_singkatan" => "S2",
        //         "jenjang_gelar" => "Magister",
        //         "jenjang_kode_dikti" => "35",
        //         "sebutan_tugas_akhir" => "Tesis",
        //     ],
        //     [
        //         "jenjang_nama" => "Strata 3",
        //         "jenjang_singkatan" => "S3",
        //         "jenjang_gelar" => "Doktor",
        //         "jenjang_kode_dikti" => "0",
        //         "sebutan_tugas_akhir" => "Disertasi",
        //     ],
        // ]);

        // DB::table('master_fakultas')->insert([
        //     [
        //         "master_jenjang_id" => 1,
        //         "fakultas_nama" => $fatik,
        //         "fakultas_singkatan" => "FTIK",
        //         "is_fakultas" => "1",
        //         "fakultas_visi" => "Visi Fakultas $fatik",
        //         "fakultas_misi" => "Misi Fakultas $fatik",
        //         "fakultas_keterangan" => "Keterangan Fakultas",
        //     ],
        //     [
        //         "master_jenjang_id" => 1,
        //         "fakultas_nama" => $febi,
        //         "fakultas_singkatan" => "FEBI",
        //         "is_fakultas" => "1",
        //         "fakultas_visi" => "Visi Fakultas $febi",
        //         "fakultas_misi" => "Misi Fakultas $febi",
        //         "fakultas_keterangan" => "Keterangan Fakultas",
        //     ],
        //     [
        //         "master_jenjang_id" => 1,
        //         "fakultas_nama" => $fasya,
        //         "fakultas_singkatan" => "FAKSYA",
        //         "is_fakultas" => "1",
        //         "fakultas_visi" => "Visi Fakultas $fasya",
        //         "fakultas_misi" => "Misi Fakultas $fasya",
        //         "fakultas_keterangan" => "Keterangan Fakultas",
        //     ],
        //     [
        //         "master_jenjang_id" => 1,
        //         "fakultas_nama" => $fuad,
        //         "fakultas_singkatan" => "FUAD",
        //         "is_fakultas" => "1",
        //         "fakultas_visi" => "Visi Fakultas $fuad",
        //         "fakultas_misi" => "Misi Fakultas $fuad",
        //         "fakultas_keterangan" => "Keterangan Fakultas",
        //     ],
        //     [
        //         "master_jenjang_id" => 2,
        //         "fakultas_nama" => $pascasarjana,
        //         "fakultas_singkatan" => "PASCASARJANA",
        //         "is_fakultas" => "0",
        //         "fakultas_visi" => "Visi Fakultas $pascasarjana",
        //         "fakultas_misi" => "Misi Fakultas $pascasarjana",
        //         "fakultas_keterangan" => "Keterangan PASCASARJANA",
        //     ],
        // ]);
        // DB::table('roles')->insert([
        //     ['nama_role' => 'administrator', "keterangan" => "admin utama"],
        //     ['nama_role' => 'admin_fakultas', "keterangan" => "admin untuk mengelola fakultas"],
        //     ['nama_role' => 'mahasiswa', "keterangan" => "akun mahasiswa"],
        //     ['nama_role' => 'pembimbing', "keterangan" => "akun pembimbing"],
        //     ['nama_role' => 'eksternal', "keterangan" => "akun pembimbing dari luar kampus"],
        //     ['nama_role' => 'tenaga_kependidikan', "keterangan" => "akun pegawai"],
        //     ['nama_role' => 'dosen', "keterangan" => "akun dosen"],
        // ]);
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Administrator',
        //         'username' => 'admin',
        //         'email' => 'admin@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Mahasiswa',
        //         'username' => 'mhs',
        //         'email' => 'mhs@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Pembimbing',
        //         'username' => 'pembimbing',
        //         'email' => 'pembimbing@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Admin Fakultas Tarbiyah dan Ilmu Keguruan',
        //         'username' => 'admin_ftik',
        //         'email' => 'admin_ftik@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Admin Fakultas Ekonomi dan Bisnis Islam',
        //         'username' => 'admin_febi',
        //         'email' => 'admin_febi@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Admin Fakultas Syariah',
        //         'username' => 'admin_fasya',
        //         'email' => 'admin_fasya@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],
        //     [
        //         'name' => 'Admin Fakultas Ushuluddin Adab dan Dakwah',
        //         'username' => 'admin_fuad',
        //         'email' => 'admin_fuad@mail.com',
        //         'password' => bcrypt('1234qwer'),
        //     ],

        // ]);

        // DB::table('user_roles')->insert([
        //     ["user_id" => 1, "role_id" => 1, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 2, "role_id" => 3, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 3, "role_id" => 4, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 4, "role_id" => 2, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 5, "role_id" => 2, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 6, "role_id" => 2, "aplikasi_id" => 'appel', 'is_default' => true],
        //     ["user_id" => 7, "role_id" => 2, "aplikasi_id" => 'appel', 'is_default' => true],
        // ]);

        // DB::table('master_prodis')->insert([

        //     [
        //         "master_fakultas_id" => 5,
        //         "prodi_kode" => "ESY",
        //         "prodi_nama" => "Ekonomi Syariah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_urutan" => 1,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 5,
        //         "prodi_kode" => "HI",
        //         "prodi_nama" => "Hukum Keluarga Islam (Ahwal Syakhshiyyah)",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 5,
        //         "prodi_kode" => "MPI",
        //         "prodi_nama" => "Manajemen Pendidikan Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 5,
        //         "prodi_kode" => "PAIS",
        //         "prodi_nama" => "Pendidikan Agama Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "BING",
        //         "prodi_nama" => "Tadris Bahasa Inggris",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "BLG",
        //         "prodi_nama" => "Tadris Biologi",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "FSK",
        //         "prodi_nama" => "Tadris Fisika",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "IPA",
        //         "prodi_nama" => "Tadris IPA",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "KI",
        //         "prodi_nama" => "Manajemen Pendidikan Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "MTK",
        //         "prodi_nama" => "Tadris Matematika",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PAI",
        //         "prodi_nama" => "Pendidikan Agama Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PAID",
        //         "prodi_nama" => "Pendidikan Agama Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan",
        //         "is_aktif" => false
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PBA",
        //         "prodi_nama" => "Pendidikan Bahasa Arab",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PGMI",
        //         "prodi_nama" => "Pendidikan Guru Madrasah Ibtidaiyah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PGMID",
        //         "prodi_nama" => "Pendidikan Guru Madrasah Ibtidaiyah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PGRA",
        //         "prodi_nama" => "Pendidikan Islam Anak Usia Dini",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 1,
        //         "prodi_kode" => "PGRAD",
        //         "prodi_nama" => "Pendidikan Guru Raudhatul Athfal",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan",
        //         "is_aktif" => false
        //     ],
        //     [
        //         "master_fakultas_id" => 3,
        //         "prodi_kode" => "AS",
        //         "prodi_nama" => "Hukum Keluarga Islam (Ahwal Syakhshiyyah)",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 3,
        //         "prodi_kode" => "HTN",
        //         "prodi_nama" => "Hukum Tatanegara (Siyasah Syar'iyyah)",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 3,
        //         "prodi_kode" => "MU",
        //         "prodi_nama" => "Hukum Ekonomi Syariah (Mua'malah)",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "BPI",
        //         "prodi_nama" => "Bimbingan Penyuluhan Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "IHD",
        //         "prodi_nama" => "Ilmu Hadis",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan",
        //         "is_aktif" => false
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "IQT",
        //         "prodi_nama" => "Ilmu Al-Qur'an dan Tafsir",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "KPI",
        //         "prodi_nama" => "Komunikasi dan Penyiaran Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "MD",
        //         "prodi_nama" => "Manajemen Dakwah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "PMI",
        //         "prodi_nama" => "Pengembangan Masyarakat Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 4,
        //         "prodi_kode" => "SKI",
        //         "prodi_nama" => "Sejarah dan Kebudayaan Islam",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan",
        //         "is_aktif" => false
        //     ],
        //     [
        //         "master_fakultas_id" => 2,
        //         "prodi_kode" => "EI",
        //         "prodi_nama" => "Ekonomi Syariah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 2,
        //         "prodi_kode" => "MBS",
        //         "prodi_nama" => "Manajemen Bisnis Syariah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ],
        //     [
        //         "master_fakultas_id" => 2,
        //         "prodi_kode" => "PBS",
        //         "prodi_nama" => "Perbankan Syariah",
        //         "prodi_visi" => "visi",
        //         "prodi_misi" => "misi", "prodi_urutan" => 1, "is_aktif" => true,
        //         "prodi_keterangan" => "keterangan"
        //     ]

        // ]);
        // DB::table('user_fakultas')->insert([
        //     ['user_id' => 4, "master_fakultas_id" => 1],
        //     ['user_id' => 5, "master_fakultas_id" => 2],
        //     ['user_id' => 6, "master_fakultas_id" => 3],
        //     ['user_id' => 7, "master_fakultas_id" => 4],
        // ]);

        // DB::table('kuliah_lapangan_jabatans')->insert([
        //     ['nama_jabatan' => 'Peserta', "keterangan" => "sebagai peserta"],
        // ]);

        // DB::table('pegawai_kategoris')->insert([
        //     ['pegawai_kategori_nama' => 'Pegawai Negeri Sipil', "singkatan" => "PNS", 'is_asn' => true, 'sebutan_nomor_pegawai' => 'NIP'],
        //     ['pegawai_kategori_nama' => 'Pegawai Pemerintah dengan Perjanjian Kerja', "singkatan" => "PPPK", 'is_asn' => true, 'sebutan_nomor_pegawai' => 'NI PPPK'],
        //     ['pegawai_kategori_nama' => 'Non-ASN', "singkatan" => "Non-ASN", 'is_asn' => false, 'sebutan_nomor_pegawai' => 'Nomor Pegawai'],
        // ]);
        // DB::table('pegawai_jenis')->insert([
        //     [
        //         'pegawai_jenis_nama' => 'Tenaga Kependidikan',
        //         "singkatan" => "Tendik",
        //         "alias" => "Pegawai",
        //         'is_dosen' => false,
        //         'if_asn' => true
        //     ],
        //     [
        //         'pegawai_jenis_nama' => 'Tenaga Pendidik',
        //         "singkatan" => "Dosen",
        //         "alias" => "Dosen",
        //         'is_dosen' => true,
        //         'if_asn' => true
        //     ],
        //     [
        //         'pegawai_jenis_nama' => 'Non-PNS',
        //         "singkatan" => "Non-PNS",
        //         "alias" => "Honorer",
        //         'is_dosen' => false,
        //         'if_asn' => false
        //     ],
        // ]);

        // DB::table('kuliah_lapangan_fakultas')->insert([
        //     [
        //         'master_fakultas_id' => 1,
        //         'sebutan' => 'Pengenalan Lapangan Persekolahan',
        //         'singkatan' => 'PLP',
        //         'sebutan_eksternal' => 'Pamong',
        //     ],
        //     [
        //         'master_fakultas_id' => 2,
        //         'sebutan' => 'Program Pengalaman Lapangan',
        //         'singkatan' => 'PPL / Magang',
        //         'sebutan_eksternal' => 'Supervisor',
        //     ],
        //     [
        //         'master_fakultas_id' => 3,
        //         'sebutan' => 'Program Pengalaman Lapangan',
        //         'singkatan' => 'PPL / Magang',
        //         'sebutan_eksternal' => 'Supervisor',
        //     ],
        //     [
        //         'master_fakultas_id' => 4,
        //         'sebutan' => 'Program Pengalaman Lapangan',
        //         'singkatan' => 'PPL / Magang',
        //         'sebutan_eksternal' => 'Supervisor',
        //     ],
        // ]);
    }
}
