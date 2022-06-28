<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\PplLokasi;
use App\Models\PplKelompok;
use App\Models\PplPembimbing;
use App\Models\PplPembimbingInternal;
use Illuminate\Support\Facades\DB;

class PplKelompokController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "Kelompok PLP";
        $data['pplData'] = Ppl::with(['tahunAjar'])->get();
        // $data['lokasiData'] = PplLokasi::where('tahunAjar')->find($pplId);
        // return $data;
        return view('admin.ppl-kelompok', $data);
    }

    public function getKelompok($lokasiId)
    {
        $data = PplKelompok::with('pplPembimbing.pplPembimbingInternal')->where('ppl_lokasi_id', $lokasiId)->get();
        return $data;
    }

    public function set($pplId, $lokasiId)
    {
        $data['title'] = "Kelompok PLP";
        $data['lokasiData'] = PplLokasi::with(['ppl', 'pplKelompok.pplPembimbing.pplPembimbingInternal'])->find($lokasiId);
        // return $data;
        return view('admin.ppl-kelompok-olah', $data);
    }

    public function add($pplId, $lokasiId)
    {
        $data['title'] = "Tambah Kelompok PLP";
        $data['data'] = Ppl::with(['pplLokasi' => function ($pplLokasi) use ($lokasiId) {
            $pplLokasi->with('PplKelompok')->find($lokasiId);
        }, 'pplPembimbingInternal'])->find($pplId);

        // $data['lokasiData'] = PplLokasi::with(['ppl', 'PplKelompok'])->find($lokasiId);
        // return $data;
        return view('admin.ppl-kelompok-tambah', $data);
    }
    public function store(Request $request, $pplId, $lokasiId)
    {
        // return $request->all();
        try {
            DB::beginTransaction();
            $saveLokasi = PplKelompok::create([
                'ppl_lokasi_id' => $request->ppl_lokasi_id,
                'nama_kelompok' => $request->nama_kelompok,
                'keterangan' => $request->keterangan
            ]);
            $pembimbingInternalId = PplPembimbingInternal::where([
                'ppl_id' => $pplId,
                'idpeg' => $request->idpeg
            ])->first();
            $savePembimbing = PplPembimbing::create([
                'ppl_kelompok_id' => $saveLokasi->id,
                'pembimbing_internal_id' => $pembimbingInternalId->id,
                // 'pembimbing_eksternal_id' => $saveLokasi->id,
            ]);
            DB::commit();
            return redirect()->route('admin.ppl.kelompok.set', [$pplId, $lokasiId]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function delete($kelompokId)
    {
        try {
            $kelompok = PplKelompok::find($kelompokId);
            $kelompok->delete();
            return redirect()->back();
            return array('status' => "success");
        } catch (\Throwable $th) {
            return array('status' => "gagal");

            //throw $th;
        }
    }
}
