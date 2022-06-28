<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\PplLokasi;

class PplLokasiController extends Controller
{
    //
    public function index($pplId)
    {
        $data['title'] = "Kelola Lokasi PLP";
        $data['pplData'] = Ppl::with(['tahunAjar', 'pplLokasi'])->find($pplId);
        // $data['lokasiData'] = PplLokasi::where('tahunAjar')->find($pplId);
        // return $data;
        return view('admin.ppl-kelola-lokasi', $data);
    }

    public function getLokasi($pplId)
    {
        $data = PplLokasi::where('ppl_id', $pplId)->get();
        return $data;
    }
    public function add($pplId)
    {
        $data['title'] = "Tambah Lokasi PLP";
        $data['pplData'] = Ppl::find($pplId);
        return view('admin.ppl-lokasi-tambah', $data);
    }

    public function store(Request $request, $pplId)
    {
        $save = PplLokasi::create([
            'ppl_id' => $pplId,
            'lokasi' => $request->lokasi,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('admin.ppl.lokasi', $pplId);
        // return $save;
    }

    public function delete($lokasiId)
    {
        try {
            $lokasi = PplLokasi::find($lokasiId);
            $lokasi->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
