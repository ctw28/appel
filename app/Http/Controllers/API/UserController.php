<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\DataDiri;
use App\Models\Mahasiswa;
use App\Models\MasterProdi;
use App\Models\UserMahasiswa;
use App\Models\Pegawai;
use App\Models\UserPegawai;
use App\Models\PegawaiGelar;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = json_decode($request->data);
            $name = "";
            $roleId = "";
            if ($request->jenis_akun == "mahasiswa") {
                $name = $data->nim;
                $roleId = 3;
            }
            if ($request->jenis_akun == "pegawai") {
                $name = $data->nip;
                $roleId = 4;
            }

            $user = User::create([
                'name' => $name,
                'username' => $request->username,
                'email' => $name . '@mail.com',
                'password' => bcrypt($request->password),
            ]);

            $userRole = UserRole::create([
                'role_id' => $roleId,
                'user_id' => $user->id,
                'aplikasi_id' => 'appel'
            ]);


            if ($request->jenis_akun == "mahasiswa") {
                $dataDiri = DataDiri::create([
                    'nama_lengkap' => $data->nama,
                    'jenis_kelamin' => $data->kelamin,
                    'lahir_tempat' => $data->tmplahir,
                    'lahir_tanggal' => $data->tgllahir,
                    'no_hp' => $data->hp,
                    'alamat_ktp' => $data->alamat,
                    'alamat_domisili' => $data->alamat,
                ]);
                $prodi = MasterProdi::where('prodi_kode', $data->idprodi)->first();
                $mahasiswa = Mahasiswa::create([
                    'iddata' => $data->iddata,
                    'nim' => $data->nim,
                    'data_diri_id' => $dataDiri->id,
                    'master_prodi_id' => $prodi->id,
                ]);
                $userMahasiswa = UserMahasiswa::create([
                    'user_id' => $user->id,
                    'mahasiswa_id' => $mahasiswa->id,
                ]);
            } else {
                $kategoriId = 1;
                $jenisId = 1;
                if ($data->statuspeg == "NON PNS")
                    $kategoriId = 3;
                if ($data->dosentetap == "N")
                    $jenisId = 2;

                //cek dulu apakah sudah terinsert datanya sebagai pegawai atau belum
                //yang sudah itu berarti sudah terinsert pas pilih pembimbing
                //jadi ini pegawai ada 2 cara terinsert, 1 dari pilih pembimbing
                //1 lagi pas dia login
                //bedanya kalau login lgsung dengen usernya terbuat
                $checkPegawai = Pegawai::where('idpeg', $data->idpegawai)->first();
                if (empty($checkPegawai)) {
                    $dataDiri = DataDiri::create([
                        'nama_lengkap' => $data->nama,
                        'jenis_kelamin' => $data->kelamin,
                        'lahir_tempat' => $data->tmplahir,
                        'lahir_tanggal' => $data->tgllahir,
                        'no_hp' => $data->hp,
                        'alamat_ktp' => $data->alamat,
                        'alamat_domisili' => $data->alamat,
                    ]);
                    $pegawai = Pegawai::create([
                        'idpeg' => $data->idpegawai,
                        'pegawai_nomor_induk' => $data->nip,
                        'data_diri_id' => $dataDiri->id,
                        'pegawai_kategori_id' => $kategoriId,
                        'pegawai_jenis_id' => $jenisId,
                    ]);
                    PegawaiGelar::create([
                        'pegawai_id' => $pegawai->id,
                        'gelar_depan' => $data->glrdepan,
                        'gelar_belakang' => $data->glrbelakang,
                        'gelar_tanggal' => "2023-01-01",
                        'is_aktif' => true,
                    ]);
                    UserPegawai::create([
                        'user_id' => $user->id,
                        'pegawai_id' => $pegawai->id,
                    ]);
                } else { //kalau sudah ada datanya sebagai pegawai, lgsung insert saja user pegawai
                    $userPegawai = UserPegawai::create([
                        'user_id' => $user->id,
                        'pegawai_id' => $checkPegawai->id,
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'details' => $user,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return;

            return response()->json([
                'status' => false,
                'message' => $th,
                'details' => [],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
