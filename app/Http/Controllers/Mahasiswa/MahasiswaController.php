<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\PplPendaftar;
use App\Models\PplLkh;
use App\Models\PplKelompok;
use Carbon\Carbon;
use Storage;


class MahasiswaController extends Controller
{
    //

    public function index(Request $request)
    {
        $data['title'] = "Dashboard";
        $data['data'] = PplPendaftar::with([
            'ppl',
            'pplKelompokAnggota.pplKelompok.pplLokasi',
            'pplKelompokAnggota.kelompokJabatan',
            'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        ])
            ->where('iddata', $request->session()->get('data'))->get();
        // return $data;
        return view('mahasiswa.dashboard', $data);
    }

    public function ppl(Request $request)
    {
        $data['title'] = "PLP";
        $pplData = Ppl::with(['tahunAjar', 'pplPendaftar.pplKelompokAnggota'])->where('is_open', 1)->get();
        $pplData->map(function ($item) use ($request) {
            $check = PplPendaftar::where('iddata', $request->session()->get('data'))->where('ppl_id', $item->id)->count();
            // $tglMulai = carbon::parse($item->ppl_waktu_daftar_mulai);
            // $tglSelesai = carbon::parse($item->ppl_waktu_daftar_selesai);
            // if ($tglMulai->diffInDays(Carbon::now()) < 0) {
            //     $item->test = 'belum buka';
            // } elseif ($tglMulai->diffInDays(Carbon::now()) >= 0 && $tglSelesai->diffInDays(Carbon::now()) <= 0) {
            //     $item->test = 'sudah buka';
            //     // $item->test = Carbon::parse($item->ppl_waktu_daftar_selesai)->diffForHumans();
            // } elseif ($tglSelesai->diffInDays(Carbon::now()) > 0) {
            //     $item->test = Carbon::parse($item->ppl_waktu_daftar_selesai)->diffForHumans();
            //     // $item->test = 'sudah tutup';
            // }

            $tglIndo = Carbon::parse($item->ppl_waktu_daftar_mulai)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->ppl_waktu_daftar_mulai = $tglIndo->format('j F Y');;
            $tglIndo = Carbon::parse($item->ppl_waktu_daftar_selesai)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->ppl_waktu_daftar_selesai = $tglIndo->format('j F Y');;
            if ($item->is_open == 1) {
                $item->label = "success";
                $item->is_finished = "Selesai";
            } else {
                $item->label = "warning";
                $item->is_finished = "Terbuka";
            }
            if ($check > 0) {
                $item->status_daftar = "Anda sudah mendaftar";
                $item->status_label = "secondary";
                $item->link = "#";
            } else {
                $item->status_daftar = "Daftar";
                $item->status_label = "primary";
                $item->link = route('mahasiswa.ppl.daftar', $item->id);
            }
        });
        $data['pplData'] = $pplData;
        // return $check;
        // if (empty($check)) {
        // return $data;
        return view('mahasiswa.ppl', $data);
    }

    public function daftar(Request $request, $pplId)
    {
        $check = PplPendaftar::where('iddata', $request->session()->get('data'))->where('ppl_id', $pplId)->first();
        // return $check;
        if (empty($check)) {
            $save = PplPendaftar::create([
                'ppl_id' => $pplId,
                'iddata' => $request->session()->get('data'),
            ]);

            return redirect()->route('mahasiswa.dashboard');
        } else {
            return redirect()->back()->with('error', 'Anda Sudah Daftar');
        }

        // return $save;
        // $data['title'] = "Pendaftaran PLP";
        // $pplData = Ppl::with('tahunAjar')->find($pplId);
        // $data['pplData'] = $pplData;

        // return view('mahasiswa.ppl-daftar', $data);
    }

    public function listPpl(Request $request, $status)
    {
        $data['title'] = "PLP Diikuti";
        if ($status == "berjalan")
            $status = 0;
        else
            $status = 1;
        $pplDiikuti = PplPendaftar::with(['ppl' => function ($ppl) use ($status) {
            $ppl->with('tahunAjar')->where('is_finished', $status);
        }])->where('iddata', $request->session()->get('data'))->get();
        if ($status == "semua")
            $pplDiikuti = PplPendaftar::with(['ppl', 'tahunAjar'])->where('iddata', $request->session()->get('data'))->get();
        $data['pplData'] = $pplDiikuti;
        // return $data;
        return view('mahasiswa.ppl-diikuti', $data);
    }

    public function lkh(Request $request)
    {
        $data['title'] = "Daftar Lembar Kerja Harian (LKH)";

        $data['data'] = PplPendaftar::with([
            'ppl',
            'pplKelompokAnggota.pplKelompok.pplLokasi',
            'pplKelompokAnggota.kelompokJabatan',
            'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
            'pplKelompokAnggota.pplLkh',
        ])
            ->where('iddata', $request->session()->get('data'))->get();
        $data['data'][0]->pplKelompokAnggota[0]->pplLkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('l, j F Y');
        });
        return view('mahasiswa.ppl-lkh', $data);
    }

