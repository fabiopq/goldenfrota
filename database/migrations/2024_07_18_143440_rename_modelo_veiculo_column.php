<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameModeloVeiculoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modelo_veiculos', function (Blueprint $table) {
            //
            $table->renameColumn('variacao_negatia', 'variacao_negativa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modelo_veiculos', function (Blueprint $table) {
            //
        });
    }
}
