<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganPembimbingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_pembimbings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuliah_lapangan_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->timestamps();

            $table->foreign('kuliah_lapangan_id')->references('id')->on('kuliah_lapangans')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_pembimbings');
    }
}
