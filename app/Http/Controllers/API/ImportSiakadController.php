<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportSiakadController extends Controller
{
    /**
     * Menampilkan halaman
     */
    public function index()
    {
        return view('import-siakad');
    }

    /**
     * ============================================
     * GET PROGRAM STUDI
     * ============================================
     */
    public function prodi()
    {
        $data = DB::table('master_prodis as mp')
            ->where('mp.master_fakultas_id', 1)
            ->where('mp.is_aktif', 1)
            ->select(
                'mp.id',
                'mp.prodi_kode',
                'mp.prodi_nama'
            )
            ->orderBy('mp.prodi_nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    /**
     * ============================================
     * GET PEMBIMBING
     * ============================================
     */
    public function pembimbing()
    {
        $data = DB::table('kuliah_lapangan_pendaftars as klp')

            ->join(
                'kuliah_lapangan_kelompok_anggotas as klka',
                'klka.pendaftar_id',
                '=',
                'klp.id'
            )

            ->join(
                'kuliah_lapangan_kelompoks as klk',
                'klk.id',
                '=',
                'klka.kelompok_id'
            )

            ->join(
                'kuliah_lapangan_pembimbings as klkp',
                'klkp.id',
                '=',
                'klk.pembimbing_id'
            )

            ->join(
                'pegawais as p',
                'p.id',
                '=',
                'klkp.pegawai_id'
            )

            ->join(
                'data_diris as dd',
                'dd.id',
                '=',
                'p.data_diri_id'
            )

            ->where(
                'klp.kuliah_lapangan_id',
                13
            )

            ->select(
                'klkp.id as pembimbing_id',
                'dd.nama_lengkap'
            )

            ->distinct()

            ->orderBy(
                'dd.nama_lengkap'
            )

            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    /**
     * ============================================
     * GET NILAI
     *
     * Prodi       = optional
     * Pembimbing  = optional
     *
     * Bisa:
     *
     * 1. Semua
     * 2. Prodi saja
     * 3. Pembimbing saja
     * 4. Prodi + Pembimbing
     * ============================================
     */
    public function nilai(
        Request $request
    ) {

        $prodiKode = $request->prodi;
        $pembimbingId = $request->pembimbing;


        $query = DB::table(
            'kuliah_lapangan_pendaftars as klp'
        )

            ->join(
                'mahasiswas as m',
                'm.id',
                '=',
                'klp.mahasiswa_id'
            )

            ->leftJoin(
                'data_diris as dd',
                'dd.id',
                '=',
                'm.data_diri_id'
            )

            ->leftJoin(
                'master_prodis as mp',
                'mp.id',
                '=',
                'm.master_prodi_id'
            )

            ->leftJoin(
                'kuliah_lapangan_kelompok_anggotas as klka',
                'klka.pendaftar_id',
                '=',
                'klp.id'
            )

            ->leftJoin(
                'kuliah_lapangan_nilais as n',
                'n.kelompok_anggota_id',
                '=',
                'klka.id'
            )

            ->leftJoin(
                'kuliah_lapangan_kelompoks as klk',
                'klk.id',
                '=',
                'klka.kelompok_id'
            )

            ->leftJoin(
                'kuliah_lapangan_pembimbings as klkp',
                'klkp.id',
                '=',
                'klk.pembimbing_id'
            )

            ->leftJoin(
                'pegawais as p',
                'p.id',
                '=',
                'klkp.pegawai_id'
            )

            ->leftJoin(
                'data_diris as dd2',
                'dd2.id',
                '=',
                'p.data_diri_id'
            )

            ->where(
                'klp.kuliah_lapangan_id',
                13
            );


        /**
         * ========================================
         * FILTER PRODI
         * ========================================
         */

        if (!empty($prodiKode)) {

            $query->where(
                'mp.prodi_kode',
                $prodiKode
            );
        }


        /**
         * ========================================
         * FILTER PEMBIMBING
         * ========================================
         */

        if (!empty($pembimbingId)) {

            $query->where(
                'klkp.id',
                $pembimbingId
            );
        }


        /**
         * ========================================
         * SELECT
         * ========================================
         */

        $query->select(

            'm.nim',

            'dd.nama_lengkap',

            'mp.prodi_kode',

            'mp.prodi_nama',

            'klkp.id as pembimbing_id',

            'dd2.nama_lengkap as pembimbing',

            'n.nilai_pembimbing',

            'n.nilai_eksternal',

            DB::raw("
                CASE
                    WHEN
                        n.nilai_pembimbing IS NULL
                        AND
                        n.nilai_eksternal IS NULL
                    THEN NULL

                    ELSE ROUND(
                        (
                            COALESCE(
                                n.nilai_pembimbing,
                                0
                            ) * 0.30
                        )
                        +
                        (
                            COALESCE(
                                n.nilai_eksternal,
                                0
                            ) * 0.70
                        ),
                        2
                    )

                END AS nilai_final
            ")

        )

            ->orderBy(
                'm.nim'
            );


        $data = $query->get();


        /**
         * ========================================
         * FORMAT NILAI FINAL
         *
         * 85     -> 85,00
         * 85.5   -> 85,50
         * 85.567 -> 85,57
         * ========================================
         */

        $data->transform(function ($item) {

            if ($item->nilai_final !== null) {

                $item->nilai_final = number_format(
                    (float) $item->nilai_final,
                    2,
                    ',',
                    ''
                );
            }

            return $item;
        });


        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
