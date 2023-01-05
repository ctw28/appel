<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKuliahLapanganFakultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuliah_lapangan_fakultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_fakultas_id');
            $table->string('sebutan');
            $table->string('singkatan');
            $table->string('sebutan_eksternal');
            $table->timestamps();

            $table->foreign('master_fakultas_id')->references('id')->on('master_fakultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuliah_lapangan_fakultas');
    }
}
