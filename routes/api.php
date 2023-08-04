<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PplLokasiController;
use App\Http\Controllers\PplKelompokController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PplController;
use App\Http\Controllers\PplKelompokAnggotaController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\ApiController;

use App\Http\Controllers\Pembimbing\PembimbingController as Pembimbing;

use App\Http\Controllers\API\KuliahLapanganController;
use App\Http\Controllers\API\LokasiController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\KelompokController;
use App\Http\Controllers\API\PendaftarController;

use App\Http\Controllers\Mahasiswa\MahasiswaController as Mahasiswa;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//untuk login
Route::post('/cek/user/', [LoginController::class, 'check'])->name('userCheck');
Route::post('/cek-login/{role}/', [LoginController::class, 'sessionDirect'])->name('session.direct');


//ini khusus API yang akan dijadikan backend

//USER
Route::post('user', [UserController::class, 'store'])->name('user.store');

//MAHASISWA
Route::post('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

//KULIAH LAPANGAN
Route::post('kuliah-lapangan/{id}/is-aktif/update', [KuliahLapanganController::class, 'is_aktif_update'])->name('kuliah-lapangan.isaktif.update');


//LOKASI
Route::get('ppl/{pplId}/lokasi/limit/{limit}', [LokasiController::class, 'index'])->name('lokasi.index');
Route::get('lokasi/{lokasiId}', [LokasiController::class, 'get'])->name('lokasi.get');
Route::post('ppl/{pplId}/lokasi/simpan', [LokasiController::class, 'store'])->name('lokasi.store');
Route::post('lokasi/{lokasiId}', [LokasiController::class, 'update'])->name('lokasi.update');
Route::get('lokasi/{lokasiId}/hapus', [LokasiController::class, 'delete'])->name('lokasi.delete');


//PEMBIMBING

Route::get('/kuliah-lapangan/{id}/pembimbing/{limit}', [PembimbingController::class, 'index'])->name('pembimbing.get');
Route::post('/kuliah-lapangan/{id}/pembimbing/simpan}', [PembimbingController::class, 'store'])->name('pembimbing.store');

//KELOMPOK
Route::get('/kuliah-lapangan/{id}/lokasi/{lokasiId}/kelompok', [KelompokController::class, 'index'])->name('kelompok.get.all');
Route::get('/kelompok/{id}', [KelompokController::class, 'get'])->name('kelompok.get');
Route::post('/kuliah-lapangan/{id}/lokasi/{lokasiId}/kelompok/simpan', [KelompokController::class, 'store'])->name('kelompok.store');
Route::post('/kelompok/{id}/update', [KelompokController::class, 'update'])->name('kelompok.update');
Route::get('/kelompok/{id}/hapus', [KelompokController::class, 'delete'])->name('kelompok.delete');

//ANGGOTA KELOMPOK
Route::get('/kelompok/{id}/anggota', [KelompokController::class, 'getAnggota'])->name('kelompok.anggota.get');
Route::post('/kelompok/anggota/simpan', [KelompokController::class, 'storeAnggota'])->name('kelompok.anggota.store');
Route::get('/kelompok/anggota/{id}/hapus', [KelompokController::class, 'deleteAnggota'])->name('kelompok.anggota.delete');


//PENDAFTAR
// Route::get('kuliah-lapangan/{id}/pendaftar', [PendaftarController::class, 'index'])->name('pendaftar.all');
Route::get('kuliah-lapangan/{id}/pendaftar/limit/{limit}', [PendaftarController::class, 'get'])->name('pendaftar.get');
Route::post('kuliah-lapangan/{id}/pendaftar/simpan', [PendaftarController::class, 'store'])->name('pendaftar.store');



Route::get('/lokasi/{pplId}', [PplLokasiController::class, 'getLokasi'])->name('get.lokasi');
Route::get('/kelompok/{lokasiId}', [PplKelompokController::class, 'getKelompok'])->name('get.kelompok');
Route::get('/ppl/{pplId}/kelompok/{kelompokId}/pendaftar/status/{status}', [PplController::class, 'getPendaftar'])->name('get.pendaftar');
Route::post('/peserta/simpan', [PplKelompokAnggotaController::class, 'store'])->name('peserta.store');
Route::post('/peserta/hapus', [PplKelompokAnggotaController::class, 'destroy'])->name('peserta.destroy');

Route::post('/ppl/{pplId}/pembimbing-internal/simpan', [PembimbingController::class, 'store'])->name('pembimbing-internal.store');
Route::post('/ppl/{pplId}/pembimbing/hapus', [PembimbingController::class, 'destroy'])->name('pembimbing-internal.destroy');
Route::get('/anggota/{id}/laporan', [Pembimbing::class, 'laporanShow'])->name('laporan.show');


Route::get('/kuliah-lapangan/{id}/syarat-prodi', [ApiController::class, 'getSyaratProdi'])->name('get.prodi');
Route::post('syarat/prodi/simpan', [ApiController::class, 'syaratProdiSrore'])->name('syarat.prodi.store');
Route::post('syarat/prodi/hapus', [ApiController::class, 'syaratProdiDelete'])->name('syarat.prodi.delete');

Route::get('/ppl/{pplId}/syarat', [ApiController::class, 'getSyarat'])->name('syarat');

// LKH
Route::get('/lkh/{id}', [ApiController::class, 'lkhIndex'])->name('lkh.index');
Route::get('/lkh/{id}/detail', [ApiController::class, 'lkhDetail'])->name('lkh.detail');
Route::get('/lkh/{id}/edit', [ApiController::class, 'lkhEdit'])->name('lkh.edit');
Route::post('/lkh/{id}/update', [ApiController::class, 'lkhUpdate'])->name('lkh.update');
Route::get('/lkh/{id}/hapus', [ApiController::class, 'lkhDelete'])->name('lkh.delete');


//PELAPORAN
Route::post('/laporan/simpan', [Mahasiswa::class, 'laporanStore'])->name('laporan.store');

// Route::get('lokasi/{lokasiId}/kelompok', [PembimbingController::class, 'destroy'])->name('ppl.kelompok');


// Route::get('/lokasi/test/', [PplLokasiController::class, 'getLokasi'])->name('login');

// Route::post('/cek-login', [LoginController::class, 'createSession'])->name('create.session');
