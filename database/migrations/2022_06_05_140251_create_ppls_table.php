<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_ajar_id');
            $table->string('ppl_nama', 250);
            $table->date('ppl_waktu_daftar_mulai');
            $table->date('ppl_waktu_daftar_selesai');
            $table->date('ppl_waktu_publikasi');
            $table->date('ppl_waktu_pelaksanaan_mulai');
            $table->date('ppl_waktu_pelaksanaan_selesai');
            $table->date('ppl_waktu_tugas_mulai');
            $table->date('ppl_waktu_tugas_selesai');
            $table->date('ppl_waktu_penilaian_mulai');
            $table->date('ppl_waktu_penilaian_selesai');
            $table->text('keterangan')->nullable();
            // $table->enum('publikasi_kelompok', [0, 1])->default(0);
            $table->enum('is_open', [0, 1])->default(0);
            $table->enum('is_finished', [0, 1])->default(0);

            $table->timestamps();
            $table->foreign('tahun_ajar_id')->references('id')->on('master_tahun_ajars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppls');
    }
}
