<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\KuliahLapangan;
use App\Models\MasterFakultas;
use App\Models\MasterProdi;
use App\Models\SyaratProdi;
use App\Models\SyaratMatkul;
use App\Models\KuliahLapanganSyarat;
use App\Models\Lkh;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Storage;


class ApiController extends Controller
{
    //

    public function getSyaratProdi($id)
    {
        $kuliahLapangan = KuliahLapangan::with('ppl')->find($id);
        // $data['data'] = MasterProdi::with('syarat')->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)->get();
        $data['kuliahLapangan'] = $kuliahLapangan;
        $data['data'] = MasterFakultas::with(['prodi' => function ($prodi) use ($id) {
            $prodi->with(['syarat' => function ($syarat) use ($id) {
                $syarat->where('kuliah_lapangan_id', $id);
            }])->where('is_aktif', true);
        }])->find($kuliahLapangan->ppl->master_fakultas_id);
        // $data['data'] = auth()->user();
        return $data;
    }

    public function syaratProdiSrore(Request $request)
    {
        // return $request->all();
        try {
            $save = KuliahLapanganSyarat::updateOrCreate(
                [
                    'kuliah_lapangan_id' => $request->kuliah_lapangan_id,
                    'master_prodi_id' => $request->master_prodi_id,
                    'tahun_penawaran' => $request->tahun_penawaran
                ],
                ['sks' => $request->sks]
            );
            return array('status' => true, 'data' => $save);
        } catch (\Throwable $th) {
            return array('status' => false);

            throw $th;
        }
    }

    public function syaratProdiDelete(Request $request)
    {
        try {
            //code...
            $syaratProdi = KuliahLapanganSyarat::where(
                [
                    'kuliah_lapangan_id' => $request->kuliah_lapangan_id,
                    'master_prodi_id' => $request->master_prodi_id
                ]
            );

            $syaratProdi->delete();
            // return array('status' => "success");
            return array('status' => true);
        } catch (\Throwable $th) {
            //throw $th;
            return array('status' => false);

            return array('status' => "gagal");
        }
    }

    public function getSyarat($pplId)
    {
        $data['data'] = Ppl::with('syaratProdi')->find($pplId);
        return $data;
    }


    public function lkhIndex($id)
    {
        $lkh = Lkh::with('dokumentasi')->where('kelompok_anggota_id', $id)->orderBy('tgl_lkh', 'DESC')->paginate(8);
        $lkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('l, j F Y');
            $item->kegiatan = \Illuminate\Support\Str::limit($item->kegiatan, 50, $end = '...');
        });
        return $lkh;
    }

    public function lkhDetail($id)
    {
        $lkh = Lkh::with('dokumentasi')->where('id', $id)->first();
        $tglIndo = Carbon::parse($lkh->tgl_lkh)->locale('id');
        $tglIndo->settings(['formatFunction' => 'translatedFormat']);
        $lkh->tgl_lkh = $tglIndo->format('l, j F Y');
        return $lkh;
    }

    public function lkhEdit($id)
    {
        $lkh = Lkh::find($id);
        return $lkh;
    }

    public function lkhUpdate(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'anggota_id' => 'required',
                'kegiatan' => 'required',
                'tgl_lkh' => 'required',
            ]);
            $lkh = Lkh::find($id);
            $lkh->update($data);
            return array('status' => 'success', 'data' => $lkh);
        } catch (\Throwable $th) {
            return array('status' => 'false', 'data' => []);
            throw $th;
        }
    }

    public function lkhDelete($lkhId)
    {
        try {
            $data = Lkh::with('dokumentasi')->find($lkhId);
            $dokumentasi = $data->dokumentasi;
            $data->delete();
            foreach ($dokumentasi as $foto) {
                // Storage::delete($foto->foto_path);
                unlink($foto->foto_path);

                // unlink(public_path() . '/'  . $foto->foto_path);
            }
            return array('status' => 'success');
        } catch (\Throwable $th) {
            return array('status' => $th);
        }
    }
}
