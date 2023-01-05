<?php

namespace App\Http\Controllers;

use App\Models\KuliahLapangan;

class LokasiController extends Controller
{
    //
    public function index($kuliahLapanganId)
    {
        $data['title'] = "Kelola Lokasi PLP";
        $data['data'] = KuliahLapangan::with(['lokasi' => function ($lokasi) {
            $lokasi->withCount('kelompok');
        }, 'tahunAkademik'])->find($kuliahLapanganId);
        // return $data;
        return view('admin.lokasi', $data);
    }
}
