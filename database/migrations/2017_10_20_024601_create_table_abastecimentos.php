<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAbastecimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abastecimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_automacao')->nullable();
            $table->integer('ns_automacao')->nullable();
            $table->integer('bico_id')->unsigned()->nullable();
            $table->double('encerrante_inicial', 15, 3)->nullable();
            $table->double('encerrante_final', 15, 3)->nullable();
            $table->double('volume_abastecimento', 15, 3);
            $table->double('valor_litro', 15, 3);
            $table->double('valor_abastecimento', 15, 3);
            $table->integer('atendente_id')->unsigned()->nullable();
            $table->integer('veiculo_id')->unsigned()->nullable();
            $table->double('km_veiculo', 15, 1)->nullable();
            $table->string('requisicao_abastecimento')->nullable();
            $table->boolean('ativo')->default(true);
            $table->foreign('bico_id')->references('id')->on('bicos');
            $table->foreign('atendente_id')->references('id')->on('atendentes');
            $table->foreign('veiculo_id')->references('id')->on('veiculos');
            $table->datetime('data_hora_abastecimento');
            $table->boolean('abastecimento_local')->default(true);
            $table->string('obs_abastecimento')->nullable();
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
        Schema::dropIfExists('abastecimentos');
    }
}
