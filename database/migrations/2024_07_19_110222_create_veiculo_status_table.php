<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculoStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculo_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('veiculo_id')->unsigned()->nullable();
            //status_id 0=resolvido  1=alerta 2=bloqueio
            $table->integer('status_id')->default(0);
            $table->datetime('data');
            $table->text('historico')->nullable();
            $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('veiculo_status');
    }
}
