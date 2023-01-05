<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganSyaratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_syarats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_prodi_id');
            $table->unsignedBigInteger('kuliah_lapangan_id');
            $table->integer('sks');
            $table->timestamps();

            $table->foreign('master_prodi_id')->references('id')->on('master_prodis')->onDelete('cascade');
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
        Schema::dropIfExists('kuliah_lapangan_syarats');
    }
}
