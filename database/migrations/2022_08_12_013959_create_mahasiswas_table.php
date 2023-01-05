<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('iddata', 100);
            $table->string('nim', 100);
            $table->unsignedBigInteger('data_diri_id');
            $table->unsignedBigInteger('master_prodi_id');
            $table->timestamps();

            $table->foreign('data_diri_id')->references('id')->on('data_diris')->onDelete('cascade');
            $table->foreign('master_prodi_id')->references('id')->on('master_prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
