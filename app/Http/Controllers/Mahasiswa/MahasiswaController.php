<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KuliahLapangan;
use Illuminate\Http\Request;
use App\Models\Ppl;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\KuliahLapanganPendaftar;
use App\Models\KuliahLapanganSyarat;
use App\Models\KelompokAnggota;
use App\Models\MasterProdi;
use App\Models\PplPendaftar;
use App\Models\Lkh;
use App\Models\Kelompok;
use App\Models\Laporan;
use App\Models\LkhDokumentasi;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MahasiswaController extends Controller
{
    //

    public function index(Request $request)
    {
        $title = "Dashboard";
        $data = KuliahLapanganPendaftar::with([
            'kuliahLapangan' => function ($kuliahLapangan) {
                $kuliahLapangan->where('is_active', true);
            }, 'anggota' => function ($anggota) {
                $anggota->with(['lkh' => function ($lkh) {
                    $lkh->with('dokumentasi')->take(8)->orderBy('tgl_lkh', 'desc');
                }, 'kelompok.anggota.pendaftar.mahasiswa.dataDiri', 'kelompok.lokasi', 'kelompok.pembimbing.pegawai.dataDiri', 'kelompok.pembimbing.pegawai.gelar', 'laporan']);
            }
        ])->whereHas('kuliahLapangan', function ($kuliahLapangan) {
            $kuliahLapangan->where('is_active', true);
        })->where('mahasiswa_id', Auth::user()->userMahasiswa->id)->first();
        // return $data;
        // $data->map(function ($item) {
        // });
        if (!empty($data->anggota)) {

            $data->anggota->lkh->map(function ($item) {
                $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
                $tglIndo->settings(['formatFunction' => 'translatedFormat']);
                $item->tgl_lkh = $tglIndo->format('l, j F Y');
                $item->kegiatan = \Illuminate\Support\Str::limit($item->kegiatan, 50, $end = '...');
            });
        }
        if (!empty($data)) {
            $data->kuliahLapangan->waktu_pelaksanaan_mulai = \FormatWaktu::tanggalIndonesia($data->kuliahLapangan->waktu_pelaksanaan_mulai);
            $sisa = Carbon::parse($data->kuliahLapangan->waktu_pelaksanaan_selesai);
            $sisaHari = $sisa->diffInDays(Carbon::now());
            $data->kuliahLapangan->sisa_hari = $sisaHari + 1;
            $data->kuliahLapangan->waktu_pelaksanaan_selesai = \FormatWaktu::tanggalIndonesia($data->kuliahLapangan->waktu_pelaksanaan_selesai);
            if (Carbon::now()->gte($data->kuliahLapangan->waktu_publikasi_kelompok))
                // return $data;

                return view('mahasiswa.dashboard', compact('title', 'data'));
            $data = KuliahLapanganPendaftar::with([
                'kuliahLapangan' => function ($kuliahLapangan) {
                    $kuliahLapangan->where('is_active', true);
                }
            ])->whereHas('kuliahLapangan', function ($kuliahLapangan) {
                $kuliahLapangan->where('is_active', true);
            })->where('mahasiswa_id', Auth::user()->userMahasiswa->id)->first();
            // return $data;
            return view('mahasiswa.dashboard', compact('title', 'data'));
        }
        // $data = [];
        return view('mahasiswa.dashboard', compact('title', 'data'));

        // whereHas(
        //     'kuliahLapangan',
        //     function ($lokasi) {
        //         $lokasi->with('lokasi.kelompok.anggota', function ($anggota) {
        //             $anggota->where('mahasiswa_id', Auth::user()->userMahasiswa->id);
        //         }, 'lokasi.kelompok.pembimbing.pegawai.dataDiri')
        //             ->whereHas('lokasi.kelompok.anggota', function ($anggota) {
        //                 $anggota->where('mahasiswa_id', Auth::user()->userMahasiswa->id);
        //             }, 'lokasi.kelompok.pembimbing.pegawai.dataDiri');
        //     }
    }

    public function kuliahLapangan(Request $request)
    {
        $data['title'] =  "Pendaftaran " . session('fakultasData')->singkatan;
        $mahasiswa = User::with('userMahasiswa.mahasiswa.dataDiri')->find(Auth::user()->id);
        $prodi = MasterProdi::with('fakultas')->find($mahasiswa->userMahasiswa->mahasiswa->master_prodi_id);
        // return $prodi;

        $ppl = Ppl::with(['kuliahLapangan' => function ($kuliahLapangan) {
            $kuliahLapangan->whereDate('waktu_daftar_mulai', '<=', Carbon::now())
                ->whereDate('waktu_daftar_selesai', '>=', Carbon::now())
                // ->orWhere('is_daftar_open', true)
                ->where('is_active', true)
                ->with(['tahunAkademik', 'pendaftar' => function ($pendaftar) {
                    $pendaftar->where('mahasiswa_id', Auth::user()->userMahasiswa->id);
                }]);
        }])
            ->whereHas('kuliahLapangan', function ($kuliahLapangan) {
                $kuliahLapangan->whereDate('waktu_daftar_mulai', '<=', Carbon::now())
                    ->whereDate('waktu_daftar_selesai', '>=', Carbon::now())
                    // ->orWhere('is_daftar_open', true)
                    ->where('is_active', true)

                    ->with('tahunAkademik');
            })
            ->where('master_fakultas_id', $prodi->master_fakultas_id)->get();
        // return $ppl;
        if ($ppl->count() != 0) {
            $ppl->map(function ($item) {
                $item->kuliahLapangan->waktu_daftar_mulai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_daftar_mulai);
                $item->kuliahLapangan->waktu_daftar_selesai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_daftar_selesai);
                $item->kuliahLapangan->waktu_pelaksanaan_mulai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_mulai);
                $item->kuliahLapangan->waktu_pelaksanaan_selesai = \FormatWaktu::tanggalIndonesia($item->kuliahLapangan->waktu_pelaksanaan_selesai);
                if ($item->kuliahLapangan->is_finished == true) {
                    $item->kuliahLapangan->label = "success";
                    $item->kuliahLapangan->is_finished = "Selesai";
                } else {
                    $item->kuliahLapangan->label = "warning";
                    $item->kuliahLapangan->is_finished = "Aktif";
                }

                if ($item->kuliahLapangan->pendaftar->count() == 1) {
                    $item->status_daftar = "Anda sudah mendaftar";
                    $item->status_label = "secondary";
                    $item->link = "#";
                } else {
                    $item->status_daftar = "Daftar";
                    $item->status_label = "primary";
                    $item->link = route('mahasiswa.ppl.daftar', $item->kuliahLapangan->id);
                }
            });
        }
        $data['data'] = $ppl;
        return view('mahasiswa.kuliah-lapangan', $data);
    }

    public function daftar($id)
    {

        // return Auth::user()->userMahasiswa->mahasiswa->master_prodi_id;
        $check = KuliahLapanganPendaftar::where('mahasiswa_id', Auth::user()->userMahasiswa->mahasiswa_id)->where('kuliah_lapangan_id', $id)->first();
        // return $check;
        if (empty($check)) {
            $checkSyaratProdi = KuliahLapanganSyarat::where([
                'kuliah_lapangan_id' => $id,
                'master_prodi_id' => Auth::user()->userMahasiswa->mahasiswa->master_prodi_id,
            ])->first();
            // return $checkSyarat;
            if (!empty($checkSyaratProdi)) {
                $save = KuliahLapanganPendaftar::create([
                    'kuliah_lapangan_id' => $id,
                    'mahasiswa_id' => Auth::user()->userMahasiswa->mahasiswa_id,
                    'is_memenuhi' => true
                ]);
                return redirect()->route('mahasiswa.dashboard');
            }
            return redirect()->back()->with('error', 'Prodi Anda tidak dapat terdaftar mengikuti kegiatan');
        } else {
            return redirect()->back()->with('error', 'Anda Sudah Daftar');
        }

        // return $save;
        // $data['title'] = "Pendaftaran PLP";
        // $pplData = Ppl::with('tahunAjar')->find($pplId);
        // $data['pplData'] = $pplData;

        // return view('mahasiswa.ppl-daftar', $data);
    }

    public function listPpl(Request $request, $status)
    {
        $data['title'] = "PLP Diikuti";
        if ($status == "berjalan")
            $status = 0;
        else
            $status = 1;
        $pplDiikuti = KuliahLapangan::with(['ppl' => function ($ppl) use ($status) {
            $ppl->with('tahunAjar')->where('is_finished', $status);
        }])->where('iddata', $request->session()->get('data'))->get();
        if ($status == "semua")
            $pplDiikuti = KuliahLapangan::with(['ppl', 'tahunAjar'])->where('iddata', $request->session()->get('data'))->get();
        $data['pplData'] = $pplDiikuti;
        // return $data;
        return view('mahasiswa.ppl-diikuti', $data);
    }

    public function lkh($kuliahLapanganId)
    {
        $data['title'] = "Daftar Lembar Kerja Harian (LKH)";

        $data['data'] = KuliahLapanganPendaftar::with([
            'kuliahLapangan',
            'anggota.kelompok.lokasi',
            'anggota.kelompok.pembimbing.pegawai.dataDiri',
            'anggota.lkh',
        ])
            ->where([
                'kuliah_lapangan_id' => $kuliahLapanganId,
                'mahasiswa_id' => Auth::user()->userMahasiswa->mahasiswa_id,
            ])->first();
        $data['data']->anggota->lkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('l, j F Y');
        });
        // return $data;
        return view('mahasiswa.ppl-lkh', $data);
    }


    public function lkhPrint($kuliahLapanganId)
    {
        $data['data'] = KuliahLapanganPendaftar::with([
            'kuliahLapangan',
            'anggota.kelompok.lokasi',
            'anggota.kelompok.pembimbing.pegawai.dataDiri',
            'anggota.lkh' => function ($lkh) {
                $lkh->with('dokumentasi')->orderBy('tgl_lkh', 'desc');
            },
        ])
            ->where([
                'kuliah_lapangan_id' => $kuliahLapanganId,
                'mahasiswa_id' => Auth::user()->userMahasiswa->mahasiswa_id,
            ])->first();
        $data['data']->anggota->lkh->map(function ($item) {
            $tglIndo = Carbon::parse($item->tgl_lkh)->locale('id');
            $tglIndo->settings(['formatFunction' => 'translatedFormat']);
            $item->tgl_lkh = $tglIndo->format('l, j F Y');
        });
        return view('mahasiswa.lkh-cetak', $data);

        return $data;
    }

    public function lkhAdd($kuliahLapanganId, $anggotaId)
    {
        $data['title'] = "Tambah Lembar Kerja Harian (LKH)";
        $data['kuliah_lapangan_id'] = $kuliahLapanganId;
        $data['anggotaID'] = $anggotaId;
        // $data['data'] = KuliahLapanganPendaftar::with([
        //     'anggota.lkh' => function ($lkh) use ($anggotaId) {
        //         $lkh->where('kelompok_anggota_id', $anggotaId);
        //     }
        // ]);
        // return $data;
        return view('mahasiswa.ppl-lkh-tambah', $data);
    }

    public function lkhStore(Request $request)
    {

        try {
            DB::beginTransaction();

            $request->validate([
                'anggota_id' => 'required',
                'kegiatan' => 'required',
                'tgl_lkh' => 'required',
                'photos.*' => 'required|image|mimes:jpeg,png,jpg|file|max:512',
                // 'photos' => 'max:3'
            ]);
            // $data['foto_path'] = $request->file('foto_path')->store('lkh-images');
            $lkh = Lkh::create([
                'kelompok_anggota_id' => $request->anggota_id,
                'kegiatan' => $request->kegiatan,
                'tgl_lkh' => $request->tgl_lkh,
            ]);
            foreach ($request->photos as $imagefile) {
                // $upload = $imagefile->store('/lkh-images');
                // $imageName = rand() . '.' . $imagefile->extension();
                $filenameWithExt = $imagefile->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $imagefile->getClientOriginalExtension();
                $filenameSimpan = $filename . '_' . time() . '.' . $extension;

                $upload = $imagefile->storeAs('lkh-images', $filenameSimpan);

                LkhDokumentasi::create([
                    'lkh_id' => $lkh->id,
                    'foto_path' => $upload
                ]);
            }
            // $kuliahLapangan = Lkh 
            DB::commit();
            return redirect()->route('mahasiswa.lkh', $request->kuliah_lapangan_id)->with('success', 'LKH berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;

            return redirect()->back()->withInput($request->input())->with('error', 'LKH gagal ditambahkan, pastikan inputan dan file yang diupload sesuai ketentuan!');
        }
    }

    public function lkhEdit(Request $request, $lkhId)
    {
        $data['title'] = "Tambah Lembar Kerja Harian (LKH)";
        $data['data'] = PplPendaftar::with([
            'ppl',
            'pplKelompokAnggota.pplKelompok.pplLokasi',
            'pplKelompokAnggota.kelompokJabatan',
            'pplKelompokAnggota.pplKelompok.pplPembimbing.pplPembimbingInternal',
        ])
            ->where('iddata', $request->session()->get('data'))->get();
        $data['lkhData'] = PplLkh::find($lkhId);
        // return $data;
        return view('mahasiswa.ppl-lkh-edit', $data);
    }

    public function lkhUpdate(Request $request, $lkhId)
    {
        try {
            $lkh = Lkh::find($lkhId);
            $filePath = $lkh->foto_path;
            $data = $request->validate([
                'ppl_kelompok_anggota_id' => 'required',
                'kegiatan' => 'required',
                'tgl_lkh' => 'required',
                'foto_path' => 'image|mimes:jpeg,png,jpg|file|max:2048',
            ]);
            if ($request->file('foto_path')) {
                Storage::delete($filePath);
                $data['foto_path'] = $request->file('foto_path')->store('lkh-images');
            }
            PplLkh::find($lkhId)->update($data);
            // PplLkh::create($data);
            return redirect()->route('mahasiswa.lkh')->with('success', 'LKH berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'LKH gagal diubah');
        }
    }


    public function lkhDelete($lkhId)
    {
        try {
            $data = Lkh::with('dokumentasi')->find($lkhId);
            $dokumentasi = $data->dokumentasi;
            // return $dokumentasi;
            $data->delete();
            foreach ($dokumentasi as $foto) {
                Storage::delete($foto->foto_path);
            }
            return redirect()->route('mahasiswa.lkh')->with('success', 'LKH berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'LKH gagal ditambahkan');
            // throw $th;
        }
    }

    public function detailKelompok(Request $request, $kelompokId)
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
            'anggota.pendaftar.mahasiswa.prodi',
            'lokasi.kuliahLapangan.tahunAkademik',
            'pembimbing.pegawai.dataDiri'
        ])
            ->where('id', $kelompokId)->get();


        // return $data;
        return view('mahasiswa.ppl-detail-kelompok', $data);
    }

    public function detailLkh($kelompokId, $anggotaId)
    {
        $data['title'] = "Detail LKH";

        $lkh = Lkh::with('dokumentasi')->where('kelompok_anggota_id', $anggotaId)->orderBy('tgl_lkh', 'DESC')->paginate(5);
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

        return view('mahasiswa.lkh-detail', $data);
    }



    public function laporanAdd()
    {
        $data['title'] = "Pelaporan";
        // $data['data'] = KelompokAnggota::with(['laporan'])
        //     ->where('id', Auth::user()->userMahasiswa->mahasiswa->kuliahLapanganPendaftar[0]->anggota->id)->get();
        $anggotaLaporan = KelompokAnggota::with(['laporan'])
            ->where('id', Auth::user()->userMahasiswa->mahasiswa->kuliahLapanganPendaftar[0]->anggota->id)->get();
        $data['data'] = $anggotaLaporan;
        $laporanAkhir = [];
        $laporanSekolah = [];

        if (count($anggotaLaporan[0]->laporan) != 0) {
            foreach ($anggotaLaporan[0]->laporan as $item) {
                // $anggotaLaporan[0]->laporan->map(function ($item) use ($laporanAkhir, $laporanSekolah) {
                if ($item->kategori == "laporan_akhir")
                    $laporanAkhir[] = $item;
                else if ($item->kategori == "laporan_sekolah")
                    $laporanSekolah[] = $item;
            };
        }
        $data['laporanAkhir'] = $laporanAkhir;
        $data['laporanSekolah'] = $laporanSekolah;
        // if($anggotaLaporan[0]->laporan)
        // return $data;
        return view('mahasiswa.laporan', $data);
    }

    public function laporanStore(Request $request)
    {
        // if ($request->hasFile('file_path')) {

        //     // return $request->file('file_path');
        //     $uploadedFiles = [];

        //     foreach ($request->file('file_path') as $file) {
        //         $filename = $file->getClientOriginalName();
        //         $file->storeAs('laporan/bukti_setor_sekolah', $filename);
        //         $uploadedFiles[] = $filename;
        //     }
        //     return $uploadedFiles;
        // }
        // return $request->all();
        try {

            $request->validate([
                'kelompok_anggota_id' => 'required',
                'kategori' => 'required',
                'file_path' => 'required',
                'status' => 'required',
                'file_delete_if_update' => 'string', //ini nama file yang akan di remove jika update sukses
                // 'photos' => 'max:3'
            ]);
            $imagefile = $request->file('file_path');
            $filenameWithExt = $imagefile->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagefile->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;

            $upload = $imagefile->storeAs('laporan', $filenameSimpan);
            $laporan = Laporan::updateOrCreate(
                [
                    'kelompok_anggota_id' => $request->kelompok_anggota_id,
                    'kategori' => $request->kategori
                ],
                ['file_path' => $upload]
            );

            if ($request->status == 'update')
                Storage::delete($request->file_delete_if_update);

            return response()->json([
                'status' => true,
                'message' => 'Sukses ditambahkan',
                'data' => $laporan,
            ], 200);
            // return redirect()->route('mahasiswa.lkh', $request->kuliah_lapangan_id)->with('success', 'LKH berhasil ditambahkan');
        } catch (\Throwable $th) {
            // return $th;
            return response()->json([
                'status' => false,
                'message' => 'gagal insert',
                'data' => $th,
            ], 500);

            return redirect()->back()->withInput($request->input())->with('error', 'LKH gagal ditambahkan, pastikan inputan dan file yang diupload sesuai ketentuan!');
        }
    }
}
