<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterFakultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_fakultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_jenjang_id');
            $table->string('fakultas_nama', 100);
            $table->string('fakultas_singkatan', 20);
            $table->enum('is_fakultas', [0, 1]);
            $table->text('fakultas_visi');
            $table->text('fakultas_misi');
            $table->text('fakultas_keterangan')->nullable();

            $table->timestamps();
            $table->foreign('master_jenjang_id')->references('id')->on('master_jenjangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_fakultas');
    }
}
