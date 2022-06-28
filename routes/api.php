<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PplLokasiController;
use App\Http\Controllers\PplKelompokController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PplController;
use App\Http\Controllers\PplKelompokAnggotaController;
use App\Http\Controllers\PplPembimbingInternalController;
use App\Http\Controllers\ApiController;

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
Route::get('/lokasi/{pplId}', [PplLokasiController::class, 'getLokasi'])->name('get.lokasi');
Route::get('/kelompok/{lokasiId}', [PplKelompokController::class, 'getKelompok'])->name('get.kelompok');
Route::get('/ppl/{pplId}/kelompok/{kelompokId}/pendaftar/status/{status}', [PplController::class, 'getPendaftar'])->name('get.pendaftar');
Route::post('/peserta/simpan', [PplKelompokAnggotaController::class, 'store'])->name('peserta.store');
Route::post('/peserta/hapus', [PplKelompokAnggotaController::class, 'destroy'])->name('peserta.destroy');
Route::get('/ppl/{pplId}/pembimbing', [PplPembimbingInternalController::class, 'getPembimbing'])->name('ppl.pembimbing');

Route::post('/ppl/{pplId}/pembimbing-internal/simpan', [PplPembimbingInternalController::class, 'store'])->name('pembimbing-internal.store');
Route::post('/ppl/{pplId}/pembimbing/hapus', [PplPembimbingInternalController::class, 'destroy'])->name('pembimbing-internal.destroy');


Route::get('/ppl/{pplId}/get-prodi', [ApiController::class, 'getProdi'])->name('get.prodi');
Route::post('/ppl/syarat/prodi/simpan', [ApiController::class, 'syaratProdiSrore'])->name('syarat.prodi.store');
Route::post('/ppl/syarat/prodi/hapus', [ApiController::class, 'syaratProdiDelete'])->name('syarat.prodi.delete');

Route::get('/ppl/{pplId}/syarat', [ApiController::class, 'getSyarat'])->name('syarat');

// Route::get('lokasi/{lokasiId}/kelompok', [PplPembimbingInternalController::class, 'destroy'])->name('ppl.kelompok');


// Route::get('/lokasi/test/', [PplLokasiController::class, 'getLokasi'])->name('login');

// Route::post('/cek-login', [LoginController::class, 'createSession'])->name('create.session');
