<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuliahLapangan;
use App\Models\Pembimbing;
use App\Models\DataDiri;
use App\Models\Pegawai;
use App\Models\PegawaiGelar;


class PembimbingController extends Controller
{
    //
    public function index(Request $request, $kuliahLapanganId, $limit)
    {
        // $searchQuery = $request->query('search');
        if ($limit == 0) {

            $data['data'] = Pembimbing::with('pegawai.dataDiri')->where('kuliah_lapangan_id', $kuliahLapanganId)
                ->get();
        } else {
            $data['data'] = Pembimbing::with('pegawai.dataDiri')->where('kuliah_lapangan_id', $kuliahLapanganId)
                // ->where('lokasi', 'LIKE', '%' . $searchQuery . '%')
                ->paginate($limit);
        }
        return $data;
    }
    public function add($kuliahLapanganId)
    {
        $data['title'] = "Pembimbing Internal";
        $data['data'] = KuliahLapangan::find($kuliahLapanganId);
        return view('admin.pembimbing', $data);
    }

    public function store(Request $request, $kuliahLapanganId)
    {
        // return $request->all();
        try {
            $checkPegawai = Pegawai::where('idpeg', $request->idpeg)->first();
            if (empty($checkPegawai)) {
                $dataDiri = DataDiri::create([
                    'nama_lengkap' => ($request->nama_lengkap != '') ? $request->nama_lengkap : '-',
                    'jenis_kelamin' => ($request->jenis_kelamin != '') ? $request->jenis_kelamin : 'L',
                    'lahir_tempat' => ($request->lahir_tempat != '') ? $request->lahir_tempat : '-',
                    'lahir_tanggal' => ($request->lahir_tanggal != 'null') ? $request->lahir_tanggal : '2022-01-01',
                    'no_hp' => ($request->no_hp != '') ? $request->no_hp : '-',
                    'alamat_ktp' => ($request->alamat_ktp != '') ? $request->alamat_ktp : '-',
                    'alamat_domisili' => ($request->alamat_ktp != '') ? $request->alamat_ktp : '-',
                ]);
                $kategoriId = 1;
                $jenisId = 1;
                if ($request->statuspeg == "NON PNS")
                    $kategoriId = 3;
                if ($request->dosentetap == "N")
                    $jenisId = 2;

                $pegawai = Pegawai::create([
                    'idpeg' => ($request->idpeg != '') ? $request->idpeg : '-',
                    'pegawai_nomor_induk' => ($request->pegawai_nomor_induk != '') ? $request->pegawai_nomor_induk : '-',
                    'data_diri_id' => $dataDiri->id,
                    'pegawai_kategori_id' => $kategoriId,
                    'pegawai_jenis_id' => $jenisId,
                ]);
                PegawaiGelar::create([
                    'pegawai_id' => $pegawai->id,
                    'gelar_depan' => $request->glrdepan,
                    'gelar_belakang' => $request->glrbelakang,
                    'gelar_tanggal' => "2023-01-01",
                    'is_aktif' => true,
                ]);
                Pembimbing::create([
                    'kuliah_lapangan_id' => $kuliahLapanganId,
                    'pegawai_id' => $pegawai->id,
                ]);
                return array("status" => true);
            }
            Pembimbing::create([
                'kuliah_lapangan_id' => $kuliahLapanganId,
                'pegawai_id' => $checkPegawai->id,
            ]);
            return array("status" => true);
        } catch (\Throwable $th) {
            // return array("status" => false);
            throw $th;
        }
    }

    public function destroy(Request $request, $kuliahLapanganId)
    {
        try {
            $data = Pembimbing::find($request->id);
            $data->delete();
            return array("status" => true);
        } catch (\Throwable $th) {
            return array("status" => false, 'pesan' => $th);
            throw $th;
        }
    }
}
