<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganLokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_lokasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuliah_lapangan_id');
            $table->string('lokasi', 250);
            $table->string('alamat', 250);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kuliah_lapangan_id')->references('id')->on('kuliah_lapangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_lokasis');
    }
}
