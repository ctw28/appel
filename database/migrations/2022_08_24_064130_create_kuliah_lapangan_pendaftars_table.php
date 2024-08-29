<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganPendaftarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_pendaftars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuliah_lapangan_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->boolean('is_memenuhi');
            $table->string('id_krs_sia');
            $table->boolean('is_sinkron_sia')->default(false);

            $table->timestamps();
            $table->foreign('kuliah_lapangan_id')->references('id')->on('kuliah_lapangans')->onDelete('cascade');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_pendaftars');
    }
}
