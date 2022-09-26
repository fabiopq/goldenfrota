<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoEstoqueCombustivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_estoque_combustiveis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tanque_id')->unsigned();
            $table->integer('combustivel_id')->unsigned();
            $table->double('quantidade', 10, 3);
            $table->integer('abastecimento_id')->unsigned()->nullable();
            $table->foreign('tanque_id')->references('id')->on('tanques');
            $table->foreign('combustivel_id')->references('id')->on('combustiveis');
            $table->timestamps('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_estoque_combustiveis');
    }
}
