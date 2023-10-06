<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsColunTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('data_abertura')->nullable();
            $table->datetime('data_fechamento')->nullable();
            $table->integer('cliente_id')->nullable()->unsigned();
            $table->text('cliente_nome')->nullable();
            $table->text('solicitante')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('atendente_atribuido_id')->nullable()->unsigned();
            $table->text('titulo')->nullable();
            $table->text('problema')->nullable();
            $table->text('solucao')->nullable();
            $table->integer('atendente_id')->unsigned()->nullable();
            $table->integer('ticket_categoria_id')->unsigned()->nullable();
            $table->integer('ticket_status_id')->unsigned()->nullable();
            $table->integer('tickets_prioridade_id');
            //$table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->foreign('ticket_categoria_id')->references('id')->on('ticket_categoria');
            $table->foreign('ticket_status_id')->references('id')->on('ticket_status');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tickets');
    }
}
