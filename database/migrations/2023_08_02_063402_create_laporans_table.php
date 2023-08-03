<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_anggota_id');
            $table->enum('kategori', ['laporan_akhir', 'laporan_sekolah']);
            $table->string('file_path', 500);


            $table->timestamps();
            $table->foreign('kelompok_anggota_id')->references('id')->on('kuliah_lapangan_kelompok_anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporans');
    }
}
