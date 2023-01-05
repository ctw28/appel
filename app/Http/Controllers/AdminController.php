<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuliahLapangan;

class AdminController extends Controller
{
    //

    public function kelompokIndex($kuliahLapanganId, $lokasiId)
    {
        $title = "Pengaturan Kelompok dan Peserta";
        $data = KuliahLapangan::select('id', 'tahun_akademik_id', 'kuliah_lapangan_nama')->with(['ppl', 'tahunAkademik', 'lokasi' => function ($lokasi) use ($lokasiId) {
            $lokasi->with(['kelompok' => function ($kelompok) {
                $kelompok->withCount(['anggota']);
            }])->withCount('kelompok')->find($lokasiId);
        }])->find($kuliahLapanganId);

        // return $data;
        return view("admin.kelompok", compact('title', 'data'));
    }
}
