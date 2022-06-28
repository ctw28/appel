<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\PplKelompokAnggota;
use App\Models\PplLokasi;
use App\Models\PplKelompok;
use App\Models\PplPendaftar;

class PplKelompokAnggotaController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "Peserta PLP";
        $data['pplData'] = Ppl::with(['tahunAjar'])->get();
        // $data['lokasiData'] = PplLokasi::where('tahunAjar')->find($pplId);
        // return $data;
        return view('admin.ppl-peserta', $data);
    }

    public function set($pplId, $lokasiId, $kelompokId)
    {
        $data['title'] = "Kelompok PLP";
        // $data['data'] = PplLokasi::with(['ppl', 'pplKelompok.pplPembimbing.pplPembimbingInternal' => function ($pplKelompok) use ($kelompokId) {
        //     $pplKelompok->find($kelompokId)->get();
        // }])->find($lokasiId);
        $data['data'] = PplKelompok::with(['pplKelompokAnggota.pplPendaftar', 'pplLokasi.ppl', 'pplPembimbing.pplPembimbingInternal'])->find($kelompokId);
        // $data['data'] = PplKelompokAnggota::with(['ppl', 'pplLokasi.pplKelompok.pplPembimbing.pplPembimbingInternal'])->where('ppl_kelompok_id', $kelompokId)->get();
        // return $data;
        return view('admin.ppl-peserta-olah', $data);
    }

    public function add($pplId, $lokasiId, $kelompokId)
    {
        $data['title'] = "Tambah Peserta PLP";
        $data['data'] = PplKelompok::with(['pplLokasi.ppl', 'pplPembimbing.pplPembimbingInternal'])->find($kelompokId);

        // $data['data'] = Ppl::with(['pplLokasi' => function ($pplLokasi) use ($lokasiId) {
        //     $pplLokasi->with('PplKelompok')->find($lokasiId);
        // }, 'pplPembimbingInternal'])->find($pplId);

        // $data['lokasiData'] = PplLokasi::with(['ppl', 'PplKelompok'])->find($lokasiId);
        // return $data;
        return view('admin.ppl-peserta-tambah', $data);
    }

    public function store(Request $request)
    {
        try {

            $pendaftar = PplPendaftar::where([
                'ppl_id' => $request->ppl_id,
                'iddata' => $request->iddata
            ])->select('id')->first();
            // return $pendaftarId;
            $save = PplKelompokAnggota::create([
                'ppl_kelompok_id' => $request->ppl_kelompok_id,
                'ppl_pendaftar_id' => $pendaftar->id,
                'kelompok_jabatan_id' => $request->kelompok_jabatan_id
            ]);
            return array("status" => true);
        } catch (\Throwable $th) {
            return array("status" => false);
            // throw $th;
        }
    }
    public function destroy(Request $request)
    {
        try {
            $pendaftar = PplPendaftar::where([
                'ppl_id' => $request->ppl_id,
                'iddata' => $request->iddata
            ])->select('id')->first();
            $data = PplKelompokAnggota::where(
                [
                    'ppl_kelompok_id' => $request->ppl_kelompok_id,
                    'ppl_pendaftar_id' => $pendaftar->id
                ]
            );
            $data->delete();
            return array("status" => true);
        } catch (\Throwable $th) {
            // return array("status" => false,'pesan'=>);
            throw $th;
        }
    }
}
