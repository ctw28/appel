<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\PplPembimbingInternal;


class PplPembimbingInternalController extends Controller
{
    //
    public function index($pplId)
    {
        $data['title'] = "Pengaturan Pembimbing Internal";
        $data['pplData'] = Ppl::with(['tahunAjar', 'pplPembimbingInternal'])->find($pplId);
        // $data['lokasiData'] = PplLokasi::where('tahunAjar')->find($pplId);
        // return $data;
        return view('admin.ppl-pembimbing-internal', $data);
    }

    public function add($pplId)
    {
        $data['title'] = "Tambah Pembimbing Internal";
        $data['pplData'] = Ppl::find($pplId);
        return view('admin.ppl-pembimbing-internal-tambah', $data);
    }

    public function store(Request $request, $pplId)
    {
        try {
            PplPembimbingInternal::create([
                'ppl_id' => $pplId,
                'idpeg' => $request->idpeg,
            ]);
            return array("status" => true);
        } catch (\Throwable $th) {
            return array("status" => false);
            //throw $th;
        }
    }

    public function destroy(Request $request, $pplId)
    {
        try {
            $data = PplPembimbingInternal::where(
                [
                    'ppl_id' => $pplId,
                    'idpeg' => $request->idpeg
                ]
            );
            $data->delete();
            return array("status" => true);
        } catch (\Throwable $th) {
            // return array("status" => false,'pesan'=>);
            throw $th;
        }
    }

    public function getPembimbing($pplId)
    {
        $data['data'] = PplPembimbingInternal::where('ppl_id', $pplId)->get();
        return $data;
    }
}