    public function lkhAdd(Request $request)
    {
        $data['title'] = "Tambah Lembar Kerja Harian (LKH)";
        $data['data'] = PplPendaftar::with([
            'ppl',
            'pplKelompokAnggota.pplKelompok.pplLokasi',
            'pplKelompokAnggota.kelompokJabatan',
            'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        ])
            ->where('iddata', $request->session()->get('data'))->get();
        // return $data;
        return view('mahasiswa.ppl-lkh-tambah', $data);
    }

    public function lkhStore(Request $request)
    {
        try {
            $data = $request->validate([
                'ppl_kelompok_anggota_id' => 'required',
                'kegiatan' => 'required',
                'tgl_lkh' => 'required',
                'foto_path' => 'required|image|mimes:jpeg,png,jpg|file|max:2048',
            ]);
            $data['foto_path'] = $request->file('foto_path')->store('lkh-images');
            PplLkh::create($data);
            return redirect()->route('mahasiswa.lkh')->with('success', 'LKH berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'LKH gagal ditambahkan');
        }
    }

    public function lkhEdit(Request $request, $lkhId)
    {
        $data['title'] = "Tambah Lembar Kerja Harian (LKH)";
        $data['data'] = PplPendaftar::with([
            'ppl',
            'pplKelompokAnggota.pplKelompok.pplLokasi',
            'pplKelompokAnggota.kelompokJabatan',
            'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        ])
            ->where('iddata', $request->session()->get('data'))->get();
        $data['lkhData'] = PplLkh::find($lkhId);
        // return $data;
        return view('mahasiswa.ppl-lkh-edit', $data);
    }

    public function lkhUpdate(Request $request, $lkhId)
    {
        try {
            $lkh = PplLkh::find($lkhId);
            $filePath = $lkh->foto_path;
            $data = $request->validate([
                'ppl_kelompok_anggota_id' => 'required',
                'kegiatan' => 'required',
                'tgl_lkh' => 'required',
                'foto_path' => 'image|mimes:jpeg,png,jpg|file|max:2048',
            ]);
            if ($request->file('foto_path')) {
                Storage::delete($filePath);
                $data['foto_path'] = $request->file('foto_path')->store('lkh-images');
            }
            PplLkh::find($lkhId)->update($data);
            // PplLkh::create($data);
            return redirect()->route('mahasiswa.lkh')->with('success', 'LKH berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'LKH gagal diubah');
        }
    }


    public function lkhDelete($lkhId)
    {
        try {
            $data = PplLkh::find($lkhId);
            $filePath = $data->foto_path;
            $data->delete();
            Storage::delete($filePath);
            return redirect()->route('mahasiswa.lkh')->with('success', 'LKH berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'LKH gagal ditambahkan');
            // throw $th;
        }
    }

    public function detailKelompok(Request $request, $kelompokId)
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
        return view('mahasiswa.ppl-detail-kelompok', $data);
    }
}
