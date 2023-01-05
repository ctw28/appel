<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProdiPejabatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_prodi_pejabats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_prodi_id');
            $table->unsignedBigInteger('master_jabatan_pegawai_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->string('prodi_pejabat_sk_nomor', 200);
            $table->date('prodi_pejabat_sk_tanggal');
            $table->string('prodi_pejabat_sk_file', 200);
            $table->enum('is_aktif', [0, 1]);
            $table->timestamps();
            $table->foreign('master_prodi_id')->references('id')->on('master_prodis')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->foreign('master_jabatan_pegawai_id')->references('id')->on('master_jabatan_pegawais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_prodi_pejabats');
    }
}
