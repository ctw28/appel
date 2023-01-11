<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\KuliahLapanganController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PplKelompokController;
use App\Http\Controllers\PplKelompokAnggotaController;
use App\Http\Controllers\PplNilaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengaturanFakultasController;

//mahasiswa Controller
use App\Http\Controllers\Mahasiswa\MahasiswaController;
//Pembimbing Controller
use App\Http\Controllers\Pembimbing\PembimbingController as pembimbing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect()->route('login-page');
// })->middleware('guest');
Route::get('/konfirmasi-akun/{username}/{password}', [LoginController::class, 'konfirmasi'])->name('confirm.user');
Route::get('/', [LoginController::class, 'index'])->name('login-page')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin', 'middleware' => 'role.admin'], function () {
        Route::get('/dashboard', [DasboardController::class, 'index'])->name('dashboard');
        //PPL
        Route::get('/kuliah-lapangan', [KuliahLapanganController::class, 'index'])->name('admin.ppl');
        Route::get('/kuliah-lapangan/tambah', [KuliahLapanganController::class, 'add'])->name('admin.ppl-tambah');
        Route::post('/kuliah-lapangan/simpan', [KuliahLapanganController::class, 'store'])->name('admin.ppl-store');
        Route::get('/kuliah-lapangan/{pplId}/edit', [KuliahLapanganController::class, 'edit'])->name('admin.ppl.edit');
        Route::post('/kuliah-lapangan/{pplId}/update', [KuliahLapanganController::class, 'update'])->name('admin.ppl.update');
        Route::get('/kuliah-lapangan/{pplId}/hapus', [KuliahLapanganController::class, 'delete'])->name('admin.ppl.delete');
        Route::get('/kuliah-lapangan/{pplId}/syarat-prodi', [KuliahLapanganController::class, 'syaratProdi'])->name('admin.ppl.syarat.prodi');
        Route::get('/kuliah-lapangan/{pplId}/syarat-prodi/{syaratProdiId}/syarat-mata-kuliah', [KuliahLapanganController::class, 'syaratMataKuliah'])->name('admin.ppl.syarat.mata.kuliah');
        Route::post('/kuliah-lapangan/syarat/mata-kuliah/simpan', [KuliahLapanganController::class, 'syaratMataKuliahStore'])->name('admin.ppl.syarat.mata-kuliah.store');

        Route::get('/kuliah-lapangan/{id}/data-pendaftar', [KuliahLapanganController::class, 'pendaftar'])->name('pendaftar');

        Route::get('/syarat-mata-kuliah/{syaratMataKuliahId}/delete', [KuliahLapanganController::class, 'syaratMataKuliahDelete'])->name('admin.ppl.syarat.mata.kuliah.delete');
        // LOKASI PPL
        Route::get('kuliah-lapangan/{pplId}/lokasi', [LokasiController::class, 'index'])->name('admin.lokasi');
        Route::get('kuliah-lapangan/{pplId}/lokasi/tambah', [LokasiController::class, 'add'])->name('admin.ppl.lokasi.add');
        Route::post('kuliah-lapangan/{pplId}/lokasi/simpan', [LokasiController::class, 'store'])->name('admin.ppl.lokasi.store');
        Route::get('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/edit', [LokasiController::class, 'edit'])->name('admin.ppl.lokasi.edit');
        Route::post('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/update', [LokasiController::class, 'update'])->name('admin.ppl.lokasi.update');
        Route::get('lokasi/{lokasiId}/delete', [LokasiController::class, 'delete'])->name('admin.ppl.lokasi.delete');
        //PEMBIMBING
        Route::get('kuliah-lapangan/{pplId}/pembimbing-internal', [PembimbingController::class, 'index'])->name('admin.ppl.pembimbing-internal');
        Route::get('kuliah-lapangan/{pplId}/pembimbing-internal/tambah', [PembimbingController::class, 'add'])->name('admin.ppl.pembimbing-internal.add');
        //KELOMPOK
        Route::get('kuliah-lapangan/{id}/lokasi/{lokasiId}/kelompok', [AdminController::class, 'kelompokIndex'])->name('admin.kelompok');
        Route::get('kuliah-lapangan/kelompok', [PplKelompokController::class, 'index'])->name('admin.ppl.kelompok');
        Route::get('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/kelompok/', [PplKelompokController::class, 'set'])->name('admin.ppl.kelompok.set');
        Route::get('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/kelompok/tambah', [PplKelompokController::class, 'add'])->name('admin.ppl.kelompok.add');
        Route::post('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/kelompok/simpan', [PplKelompokController::class, 'store'])->name('admin.ppl.kelompok.store');
        Route::get('kelompok/{kelompokId}/hapus', [PplKelompokController::class, 'delete'])->name('admin.ppl.kelompok.delete');
        //PESERTA
        Route::get('kuliah-lapangan/peserta', [PplKelompokAnggotaController::class, 'index'])->name('admin.ppl.peserta');
        Route::get('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/kelompok/{kelompokId}/peserta', [PplKelompokAnggotaController::class, 'set'])->name('admin.ppl.peserta.set');
        Route::get('kuliah-lapangan/{pplId}/lokasi/{lokasiId}/kelompok/{kelompokId}/peserta/tambah', [PplKelompokAnggotaController::class, 'add'])->name('admin.ppl.peserta.add');
        //PENGATURAN FAKULTAS
        Route::get('kuliah-lapangan/pengaturan', [PengaturanFakultasController::class, 'index'])->name('admin.pengaturan.fakultas');
        Route::post('kuliah-lapangan/pengaturan/fakultas/update', [PengaturanFakultasController::class, 'update'])->name('admin.pengaturan.fakultas.update');
    });
    Route::group(['prefix' => 'user', 'middleware' => 'role.mahasiswa'], function () {
        Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/kuliah-lapangan', [MahasiswaController::class, 'kuliahLapangan'])->name('mahasiswa.ppl');
        Route::get('/kuliah-lapangan/{id}/daftar', [MahasiswaController::class, 'daftar'])->name('mahasiswa.ppl.daftar');
        Route::get('/kuliah-lapangan/diikuti/{status}', [MahasiswaController::class, 'listPpl'])->name('mahasiswa.ppl.diikuti');

        //LKH
        Route::get('kuliah-lapangan/{id}/lkh', [MahasiswaController::class, 'lkh'])->name('mahasiswa.lkh');
        Route::get('kuliah-lapangan/{id}/{anggotaId}/lkh/tambah', [MahasiswaController::class, 'lkhAdd'])->name('mahasiswa.lkh.add');
        Route::post('/lkh/simpan', [MahasiswaController::class, 'lkhStore'])->name('mahasiswa.lkh.store');
        Route::get('/lkh/{lkhId}/edit', [MahasiswaController::class, 'lkhEdit'])->name('mahasiswa.lkh.edit');
        Route::post('/lkh/{lkhId}/update', [MahasiswaController::class, 'lkhUpdate'])->name('mahasiswa.lkh.update');
        Route::get('/lkh/{lkhId}/hapus', [MahasiswaController::class, 'lkhDelete'])->name('mahasiswa.lkh.delete');
        Route::get('/kuliah-lapangan/{id}/lkh/cetak', [MahasiswaController::class, 'lkhPrint'])->name('mahasiswa.lkh.print');

        //DETAIL KELOMPOK
        Route::get('/detail-kelompok/{kelompokId}', [MahasiswaController::class, 'detailKelompok'])->name('mahasiswa.kelompok.detail');
        Route::get('/kelompok/{kelompokId}/lkh/{id}', [MahasiswaController::class, 'detailLkh'])->name('mahasiswa.detail.lkh');
    });
    Route::group(['prefix' => 'pembimbing', 'middleware' => 'role.pembimbing'], function () {
        Route::get('/dashboard', [pembimbing::class, 'index'])->name('pembimbing.dashboard');
        Route::get('/bimbingan/list', [pembimbing::class, 'list'])->name('pembimbing.list');
        Route::get('/bimbingan/kelompok/{kelompokId}/nilai/input', [pembimbing::class, 'nilaiInput'])->name('pembimbing.nilai.input');
        Route::post('/bimbingan/kelompok/{kelompokId}/nilai/store}', [pembimbing::class, 'nilaiStore'])->name('pembimbing.nilai.store');
        Route::get('/bimbingan/kelompok/{kelompokId}/detail', [pembimbing::class, 'detailKelompok'])->name('pembimbing.detail.kelompok');
        Route::get('/bimbingan/kelompok/{kelompokId}/lkh/{id}', [pembimbing::class, 'detailLkh'])->name('pembimbing.detail.lkh');
    });
});
