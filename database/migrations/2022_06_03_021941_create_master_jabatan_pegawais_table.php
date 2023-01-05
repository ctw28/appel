<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterJabatanPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jabatan_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan_nama', 100);
            $table->string('jabatan_singkatan', 20);
            $table->string('jabatan_untuk', 200);
            $table->integer('jabatan_urutan');
            $table->string('jabatan_keterangan', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_jabatan_pegawais');
    }
}
