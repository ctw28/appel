<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganKelompokAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_kelompok_anggotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_id');
            $table->unsignedBigInteger('pendaftar_id');
            $table->unsignedBigInteger('jabatan_id');

            $table->timestamps();
            $table->foreign('kelompok_id')->references('id')->on('kuliah_lapangan_kelompoks')->onDelete('cascade');
            $table->foreign('pendaftar_id')->references('id')->on('kuliah_lapangan_pendaftars')->onDelete('cascade');
            $table->foreign('jabatan_id')->references('id')->on('kuliah_lapangan_jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok_anggotas');
    }
}
