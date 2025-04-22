<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecoClientesItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preco_cliente_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('preco_cliente_id')->unsigned();
            $table->integer('combustivel_id')->unsigned();
            $table->double('valor_unitario', 15, 3)->nullable()->default(0);
            $table->double('valor_desconto', 15, 3)->nullable()->default(0);
            $table->double('valor_acrescimo', 15, 3)->nullable()->default(0);
            $table->double('perc_desconto', 15, 3)->nullable()->default(0);
            $table->double('perc_acrescimo', 15, 3)->nullable()->default(0);
            $table->timestamps();
            $table->foreign('preco_cliente_id')->references('id')->on('preco_clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preco_cliente_items');
    }
}
