<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LokasiRequest;
use App\Models\Lokasi;


class LokasiController extends Controller
{
    //
    public function index(Request $request, $kuliahLapanganId, $limit)
    {
        $searchQuery = $request->query('search');
        // return $request->query('search');
        $data = Lokasi::where('kuliah_lapangan_id', $kuliahLapanganId)
            ->withCount('kelompok')
            ->where('lokasi', 'LIKE', '%' . $searchQuery . '%')
            ->orderBy('lokasi', 'ASC')->paginate($limit);
        return array('status' => true, 'data' => $data);
    }
    public function get($lokasiId)
    {
        $data = Lokasi::withCount('kelompok')->find($lokasiId);
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'details' => $data,
        ], 200);
    }
    public function store(LokasiRequest $request, $kuliahLapanganId)
    {
        $lokasi = Lokasi::create($request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Lokasi berhasil ditambahkan',
            'details' => $lokasi,
        ], 200);
    }
    public function update(LokasiRequest $request, $lokasiId)
    {

        $lokasi = Lokasi::withCount('kelompok')->find($lokasiId);
        $lokasi->update($request->validated());
        return response()->json([
            'status' => true,
            'message' => 'Lokasi berhasil diubah',
            'details' => $lokasi,
        ], 200);
    }

    public function delete($lokasiId)
    {
        try {
            $lokasi = Lokasi::find($lokasiId);
            $lokasi->delete();
            return array('status' => true, 'pesan' => "data berhasil di hapus");
        } catch (\Throwable $th) {
            return $th;
            return array('status' => false, 'pesan' => $th);
        }
    }
}
