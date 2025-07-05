<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKembaliPadaToIzinKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // migration
public function up(): void
{
    Schema::table('izin_keluars', function (Blueprint $table) {
        $table->timestamp('kembali_pada')->nullable();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('izin_keluars', function (Blueprint $table) {
            //
        });
    }
}
