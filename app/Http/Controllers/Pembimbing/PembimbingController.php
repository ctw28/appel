<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PplPembimbingInternal;
use App\Models\PplKelompok;
use App\Models\PplNilai;
use App\Models\PplLkh;
use App\Models\PplPendaftar;
use Carbon\Carbon;

class PembimbingController extends Controller
{
    //
    public function index(Request $request)
    {
        $data['title'] = "Dashboard";
        $data['data'] = PplPembimbingInternal::with([
            // 'ppl.pplLokasi.pplKelompok.pplKelompokAnggota.pplPendaftar',
            // 'ppl.pplLokasi.pplKelompok.pplPembimbing',
            // 'pplPembimbing.pplKelompok.pplLokasi.ppl',
            'pplPembimbing.pplKelompok' => function ($pplKelompok) {
                $pplKelompok->withCount(['pplKelompokAnggota']);
            },
            'pplPembimbing.pplKelompok.pplLokasi',
            'ppl'
        ])
            // ->whereHas('pplPembimbing.pplKelompok')
            ->where('idpeg', $request->session()->get('data'))
            // ->where('ppl_id', 1)
            ->get();
        // return $data;
        return view('pembimbing.dashboard', $data);
    }

    public function list(Request $request)
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
        return view('pembimbing.bimbingan-list', $data);
    }
    public function nilaiInput($kelompokId)
    {
        $data['title'] = "Input Nilai";
        $data['data'] = PplKelompok::with([
            'pplKelompokAnggota.pplPendaftar',
            'pplKelompokAnggota.pplNilai',
            'pplKelompokAnggota.kelompokJabatan',
            'pplLokasi'
        ])->find($kelompokId);
        // return $data;
        return view('pembimbing.nilai-input', $data);
    }

    public function nilaiStore($kelompokId, Request $request)
    {
        // return $request->all();
        try {
            //code...
            $i = 0;
            $data = [];
            foreach ($request->nilai as $key => $value) {
                $data[$i]['ppl_kelompok_anggota_id'] = $key;
                $data[$i]['nilai'] = $value;
                $data[$i]['sumber_nilai'] = 'internal';
                $data[$i]['created_at'] =  Carbon::now();
                $data[$i]['updated_at'] = Carbon::now();
                $i++;
                $nilai = PplNilai::where('ppl_kelompok_anggota_id', $key)->delete();
            }
            PplNilai::insert($data);
            return redirect()->back()->with('info', 'Nilai Berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('info', 'Nilai Gagal ditambahkan');
        }
    }

    public function detailKelompok($kelompokId)
    {

        $data['title'] = "Detail Kelompok";
        // $data['data'] = PplPendaftar::with([
        //     'ppl',
        //     'pplKelompokAnggota.pplKelompok.pplLokasi',
        //     'pplKelompokAnggota.kelompokJabatan',
        //     'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        //     // 'pplKelompokAnggota.pplPendaftar',
        // ])
        //     ->get();
        $data['data'] = PplKelompok::with([
            'pplKelompokAnggota.pplPendaftar',
            'pplLokasi.ppl.tahunAjar',
            'pplPembimbing.pplPembimbingInternal'
        ])
            ->where('id', $kelompokId)->get();


        // return $data;
        return view('pembimbing.bimbingan-detail', $data);
    }

    public function detailLkh($kelompokId, $id)
    {
        $data['title'] = "Detail LKH";

        $lkh = PplLkh::where('ppl_kelompok_anggota_id', $id)->first();
        $tglIndo = Carbon::parse($lkh->tgl_lkh)->locale('id');
        $tglIndo->settings(['formatFunction' => 'translatedFormat']);
        $lkh->tgl_lkh = $tglIndo->format('j F Y');;
        $data['data'] = $lkh;
        // $data['data'] = PplKelompok::with([
        //     'pplKelompokAnggota.pplPendaftar',
        //     'pplKelompokAnggota.pplLkh',
        //     'pplLokasi.ppl.tahunAjar',
        //     'pplPembimbing.pplPembimbingInternal'
        // ])
        //     ->whereHas('pplKelompokAnggota', function ($pplKelompokAnggota) use ($id) {
        //         $pplKelompokAnggota->where('ppl_pendaftar_id', $id);
        //     })
        //     ->where('id', $kelompokId)->get();
        // return $data;

        return view('pembimbing.bimbingan-lkh-detail', $data);
    }
}
