<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePplKelompokAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppl_kelompok_anggotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ppl_kelompok_id');
            $table->unsignedBigInteger('ppl_pendaftar_id');
            $table->unsignedBigInteger('kelompok_jabatan_id');

            $table->timestamps();
            $table->foreign('ppl_kelompok_id')->references('id')->on('ppl_kelompoks')->onDelete('cascade');
            $table->foreign('ppl_pendaftar_id')->references('id')->on('ppl_pendaftars')->onDelete('cascade');
            $table->foreign('kelompok_jabatan_id')->references('id')->on('kelompok_jabatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppl_kelompok_anggotas');
    }
}
