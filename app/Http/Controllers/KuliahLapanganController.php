<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTahunAkademik;
use App\Models\KuliahLapangan;
use App\Models\Ppl;
use App\Models\PplPendaftar;
use App\Models\PplKelompokAnggota;
use App\Models\SyaratMatkul;
use App\Models\SyaratProdi;
use App\Http\Requests\KuliahLapanganRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class KuliahLapanganController extends Controller
{
    //
    public function index()
    {
        $title = "Data PLP / PPL";
        $data = MasterTahunAkademik::with(['kuliahLapangan' => function ($kuliahLapangan) {
            $kuliahLapangan->with('ppl', function ($ppl) {
                $ppl->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id);
            })->withCount('pendaftar')->whereHas('ppl', function ($ppl) {
                $ppl->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id);
            });
        }])
            // ->where('tahun', 2024)
            ->where('is_active', 1)
            ->orderBy('id', "DESC")
            ->first();
        // return $data;
        // $ppl = Ppl::with('kuliahLapangan.tahunAkademik')->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)->get();
        if ($data != null) {

            if ($data->kuliahLapangan->count() != 0) {
                $data->kuliahLapangan->map(function ($item) {
                    $item->waktu_daftar_mulai = \FormatWaktu::tanggalIndonesia($item->waktu_daftar_mulai);
                    $item->waktu_daftar_selesai = \FormatWaktu::tanggalIndonesia($item->waktu_daftar_selesai);
                    $item->waktu_publikasi_kelompok = \FormatWaktu::tanggalIndonesia($item->waktu_publikasi_kelompok);
                    $item->waktu_pelaksanaan_mulai = \FormatWaktu::tanggalIndonesia($item->waktu_pelaksanaan_mulai);
                    $item->waktu_pelaksanaan_selesai = \FormatWaktu::tanggalIndonesia($item->waktu_pelaksanaan_selesai);
                    $item->waktu_tugas_mulai = \FormatWaktu::tanggalIndonesia($item->waktu_tugas_mulai);
                    $item->waktu_tugas_selesai = \FormatWaktu::tanggalIndonesia($item->waktu_tugas_selesai);
                    $item->waktu_penilaian_mulai = \FormatWaktu::tanggalIndonesia($item->waktu_penilaian_mulai);
                    $item->waktu_penilaian_selesai = \FormatWaktu::tanggalIndonesia($item->waktu_penilaian_selesai);

                    if ($item->is_finished == true) {
                        $item->label = "success";
                        $item->is_finished = "Selesai";
                    } else {
                        $item->label = "warning";
                        $item->is_finished = "Berjalan";
                    }
                });
            }
        }
        // return $data;
        // $data['data'] = $ppl;
        return view('admin.kuliah-lapangan', compact(['data', 'title']));
    }
    public function add()
    {
        $data['title'] = "Tambah PLP";
        $data['tahunAkademik'] = MasterTahunAkademik::all();
        return view('admin.kuliah-lapangan-tambah', $data);
    }
    public function store(KuliahLapanganRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = KuliahLapangan::create($request->validated());
            Ppl::create([
                'kuliah_lapangan_id' => $data->id,
                'master_fakultas_id' => Auth::user()->userFakultas->master_fakultas_id,
            ]);
            DB::commit();
            return redirect()->route('admin.ppl')->with(['status' => 'success', 'pesan' => 'Data berhasil ditambahkan', 'label' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            if (isset($request->validator) && $request->validator->fails()) {
                // return response()->json($request->validator->messages(), 400);
                return back()->withErrors($request->validator->messages())->withInput($request->input());
            }
            //throw $th;
        }
    }

    public function edit($id)
    {
        $data['title'] = "Edit PLP";
        $data['tahunAkademik'] = MasterTahunAkademik::all();
        $data['data'] = KuliahLapangan::with('tahunAkademik')->find($id);

        return view('admin.kuliah-lapangan-edit', $data);
    }

    public function update(KuliahLapanganRequest $request, $id)
    {
        try {
            //code...
            $save = KuliahLapangan::find($id)->update($request->validated());
            return redirect()->route('admin.ppl')->with(['status' => 'success', 'pesan' => 'Data berhasil diupdate', 'label' => 'success']);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Data gagal diupdate', 'label' => 'danger']);
        }
    }

    public function delete($id)
    {
        try {
            $ppl = KuliahLapangan::find($id);
            $ppl->delete();
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Data berhasil dihapus', 'label' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Ada Kesalahan Data gagal dihapus', 'label' => 'danger']);
            //throw $th;
        }
    }


    public function syaratProdi($pplId)
    {
        $data['title'] = "Syarat PLP";
        $data['data'] = KuliahLapangan::with('tahunAkademik')->find($pplId);

        return view('admin.kuliah-lapangan-syarat', $data);
    }

    public function syaratMataKuliah($pplId, $syaratProdiId)
    {
        $data['title'] = "Syarat PLP";
        $data['data'] = SyaratProdi::with(['ppl.tahunAjar', 'syaratMataKuliah'])->find($syaratProdiId);
        // return $data;

        return view('admin.ppl-syarat-mata-kuliah', $data);
    }

    public function syaratMataKuliahStore(Request $request)
    {
        // return $request->all();

        try {
            $save = SyaratMatkul::updateOrCreate(
                [
                    'syarat_prodi_id' => $request->syarat_prodi_id,
                    'kodemk' => $request->kodemk
                ],
                ['status' => $request->status]
            );
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function syaratMataKuliahDelete($syaratMataKuliahId)
    {
        try {
            $mataKuliah = SyaratMatkul::find($syaratMataKuliahId);
            $mataKuliah->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();

            //throw $th;
        }
    }

    public function getPendaftar($pplId, $kelompokId, $status)
    {

        if ($status == "belum") {
            $sudahAnggota = PplKelompokAnggota::with(['pplKelompok.pplLokasi.ppl' => function ($ppl) use ($pplId) {
                $ppl->where('id', $pplId);
            }])
                ->whereHas('pplKelompok.pplLokasi.ppl', function ($ppl) use ($pplId) {
                    $ppl->where('id', $pplId);
                })
                // ->where('ppl_kelompok_id', $kelompokId)
                ->pluck('ppl_pendaftar_id')->all();

            $data['data']  = PplPendaftar::with('pplKelompokAnggota')->whereNotIn('id', $sudahAnggota)->get();
        } else {
            $sudahAnggota = PplKelompokAnggota::with(['pplKelompok.pplLokasi.ppl'])
                ->whereHas('pplKelompok.pplLokasi.ppl', function ($ppl) use ($pplId) {
                    $ppl->where('id', $pplId);
                })
                ->where('ppl_kelompok_id', $kelompokId)
                ->pluck('ppl_pendaftar_id')->all();

            $data['data']  = PplPendaftar::with('pplKelompokAnggota')->whereIn('id', $sudahAnggota)->get();
        }
        // $data = Car::whereNotIn('id', $crashedCarIds)->select(...)->get();

        // $data['data'] = Ppl::with(['pplPendaftar'=>function($pplPendaftar){
        //     $pplPendaftar->
        // }])->find($pplId);
        return $data;
    }

    public function pendaftar($id)
    {
        $data['title'] = "Data Pendaftar";
        $data['data'] = KuliahLapangan::find($id);
        // return $data;
        return view('admin.pendaftar', $data);
    }
}
