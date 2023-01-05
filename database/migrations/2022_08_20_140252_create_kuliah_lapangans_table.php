<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_akademik_id');
            $table->unsignedBigInteger('created_by');
            $table->string('kuliah_lapangan_nama', 250);
            $table->date('waktu_daftar_mulai');
            $table->date('waktu_daftar_selesai');
            $table->date('waktu_publikasi_kelompok');
            $table->date('waktu_pelaksanaan_mulai');
            $table->date('waktu_pelaksanaan_selesai');
            $table->date('waktu_tugas_mulai');
            $table->date('waktu_tugas_selesai');
            $table->date('waktu_penilaian_mulai');
            $table->date('waktu_penilaian_selesai');
            $table->text('keterangan')->nullable();
            $table->boolean('is_daftar_open')->default(false);
            $table->boolean('is_ppl')->default(true);
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->foreign('tahun_akademik_id')->references('id')->on('master_tahun_akademiks')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangans');
    }
}
