<?php

namespace App\Http\Controllers;

use App\Models\KuliahLapanganFakultas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PengaturanFakultasController extends Controller
{
    //
    public function index()
    {
        // return Auth::user()->userFakultas->master_fakultas_id;
        $data['title'] = "Pengaturan Fakultas";
        $data['data'] = KuliahLapanganFakultas::with('fakultas')->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)->first();
        // return $data;
        return view('admin.fakultas-pengaturan', $data);
    }

    public function update(Request $request)
    {
        $data = [
            'sebutan' => $request->sebutan,
            'singkatan' => $request->singkatan,
            'sebutan_eksternal' => $request->sebutan_eksternal
        ];
        $update = kuliahLapanganFakultas::where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)
            ->update($data);

        if ($update) {
            $data = KuliahLapanganFakultas::with('fakultas')->where('master_fakultas_id', Auth::user()->userFakultas->master_fakultas_id)->first();
            session(
                [
                    'fakultasData' => $data
                ]
            );
            return redirect()->back();
        }
        return "ada kesalahan";
    }
}
