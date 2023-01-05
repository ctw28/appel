<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganPembimbingEksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_pembimbing_eks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id');
            $table->string('nama', 250);
            $table->string('jabatan', 250);
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('lokasi_id')->references('id')->on('kuliah_lapangan_lokasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_pembimbing_eks');
    }
}
