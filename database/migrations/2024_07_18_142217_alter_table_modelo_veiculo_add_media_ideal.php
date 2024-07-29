<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableModeloVeiculoAddMediaIdeal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modelo_veiculos', function (Blueprint $table) {
            $table->integer('tipo_controle_bloqueio')->default(0);
            $table->decimal('media_ideal', 15, 3)->default(0);
            $table->decimal('variacao_negatia', 15, 3)->default(0);
            $table->decimal('variacao_positiva', 15, 3)->default(0);
            //
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
            $table->dropColumn('tipo_controle_bloqueio');
            $table->dropColumn('media_ideal');
            $table->dropColumn('variacao_negatia');
            $table->dropColumn('variacao_positiva');
        });
    }
}
