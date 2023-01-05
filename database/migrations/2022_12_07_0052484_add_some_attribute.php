<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kuliah_lapangan_kelompoks', function (Blueprint $table) {
            $table->string('pembimbing_eksternal', 100);
        });
        // Schema::table('kuliah_lapangan_fakultas', function (Blueprint $table) {
        //     $table->string('singkatan');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
