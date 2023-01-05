<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakultasPejabatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakultas_pejabats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_fakultas_id');
            $table->unsignedBigInteger('master_jabatan_pegawai_id');
            $table->string('pegawai_id', 100);
            $table->string('fakultas_pejabat_sk_nomor', 200);
            $table->date('fakultas_pejabat_sk_tanggal');
            $table->string('fakultas_pejabat_sk_file', 200);
            $table->enum('is_aktif', [0, 1]);
            $table->timestamps();
            $table->foreign('master_fakultas_id')->references('id')->on('master_fakultas')->onDelete('cascade');
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
        Schema::dropIfExists('fakultas_pejabats');
    }
}
