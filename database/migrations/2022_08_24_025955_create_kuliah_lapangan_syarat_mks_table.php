<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganSyaratMksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_syarat_mks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuliah_lapangan_syarat_id');
            $table->unsignedBigInteger('kode_mk');
            $table->boolean('is_ditawar');
            $table->timestamps();

            $table->foreign('kuliah_lapangan_syarat_id')->references('id')->on('kuliah_lapangan_syarats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_syarat_mks');
    }
}
