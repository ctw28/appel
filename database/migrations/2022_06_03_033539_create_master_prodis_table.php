<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterProdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_prodis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_fakultas_id');
            $table->string('prodi_kode', 100);
            $table->string('prodi_nama', 100);
            $table->text('prodi_visi');
            $table->integer('prodi_urutan')->default(1);
            $table->text('prodi_misi');
            $table->text('prodi_keterangan');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->foreign('master_fakultas_id')->references('id')->on('master_fakultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_prodis');
    }
}
