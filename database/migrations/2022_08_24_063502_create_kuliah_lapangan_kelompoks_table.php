<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganKelompoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_kelompoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lokasi_id');
            $table->string('nama_kelompok', 250);
            $table->string('pembimbing_eksternal', 100);
            $table->unsignedBigInteger('pembimbing_id')->nullable();
            $table->unsignedBigInteger('pembimbing_eks_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('lokasi_id')->references('id')->on('kuliah_lapangan_lokasis')->onDelete('cascade');
            $table->foreign('pembimbing_id')->references('id')->on('kuliah_lapangan_pembimbings')->onDelete('set null');
            $table->foreign('pembimbing_eks_id')->references('id')->on('kuliah_lapangan_pembimbing_eks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_kelompoks');
    }
}
