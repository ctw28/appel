<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PplPembimbingInternal;
use App\Models\PplKelompok;
use App\Models\PplNilai;
use App\Models\Lkh;
use App\Models\Pembimbing;
use App\Models\Kelompok;
use App\Models\Laporan;
use App\Models\Nilai;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembimbingController extends Controller
{
    //
    public function index()
    {
        // return Auth::user()->userPegawai->pegawai;
        // return session('role');
        $data['title'] = "Dashboard";
        // $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
        //     $kuliahLapangan->with(['tahunAkademik', 'lokasi.kelompok.anggota.pendaftar.mahasiswa.dataDiri'])->where(['is_active' => true, 'is_ppl' => true]);
        // }])->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
        $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
            $kuliahLapangan->with(['tahunAkademik', 'lokasi' => function ($lokasi) {
                $lokasi->with(['kelompok' => function ($kelompok) {
                    $kelompok->withCount('anggota')
                        ->whereHas('pembimbing', function ($pembimbing) {
                            $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                        });
                }])->withCount('kelompok')
                    ->whereHas('kelompok', function ($kelompok) {
                        $kelompok->withCount('anggota')
                            ->whereHas('pembimbing', function ($pembimbing) {
                                $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                            });
                    });
            }])
                ->where(['is_active' => true]);
        }])
            ->whereHas('kuliahLapangan', function ($kuliahLapangan) {
                $kuliahLapangan->where(['is_active' => true]);
            })
            ->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
        // return $data;

        $data['data']->map(function ($item) {
            $lokasiCount = 0;
            $lokasiCount = count($item->kuliahLapangan->lokasi);

            // $item->rowspan = 0;
            // $kelompokCount = $item->kuliahLapangan->lokasi->reduce(function ($carry, $item) {
            //     return $item->kelompok_count;
            // }, 0);
            $kelompokCount = 0;
            foreach ($item->kuliahLapangan->lokasi as $lokasi) {
                $kelompokCount = $kelompokCount + count($lokasi->kelompok);
            }
            $item->rowspan = $kelompokCount + $lokasiCount + 2;
            // $item->kuliahLapangan->waktu_pelaksanaan_mulai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_mulai);
            // $item->kuliahLapangan->waktu_pelaksanaan_selesai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_selesai);
        });
        // return $data;
        return view('pembimbing.dashboard', $data);
    }

    // public function historyBimbingan(Request $request)
    // {
    //     $data['title'] = "History Bimbingan";
    //    $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
    //         $kuliahLapangan->with(['tahunAkademik', 'lokasi' => function ($lokasi) {
    //             $lokasi->with(['kelompok' => function ($kelompok) {
    //                 $kelompok->withCount('anggota')
    //                     ->whereHas('pembimbing', function ($pembimbing) {
    //                         $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
    //                     });
    //             }])->withCount('kelompok')
    //                 ->whereHas('kelompok', function ($kelompok) {
    //                     $kelompok->withCount('anggota')
    //                         ->whereHas('pembimbing', function ($pembimbing) {
    //                             $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
    //                         });
    //                 });
    //         }])
    //             ->where(['is_active' => true]);
    //     }])
    //         ->whereHas('kuliahLapangan', function ($kuliahLapangan) {
    //             $kuliahLapangan->where(['is_active' => true]);
    //         })
    //         ->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
    //     return view('pembimbing.bimbingan-list', $data);
    // }



    public function history()
    {
        $data['title'] = "History Bimbingan";
        $data['data'] = Pembimbing::with(['kuliahLapangan' => function ($kuliahLapangan) {
            $kuliahLapangan->with(['tahunAkademik', 'lokasi' => function ($lokasi) {
                $lokasi->with(['kelompok' => function ($kelompok) {
                    $kelompok->withCount('anggota')
                        ->whereHas('pembimbing', function ($pembimbing) {
                            $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                        });
                }])->withCount('kelompok')
                    ->whereHas('kelompok', function ($kelompok) {
                        $kelompok->withCount('anggota')
                            ->whereHas('pembimbing', function ($pembimbing) {
                                $pembimbing->where('pegawai_id', Auth::user()->userPegawai->pegawai_id);
                            });
                    });
            }]);
        }])
            ->whereHas('kuliahLapangan')
            ->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)->get();
        // return $data;
        return view('pembimbing.history-bimbingan', $data);
    }
    public function historyDetail($kelompokId)
    {
        $data['title'] = "Input Nilai";
        $nilai = Kelompok::with([
            'anggota.pendaftar',
            'anggota.nilai',
            'anggota.jabatan',
            'lokasi'
        ])->find($kelompokId);
        // return $data;
        $rentang = [
            ['rentang_bawah' => 96, 'rentang_atas' => 100, 'nilai_angka' => "4.00", 'huruf' => "A", 'keterangan' => "L"],
            ['rentang_bawah' => 91, 'rentang_atas' => 95.99, 'nilai_angka' => "3.60 - 3.90", 'huruf' => "A-", 'keterangan' => "L"],
            ['rentang_bawah' => 86, 'rentang_atas' => 90.99, 'nilai_angka' => "3.10 - 3.50", 'huruf' => "B+", 'keterangan' => "L"],
            ['rentang_bawah' => 81, 'rentang_atas' => 85.99, 'nilai_angka' => "3.00", 'huruf' => "B", 'keterangan' => "L"],
            ['rentang_bawah' => 76, 'rentang_atas' => 80.99, 'nilai_angka' => "2.60 - 2.90", 'huruf' => "B-", 'keterangan' => "L"],
            ['rentang_bawah' => 71, 'rentang_atas' => 75.99, 'nilai_angka' => "2.10 - 2.50", 'huruf' => "C+", 'keterangan' => "L"],
            ['rentang_bawah' => 66, 'rentang_atas' => 70.99, 'nilai_angka' => "2.00", 'huruf' => "C", 'keterangan' => "L"],
            ['rentang_bawah' => 61, 'rentang_atas' => 65.99, 'nilai_angka' => "1.60 - 1.90", 'huruf' => "C-", 'keterangan' => "TL"],
            ['rentang_bawah' => 56, 'rentang_atas' => 60.99, 'nilai_angka' => "1.10 - 1.50", 'huruf' => "D+", 'keterangan' => "TL"],
            ['rentang_bawah' => 51, 'rentang_atas' => 55.99, 'nilai_angka' => "1", 'huruf' => "D-", 'keterangan' => "TL"],
            ['rentang_bawah' => 0, 'rentang_atas' => 50.99, 'nilai_angka' => "0", 'huruf' => "E", 'keterangan' => "TL"],
        ];
        // return $nilai;

        foreach ($nilai->anggota as $anggota) {
            // $anggota->nilai->total_nilai = 0;
            // $anggota->nilai->nilai_angka = '0';
            // $anggota->nilai->nilai_huruf = 'E';
            // $anggota->nilai->keterangan = 'TL';
            if ($anggota->nilai != null) {

                $totalNilai = (0.7 * $anggota->nilai->nilai_eksternal) + (0.3 * $anggota->nilai->nilai_pembimbing);
                $anggota->nilai->total_nilai = $totalNilai;
                foreach ($rentang as $row) {
                    //disini mau tentukan berapa nilai angkanya
                    if ($totalNilai >= $row['rentang_bawah'] && $totalNilai <= $row['rentang_atas']) {
                        $anggota->nilai->nilai_angka = $row['nilai_angka'];
                        $anggota->nilai->nilai_huruf = $row['huruf'];
                        $anggota->nilai->keterangan = $row['keterangan'];
                        $anggota->nilai->label = 'success';
                        if ($row['keterangan'] == "TL")
                            $anggota->nilai->label = 'danger';
                        break; // Keluar dari loop jika rentang ditemukan
                    }
                }
            }
        }

        $data['data'] = $nilai;
        // return $data;
        return view('pembimbing.history-bimbingan-detail', $data);
    }
    public function list(Request $request)
    {
        $data['title'] = "Penilaian";
        $data['data'] = Pembimbing::with([
            // 'ppl.pplLokasi.pplKelompok.pplKelompokAnggota.pplPendaftar',
            // 'ppl.pplLokasi.pplKelompok.pplPembimbing',
            // 'pplPembimbing.pplKelompok.pplLokasi.ppl',
            'kelompok' => function ($pplKelompok) {
                $pplKelompok->withCount(['anggota']);
            },
            'kelompok.lokasi',
            'kuliahLapangan.tahunAkademik'
        ])
            // ->whereHas('pplPembimbing.pplKelompok')
            ->where('pegawai_id', Auth::user()->userPegawai->pegawai_id)
            // ->where('ppl_id', 1)
            ->get();
        // return $data;
        return view('pembimbing.bimbingan-list', $data);
    }
    public function nilaiInput($kelompokId)
    {
        $data['title'] = "Input Nilai";
        $nilai = Kelompok::with([
            'anggota.pendaftar',
            'anggota.nilai',
            'anggota.jabatan',
            'lokasi'
        ])->find($kelompokId);
        // return $data;
        $rentang = [
            ['rentang_bawah' => 96, 'rentang_atas' => 100, 'nilai_angka' => "4.00", 'huruf' => "A", 'keterangan' => "L"],
            ['rentang_bawah' => 91, 'rentang_atas' => 95.99, 'nilai_angka' => "3.60 - 3.90", 'huruf' => "A-", 'keterangan' => "L"],
            ['rentang_bawah' => 86, 'rentang_atas' => 90.99, 'nilai_angka' => "3.10 - 3.50", 'huruf' => "B+", 'keterangan' => "L"],
            ['rentang_bawah' => 81, 'rentang_atas' => 85.99, 'nilai_angka' => "3.00", 'huruf' => "B", 'keterangan' => "L"],
            ['rentang_bawah' => 76, 'rentang_atas' => 80.99, 'nilai_angka' => "2.60 - 2.90", 'huruf' => "B-", 'keterangan' => "L"],
            ['rentang_bawah' => 71, 'rentang_atas' => 75.99, 'nilai_angka' => "2.10 - 2.50", 'huruf' => "C+", 'keterangan' => "L"],
            ['rentang_bawah' => 66, 'rentang_atas' => 70.99, 'nilai_angka' => "2.00", 'huruf' => "C", 'keterangan' => "L"],
            ['rentang_bawah' => 61, 'rentang_atas' => 65.99, 'nilai_angka' => "1.60 - 1.90", 'huruf' => "C-", 'keterangan' => "TL"],
            ['rentang_bawah' => 56, 'rentang_atas' => 60.99, 'nilai_angka' => "1.10 - 1.50", 'huruf' => "D+", 'keterangan' => "TL"],
            ['rentang_bawah' => 51, 'rentang_atas' => 55.99, 'nilai_angka' => "1", 'huruf' => "D-", 'keterangan' => "TL"],
            ['rentang_bawah' => 0, 'rentang_atas' => 50.99, 'nilai_angka' => "0", 'huruf' => "E", 'keterangan' => "TL"],
        ];
        // return $nilai;

        foreach ($nilai->anggota as $anggota) {
            // $anggota->nilai->total_nilai = 0;
            // $anggota->nilai->nilai_angka = '0';
            // $anggota->nilai->nilai_huruf = 'E';
            // $anggota->nilai->keterangan = 'TL';
            if ($anggota->nilai != null) {

                $totalNilai = (0.7 * $anggota->nilai->nilai_eksternal) + (0.3 * $anggota->nilai->nilai_pembimbing);
                $anggota->nilai->total_nilai = $totalNilai;
                foreach ($rentang as $row) {
                    //disini mau tentukan berapa nilai angkanya
                    if ($totalNilai >= $row['rentang_bawah'] && $totalNilai <= $row['rentang_atas']) {
                        $anggota->nilai->nilai_angka = $row['nilai_angka'];
                        $anggota->nilai->nilai_huruf = $row['huruf'];
                        $anggota->nilai->keterangan = $row['keterangan'];
                        $anggota->nilai->label = 'success';
                        if ($row['keterangan'] == "TL")
                            $anggota->nilai->label = 'danger';
                        break; // Keluar dari loop jika rentang ditemukan
                    }
                }
            }
        }

        $data['data'] = $nilai;
        // return $data;
        return view('pembimbing.nilai-input', $data);
    }

    public function nilaiInput2($kelompokId)
    {
        $data['title'] = "Input Nilai";
        $nilainya = Kelompok::with([
            'anggota.pendaftar',
            'anggota.nilai',
            'anggota.jabatan',
            'lokasi'
        ])
            ->whereHas('lokasi', function ($query) {
                $query->where('kuliah_lapangan_id', 7);
            })->get();
        // ->find($kelompokId);
        // return $nilai[];
        $rentang = [
            ['rentang_bawah' => 96, 'rentang_atas' => 100, 'nilai_angka' => "4.00", 'huruf' => "A", 'keterangan' => "L"],
            ['rentang_bawah' => 91, 'rentang_atas' => 95.99, 'nilai_angka' => "3.60 - 3.90", 'huruf' => "A-", 'keterangan' => "L"],
            ['rentang_bawah' => 86, 'rentang_atas' => 90.99, 'nilai_angka' => "3.10 - 3.50", 'huruf' => "B+", 'keterangan' => "L"],
            ['rentang_bawah' => 81, 'rentang_atas' => 85.99, 'nilai_angka' => "3.00", 'huruf' => "B", 'keterangan' => "L"],
            ['rentang_bawah' => 76, 'rentang_atas' => 80.99, 'nilai_angka' => "2.60 - 2.90", 'huruf' => "B-", 'keterangan' => "L"],
            ['rentang_bawah' => 71, 'rentang_atas' => 75.99, 'nilai_angka' => "2.10 - 2.50", 'huruf' => "C+", 'keterangan' => "L"],
            ['rentang_bawah' => 66, 'rentang_atas' => 70.99, 'nilai_angka' => "2.00", 'huruf' => "C", 'keterangan' => "L"],
            ['rentang_bawah' => 61, 'rentang_atas' => 65.99, 'nilai_angka' => "1.60 - 1.90", 'huruf' => "C-", 'keterangan' => "TL"],
            ['rentang_bawah' => 56, 'rentang_atas' => 60.99, 'nilai_angka' => "1.10 - 1.50", 'huruf' => "D+", 'keterangan' => "TL"],
            ['rentang_bawah' => 51, 'rentang_atas' => 55.99, 'nilai_angka' => "1", 'huruf' => "D-", 'keterangan' => "TL"],
            ['rentang_bawah' => 0, 'rentang_atas' => 50.99, 'nilai_angka' => "0", 'huruf' => "E", 'keterangan' => "TL"],
        ];
        // return $nilai;

        foreach ($nilainya as $nilai) {
            foreach ($nilai->anggota as $anggota) {
                // $anggota->nilai->total_nilai = 0;
                // $anggota->nilai->nilai_angka = '0';
                // $anggota->nilai->nilai_huruf = 'E';
                // $anggota->nilai->keterangan = 'TL';
                if ($anggota->nilai != null) {

                    $totalNilai = (0.7 * $anggota->nilai->nilai_eksternal) + (0.3 * $anggota->nilai->nilai_pembimbing);
                    $anggota->nilai->total_nilai = $totalNilai;
                    foreach ($rentang as $row) {
                        //disini mau tentukan berapa nilai angkanya
                        if ($totalNilai >= $row['rentang_bawah'] && $totalNilai <= $row['rentang_atas']) {
                            $anggota->nilai->nilai_angka = $row['nilai_angka'];
                            $anggota->nilai->nilai_huruf = $row['huruf'];
                            $anggota->nilai->keterangan = $row['keterangan'];
                            $anggota->nilai->label = 'success';
                            if ($row['keterangan'] == "TL")
                                $anggota->nilai->label = 'danger';
                            break; // Keluar dari loop jika rentang ditemukan
                        }
                    }
                }
            }
        }

        $data['data'] = $nilainya;
        // return $data;
        // return view('pembimbing.nilai-input', $data);
        return view('pembimbing.nilai-input2', $data);
    }

    public function nilaiStore(Request $request)
    {
        // return $request->all();
        try {
            //code...
            $i = 0;
            $data = [];
            foreach ($request->nilai as $key => $value) {
                // $data[$i]['kelompok_anggota_id'] = $key;
                // $data[$i]['nilai_pembimbing'] = $value;
                // $data[$i]['nilai_eksternal'] = $request->nilai_eksterl[$key];
                // $data[$i]['created_at'] =  Carbon::now();
                // $data[$i]['updated_at'] = Carbon::now();
                // $i++;

                Nilai::updateOrCreate(
                    ['kelompok_anggota_id' => $key],
                    ['nilai_pembimbing' => $value, 'nilai_eksternal' => $request->nilai_eksternal[$key]]
                );
            }
            // Nilai::insert($data);
            return redirect()->back()->with('info', 'Nilai Berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('info', 'Nilai Gagal ditambahkan');
        }
    }

    public function detailKelompok($kelompokId)
    {

        $data['title'] = "Detail Kelompok";
        // $data['data'] = PplPendaftar::with([
        //     'ppl',
        //     'pplKelompokAnggota.pplKelompok.pplLokasi',
        //     'pplKelompokAnggota.kelompokJabatan',
        //     'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        //     // 'pplKelompokAnggota.pplPendaftar',
        // ])
        //     ->get();
        $data['data'] = Kelompok::with([
            'anggota.pendaftar.mahasiswa.dataDiri',
            'lokasi.kuliahLapangan.tahunAkademik',
            'pembimbing.pegawai.dataDiri'
        ])
            ->where('id', $kelompokId)->get();


        // return $data;
        return view('pembimbing.bimbingan-detail', $data);
    }

    public function detailLkh($kelompokId, $id)
    {
        $data['title'] = "Detail LKH";

        $lkh = Lkh::with('dokumentasi')->where('kelompok_anggota_id', $id)->orderBy('tgl_lkh', 'DESC')->paginate(5);
        $lkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('j F Y');;
        });
        $data['data'] = $lkh;
        // $data['data'] = PplKelompok::with([
        //     'pplKelompokAnggota.pplPendaftar',
        //     'pplKelompokAnggota.pplLkh',
        //     'pplLokasi.ppl.tahunAjar',
        //     'pplPembimbing.pplPembimbingInternal'
        // ])
        //     ->whereHas('pplKelompokAnggota', function ($pplKelompokAnggota) use ($id) {
        //         $pplKelompokAnggota->where('ppl_pendaftar_id', $id);
        //     })
        //     ->where('id', $kelompokId)->get();
        // return $data;

        return view('pembimbing.bimbingan-lkh-detail', $data);
    }

    public function laporanShow($id, $kategori)
    {
        $laporan = Laporan::where([
            'kelompok_anggota_id' => $id,
            'kategori' => $kategori,
        ])->first();
        // return $id;
        if ($laporan)
            return response()->json([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $laporan,
            ], 200);

        return response()->json([
            'status' => false,
            'message' => 'data tidak ditemukan',
            'data' => $laporan,
        ], 404);
    }
}
