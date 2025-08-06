<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrdemServicoTableAddMotorista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            // Adicionando as novas colunas
            $table->integer('atendente_id')->unsigned()->nullable()->after('km_veiculo');
            $table->integer('motorista_id')->unsigned()->nullable()->after('atendente_id');

            // Adicionando as chaves estrangeiras 
            $table->foreign('atendente_id')->references('id')->on('atendentes')->onDelete('set null');
            $table->foreign('motorista_id')->references('id')->on('motoristas')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {
            // Removendo as chaves estrangeiras primeiro
            $table->dropForeign(['atendente_id']);
            $table->dropForeign(['motorista_id']);

            // Removendo as colunas
            $table->dropColumn('atendente_id');
            $table->dropColumn('motorista_id');
        });
    }
}
