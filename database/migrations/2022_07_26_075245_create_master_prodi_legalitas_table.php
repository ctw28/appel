<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProdiLegalitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_prodi_legalitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_prodi_id');
            $table->string('sk_nomor', 100);
            $table->date('sk_tanggal');
            $table->string('sk_file', 200);
            $table->enum('is_berlaku', [0, 1]);
            $table->timestamps();

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
        Schema::dropIfExists('master_prodi_legalitas');
    }
}
