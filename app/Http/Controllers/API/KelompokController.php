<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KuliahLapangan;
use App\Models\Kelompok;
use App\Models\KelompokAnggota;
use App\Http\Requests\KelompokRequest;
use App\Http\Requests\KelompokAnggotaRequest;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kuliahLapanganId, $lokasiId)
    {
        $data = KuliahLapangan::select('id', 'tahun_akademik_id', 'kuliah_lapangan_nama')->with(['ppl', 'tahunAkademik', 'lokasi' => function ($lokasi) use ($lokasiId) {
            $lokasi->with(['kelompok' => function ($kelompok) {
                $kelompok->with('pembimbing.pegawai.dataDiri')->withCount(['anggota'])->orderBy('nama_kelompok', 'ASC');
            }])->withCount('kelompok')->find($lokasiId)->first();
        }])->find($kuliahLapanganId);

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
    public function store(KelompokRequest $request)
    {
        // return $request->all();
        $data = Kelompok::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Kelompok berhasil ditambahkan',
            'details' => $data,
        ], 200);
    }

    public function getAnggota($kelompokId)
    {
        $data = KelompokAnggota::with(['pendaftar.mahasiswa.dataDiri', 'pendaftar.mahasiswa.prodi'])->where('kelompok_id', $kelompokId)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'details' => $data,
        ], 200);
    }
    public function storeAnggota(KelompokAnggotaRequest $request)
    {
        $data = KelompokAnggota::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'details' => $data,
        ], 200);
    }

    public function deleteAnggota($id)
    {
        try {
            $lokasi = KelompokAnggota::find($id);
            $lokasi->delete();
            return array('status' => true, 'pesan' => "data berhasil di hapus");
        } catch (\Throwable $th) {
            return $th;
            return array('status' => false, 'pesan' => $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $data = Kelompok::with('pembimbing.pegawai.dataDiri')->withCount('anggota')->find($id);

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
    public function update(KelompokRequest $request, $id)
    {
        $data = Kelompok::find($id);
        $data->update($request->validated());
        $data = Kelompok::with('pembimbing.pegawai.dataDiri')->withCount('anggota')->find($id);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'details' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $lokasi = Kelompok::find($id);
            $lokasi->delete();
            return array('status' => true, 'pesan' => "data berhasil di hapus");
        } catch (\Throwable $th) {
            return $th;
            return array('status' => false, 'pesan' => $th);
        }
    }
}
