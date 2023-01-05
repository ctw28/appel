<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganKelompokPembimbingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_kelompok_pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_id');
            $table->unsignedBigInteger('pembimbing_id')->nullable();
            $table->unsignedBigInteger('pembimbing_eks_id')->nullable();
            $table->string('pembimbing_eksternal')->nullable();
            $table->timestamps();

            $table->foreign('kelompok_id')->references('id')->on('kuliah_lapangan_kelompoks')->onDelete('cascade');
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
        Schema::dropIfExists('kuliah_lapangan_kelompok_pembimbings');
    }
}
