<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTahunAjar;
use App\Models\Ppl;
use App\Models\PplPendaftar;
use App\Models\PplKelompokAnggota;
use App\Models\SyaratMatkul;
use App\Models\SyaratProdi;

class PplController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "List PLP";
        $pplData = Ppl::with('tahunAjar')->get();
        $pplData->map(function ($item) {
            if ($item->is_finished == 1) {
                $item->label = "success";
                $item->is_finished = "Selesai";
            } else {
                $item->label = "warning";
                $item->is_finished = "Berjalan";
            }
        });
        $data['pplData'] = $pplData;
        return view('admin.ppl', $data);
    }
    public function add()
    {
        $data['title'] = "Tambah PLP";
        $data['tahunAjar'] = MasterTahunAjar::all();
        return view('admin.ppl-tambah', $data);
    }
    public function store(Request $request)
    {

        $dataTervalidasi = $request->validate([
            'tahun_ajar_id' => ['required'],
        ]);

        // $save = PplLokasi::create([
        //     'tahun_ajari_id' => $request->id_tahun_ajar,
        // ]);
        $save = Ppl::create($request->all());
        // return $save;
        return redirect()->route('admin.ppl')->with(['status' => 'success', 'pesan' => 'Data berhasil ditambahkan', 'label' => 'success']);;
    }

    public function syaratProdi($pplId)
    {
        $data['title'] = "Syarat PLP";
        $data['data'] = Ppl::with('tahunAjar')->find($pplId);

        return view('admin.ppl-syarat', $data);
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
            $sudahAnggota = PplKelompokAnggota::with(['pplKelompok.pplLokasi.ppl'])
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

    public function edit($pplId)
    {
        $data['title'] = "Edit PLP";
        $data['tahunAjar'] = MasterTahunAjar::all();
        $data['data'] = Ppl::with('tahunAjar')->find($pplId);

        return view('admin.ppl-edit', $data);
    }

    public function update(Request $request, $pplId)
    {
        try {
            //code...
            $save = Ppl::find($pplId)->update($request->all());
            return redirect()->route('admin.ppl')->with(['status' => 'success', 'pesan' => 'Data berhasil diupdate', 'label' => 'success']);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Data gagal diupdate', 'label' => 'danger']);
        }
    }

    public function delete($pplId)
    {
        try {
            $ppl = Ppl::find($pplId);
            $ppl->delete();
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Data berhasil dihapus', 'label' => 'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['status' => 'success', 'pesan' => 'Ada Kesalahan Data gagal dihapus', 'label' => 'danger']);
            //throw $th;
        }
    }
}
