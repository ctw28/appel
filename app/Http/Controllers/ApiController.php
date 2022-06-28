<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\SyaratProdi;
use App\Models\SyaratMatkul;


class ApiController extends Controller
{
    //

    public function getProdi($pplId)
    {
        $data['data'] = Ppl::with('syaratProdi')->find($pplId);
        return $data;
    }

    public function syaratProdiSrore(Request $request)
    {
        // return $request->all();
        try {
            $save = SyaratProdi::updateOrCreate(
                [
                    'ppl_id' => $request->ppl_id,
                    'prodi_id' => $request->idprodi
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
            $syaratProdi = SyaratProdi::where(
                [
                    'ppl_id' => $request->ppl_id,
                    'prodi_id' => $request->idprodi
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
}
