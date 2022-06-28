<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\PplController;
use App\Http\Controllers\PplLokasiController;
use App\Http\Controllers\PplPembimbingInternalController;
use App\Http\Controllers\PplKelompokController;
use App\Http\Controllers\PplKelompokAnggotaController;
use App\Http\Controllers\PplNilaiController;

//mahasiswa Controller
use App\Http\Controllers\Mahasiswa\MahasiswaController;
//Pembimbing Controller
use App\Http\Controllers\Pembimbing\PembimbingController;

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

Route::get('/', function () {
    return view('login');
})->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login-page')->middleware('guest');
Route::get('/user/login', [LoginController::class, 'indexApi'])->name('login-page-api');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/cek-login/{role}/{id}', [LoginController::class, 'sessionDirect'])->name('session.direct');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin', 'middleware' => 'role.admin'], function () {
        Route::get('/dashboard', [DasboardController::class, 'index'])->name('dashboard');
        //PPL
        Route::get('/ppl', [PplController::class, 'index'])->name('admin.ppl');
        Route::get('/ppl/tambah', [PplController::class, 'add'])->name('admin.ppl-tambah');
        Route::post('/ppl/simpan', [PplController::class, 'store'])->name('admin.ppl-store');
        Route::get('/ppl/{pplId}/edit', [PplController::class, 'edit'])->name('admin.ppl.edit');
        Route::post('/ppl/{pplId}/update', [PplController::class, 'update'])->name('admin.ppl.update');
        Route::get('/ppl/{pplId}/hapus', [PplController::class, 'delete'])->name('admin.ppl.delete');
        Route::get('/ppl/{pplId}/syarat-prodi', [PplController::class, 'syaratProdi'])->name('admin.ppl.syarat.prodi');
        Route::get('/ppl/{pplId}/syarat-prodi/{syaratProdiId}/syarat-mata-kuliah', [PplController::class, 'syaratMataKuliah'])->name('admin.ppl.syarat.mata.kuliah');
        Route::post('/ppl/syarat/mata-kuliah/simpan', [PplController::class, 'syaratMataKuliahStore'])->name('admin.ppl.syarat.mata-kuliah.store');

        Route::get('/syarat-mata-kuliah/{syaratMataKuliahId}/delete', [PplController::class, 'syaratMataKuliahDelete'])->name('admin.ppl.syarat.mata.kuliah.delete');
        // LOKASI PPL
        Route::get('ppl/{pplId}/lokasi', [PplLokasiController::class, 'index'])->name('admin.ppl.lokasi');
        Route::get('ppl/{pplId}/lokasi/tambah', [PplLokasiController::class, 'add'])->name('admin.ppl.lokasi.add');
        Route::post('ppl/{pplId}/lokasi/simpan', [PplLokasiController::class, 'store'])->name('admin.ppl.lokasi.store');
        Route::get('lokasi/{lokasiId}/delete', [PplLokasiController::class, 'delete'])->name('admin.ppl.lokasi.delete');
        //PEMBIMBING
        Route::get('ppl/{pplId}/pembimbing-internal', [PplPembimbingInternalController::class, 'index'])->name('admin.ppl.pembimbing-internal');
        Route::get('ppl/{pplId}/pembimbing-internal/tambah', [PplPembimbingInternalController::class, 'add'])->name('admin.ppl.pembimbing-internal.add');
        //KELOMPOK
        Route::get('ppl/kelompok', [PplKelompokController::class, 'index'])->name('admin.ppl.kelompok');
        Route::get('ppl/{pplId}/lokasi/{lokasiId}/kelompok/', [PplKelompokController::class, 'set'])->name('admin.ppl.kelompok.set');
        Route::get('ppl/{pplId}/lokasi/{lokasiId}/kelompok/tambah', [PplKelompokController::class, 'add'])->name('admin.ppl.kelompok.add');
        Route::post('ppl/{pplId}/lokasi/{lokasiId}/kelompok/simpan', [PplKelompokController::class, 'store'])->name('admin.ppl.kelompok.store');
        Route::get('kelompok/{kelompokId}/hapus', [PplKelompokController::class, 'delete'])->name('admin.ppl.kelompok.delete');
        //PESERTA
        Route::get('ppl/peserta', [PplKelompokAnggotaController::class, 'index'])->name('admin.ppl.peserta');
        Route::get('ppl/{pplId}/lokasi/{lokasiId}/kelompok/{kelompokId}/peserta', [PplKelompokAnggotaController::class, 'set'])->name('admin.ppl.peserta.set');
        Route::get('ppl/{pplId}/lokasi/{lokasiId}/kelompok/{kelompokId}/peserta/tambah', [PplKelompokAnggotaController::class, 'add'])->name('admin.ppl.peserta.add');
    });
    Route::group(['prefix' => 'user', 'middleware' => 'role.mahasiswa'], function () {
        Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/ppl', [MahasiswaController::class, 'ppl'])->name('mahasiswa.ppl');
        Route::get('/ppl/{pplId}/daftar', [MahasiswaController::class, 'daftar'])->name('mahasiswa.ppl.daftar');
        Route::get('/ppl/diikuti/{status}', [MahasiswaController::class, 'listPpl'])->name('mahasiswa.ppl.diikuti');

        //LKH
        Route::get('/lkh', [MahasiswaController::class, 'lkh'])->name('mahasiswa.lkh');
        Route::get('/lkh/tambah', [MahasiswaController::class, 'lkhAdd'])->name('mahasiswa.lkh.add');
        Route::post('/lkh/simpan', [MahasiswaController::class, 'lkhStore'])->name('mahasiswa.lkh.store');
        Route::get('/lkh/{lkhId}/edit', [MahasiswaController::class, 'lkhEdit'])->name('mahasiswa.lkh.edit');
        Route::post('/lkh/{lkhId}/update', [MahasiswaController::class, 'lkhUpdate'])->name('mahasiswa.lkh.update');
        Route::get('/lkh/{lkhId}/hapus', [MahasiswaController::class, 'lkhDelete'])->name('mahasiswa.lkh.delete');

        //DETAIL KELOMPOK
        Route::get('/detail-kelompok/{kelompokId}', [MahasiswaController::class, 'detailKelompok'])->name('mahasiswa.kelompok.detail');
    });
    Route::group(['prefix' => 'pembimbing', 'middleware' => 'role.pembimbing'], function () {
        Route::get('/dashboard', [PembimbingController::class, 'index'])->name('pembimbing.dashboard');
        Route::get('/bimbingan/list', [PembimbingController::class, 'list'])->name('pembimbing.list');
        Route::get('/bimbingan/kelompok/{kelompokId}/nilai/input', [PembimbingController::class, 'nilaiInput'])->name('pembimbing.nilai.input');
        Route::post('/bimbingan/kelompok/{kelompokId}/nilai/store}', [PembimbingController::class, 'nilaiStore'])->name('pembimbing.nilai.store');
        Route::get('/bimbingan/kelompok/{kelompokId}/detail', [PembimbingController::class, 'detailKelompok'])->name('pembimbing.detail.kelompok');
        Route::get('/bimbingan/kelompok/{kelompokId}/lkh/{id}', [PembimbingController::class, 'detailLkh'])->name('pembimbing.detail.lkh');
    });
});
