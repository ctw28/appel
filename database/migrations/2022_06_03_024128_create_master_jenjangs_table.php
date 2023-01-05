<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterJenjangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jenjangs', function (Blueprint $table) {
            $table->id();
            $table->string('jenjang_nama', 100);
            $table->string('jenjang_gelar', 100);
            $table->string('jenjang_singkatan', 5);
            $table->string('jenjang_kode_dikti', 5);
            // $table->string('sebutan_pimpinan', 50);
            $table->string('sebutan_tugas_akhir', 100);

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
        Schema::dropIfExists('master_jenjangs');
    }
}
