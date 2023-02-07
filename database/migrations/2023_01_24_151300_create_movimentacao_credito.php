<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentacaoCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao_creditos', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('data_movimentacao');
            $table->integer('cliente_id')->unsigned();
            $table->integer('combustivel_id')->unsigned()->nullable();
            $table->integer('tipo_movimentacao_produto_id')->unsigned();
            $table->double('quantidade_movimentada', 10, 3);
            $table->double('valor_unitario', 10, 3);
            $table->double('valor', 10, 3);
            $table->integer('user_id')->unsigned();
            $table->text('observacao')->nullable();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            //$table->foreign('combustivel_id')->references('id')->on('combustiveis');
           
            
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
        Schema::dropIfExists('movimentacao_creditos');
    }
}
