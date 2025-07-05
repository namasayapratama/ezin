<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDicetakPadaToIzinMasuksAndKeluars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('izin_masuks', function (Blueprint $table) {
        $table->timestamp('dicetak_pada')->nullable();
    });

    Schema::table('izin_keluars', function (Blueprint $table) {
        $table->timestamp('dicetak_pada')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('izin_masuks_and_keluars', function (Blueprint $table) {
            //
        });
    }
}
