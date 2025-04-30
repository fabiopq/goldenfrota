<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorizacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bico_id')->unsigned();
            $table->string('endereco')->nullable();
            $table->integer('veiculo_id')->nullable();
            $table->double('km_veiculo', 15, 1)->nullable();
            $table->integer('atendente_id')->unsigned()->nullable();
            $table->integer('motorista_id')->unsigned()->nullable();
            $table->datetime('data_autorizacao')->nullable();
            $table->datetime('data_encerramento')->nullable();
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
        Schema::dropIfExists('autorizacoes');
    }
}
