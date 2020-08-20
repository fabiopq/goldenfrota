<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAtendentesAddIdVeiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendentes', function (Blueprint $table) {
            $table->unsignedInteger('veiculo_id')->after('senha_atendente');
            $table->foreign('veiculo_id')->references('id')->on('veiculos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atendentes', function (Blueprint $table) {
            $table->dropForeign('atendentes_veiculo_id_foreign');
            $table->dropColumn('veiculo_id');
        });
    }
}
