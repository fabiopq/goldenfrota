<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTanquesAddColunmNumTanque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tanques', function (Blueprint $table) {
            $table->integer('num_tanque')->unsigned()->nullable()->after('id');
            $table->integer('posto_abastecimento_id')->unsigned()->nullable()->after('num_tanque');
            $table->foreign('posto_abastecimento_id')->references('id')->on('posto_abastecimentos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->dropColumn('num_tanque');
            $table->dropColumn('posto_abastecimento_id');
        });
    }
}
