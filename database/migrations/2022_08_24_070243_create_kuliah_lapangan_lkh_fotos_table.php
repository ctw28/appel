<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganLkhFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_lkh_fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lkh_id');
            $table->string('foto_path');
            $table->timestamps();
            $table->foreign('lkh_id')->references('id')->on('kuliah_lapangan_lkhs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_lkh_fotos');
    }
}
