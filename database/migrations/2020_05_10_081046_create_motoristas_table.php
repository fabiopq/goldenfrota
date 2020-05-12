<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotoristasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('motoristas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();
            $table->string('apelido')->nullable();
            $table->string('cpf');
            $table->string('rg');
            $table->string('habilitacao')->default(null)->nullable();
            $table->string('categoria');
            $table->datetime('data_validade_habilitacao');
            $table->integer('pontos_habilitacao')->nullable();
            $table->string('observacoes')->nullable();
            $table->string('endereco');
            $table->string('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->integer('uf_id')->unsigned();
            $table->string('cep');
            $table->string('fone')->nullable();
            $table->string('email')->nullable();
            $table->datetime('data_nascimento')->nullable();
            $table->datetime('data_admissao')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('tipo_sanguineo')->nullable();
            $table->integer('veiculo_id')->unsigned()->nullable();
            $table->foreign('veiculo_id')->references('id')->on('veiculos')->nullable();
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
        Schema::dropIfExists('motoristas');
    }
}
