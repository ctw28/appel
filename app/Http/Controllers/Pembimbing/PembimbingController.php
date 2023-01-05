<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PplPembimbingInternal;
use App\Models\PplKelompok;
use App\Models\PplNilai;
use App\Models\PplLkh;
use App\Models\Pembimbing;
use App\Models\Kelompok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    //
    public function index()
    {
        // return Auth::user()->userPegawai->pegawai_id;
        $data['title'] = "Dashboard";
        // $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
        //     $kuliahLapangan->with(['tahunAkademik', 'lokasi.kelompok.anggota.pendaftar.mahasiswa.dataDiri'])->where(['is_active' => true, 'is_ppl' => true]);
        // }])->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
        $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
            $kuliahLapangan->with(['tahunAkademik', 'lokasi' => function ($lokasi) {
                $lokasi->with(['kelompok' => function ($kelompok) {
                    $kelompok->withCount('anggota')
                        ->whereHas('pembimbing', function ($pembimbing) {
                            $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                        });
                }])->withCount('kelompok')
                    ->whereHas('kelompok', function ($kelompok) {
                        $kelompok->withCount('anggota')
                            ->whereHas('pembimbing', function ($pembimbing) {
                                $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                            });
                    });
            }])
                ->where(['is_active' => true]);
        }])
            ->whereHas('kuliahLapangan', function ($kuliahLapangan) {
                $kuliahLapangan->where(['is_active' => true]);
            })
            ->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
        // return $data;

        $data['data']->map(function ($item) {
            $lokasiCount = 0;
            $lokasiCount = count($item->kuliahLapangan->lokasi);

            // $item->rowspan = 0;
            // $kelompokCount = $item->kuliahLapangan->lokasi->reduce(function ($carry, $item) {
            //     return $item->kelompok_count;
            // }, 0);
            $kelompokCount = 0;
            foreach ($item->kuliahLapangan->lokasi as $lokasi) {
                $kelompokCount = $kelompokCount + count($lokasi->kelompok);
            }
            $item->rowspan = $kelompokCount + $lokasiCount + 2;
            $item->kuliahLapangan->waktu_pelaksanaan_mulai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_mulai);
            $item->kuliahLapangan->waktu_pelaksanaan_selesai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_selesai);
        });
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
        $data['data'] = Kelompok::with([
            'anggota.pendaftar.mahasiswa.dataDiri',
            'lokasi.kuliahLapangan.tahunAkademik',
            'pembimbing.pegawai.dataDiri'
        ])
            ->where('id', $kelompokId)->get();


        // return $data;
        return view('pembimbing.bimbingan-detail', $data);
    }

    public function detailLkh($kelompokId, $id)
    {
        $data['title'] = "Detail LKH";

        $lkh = PplLkh::where('ppl_kelompok_anggota_id', $id)->orderBy('tgl_lkh', 'DESC')->get();
        $lkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('j F Y');;
        });
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
