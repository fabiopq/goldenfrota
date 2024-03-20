<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTipoMovimentacaoCredito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_movimentacao_credito', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_movimentacao_credito');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        DB::table('tipo_movimentacao_credito')->insert([
            ['tipo_movimentacao_credito' => 'Entrada', 'ativo' => true],
            ['tipo_movimentacao_credito' => 'Saida', 'ativo' => true],
            
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_movimentacao_credito');
    }
}
