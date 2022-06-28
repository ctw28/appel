<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PplPembimbingInternal;

class PplNilaiController extends Controller
{
    //
    public function index(Request $request)
    {
        $data['title'] = "Penilaian";
        $data['data'] = PplPembimbingInternal::with([
            // 'ppl.pplLokasi.pplKelompok.pplKelompokAnggota.pplPendaftar',
            // 'ppl.pplLokasi.pplKelompok.pplPembimbing',
            // 'pplPembimbing.pplKelompok.pplLokasi.ppl',
            'pplPembimbing.pplKelompok' => function ($pplKelompok) {
                $pplKelompok->withCount(['pplKelompokAnggota']);
            },
            'pplPembimbing.pplKelompok.pplLokasi',
            'ppl.tahunAjar'
        ])
            // ->whereHas('pplPembimbing.pplKelompok')
            ->where('idpeg', $request->session()->get('data'))
            // ->where('ppl_id', 1)
            ->get();
        // return $data;
        return view('bimbingan-list', $data);
    }
}
