<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KuliahLapangan;
use App\Models\KuliahLapanganPendaftar;
use App\Http\Requests\PendaftarRequest;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kuliahLapanganId)
    {
        //
        $data = KuliahLapanganPendaftar::with(['mahasiswa.dataDiri', 'pendaftar.mahasiswa.prodi'])
            ->where('kuliah_lapangan_id', $kuliahLapanganId)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'details' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendaftarRequest $request)
    {
        //
        // $data = KuliahLapanganPendaftar::create($request->validated());

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data berhasil ditambahkan',
        //     'details' => $data,
        // ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, $kuliahLapanganId, $limit)
    {
        $searchQuery = $request->query('search');
        if (!empty($searchQuery)) {
            $data = KuliahLapanganPendaftar::where('kuliah_lapangan_id', $kuliahLapanganId)
                ->with(['mahasiswa.dataDiri' => function ($dataDiri) use ($searchQuery) {
                    $dataDiri->where('nama_lengkap', 'LIKE', '%' . $searchQuery . '%')
                        ->orderBy('nama_lengkap', 'ASC');
                }, 'mahasiswa.prodi'])
                ->whereHas('mahasiswa.dataDiri', function ($dataDiri) use ($searchQuery) {
                    $dataDiri->where('nama_lengkap', 'LIKE', '%' . $searchQuery . '%')
                        ->orderBy('nama_lengkap', 'ASC');
                })->doesntHave('anggota')
                ->get();
        } else {
            $data = KuliahLapanganPendaftar::where('kuliah_lapangan_id', $kuliahLapanganId)
                ->with(['mahasiswa.dataDiri', 'mahasiswa.prodi', 'anggota.kelompok.lokasi'])
                ->paginate($limit);
        }
        if ($data->count() == 0)
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'details' => $data,
            ], 200);
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'details' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
