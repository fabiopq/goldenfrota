<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAtendentesAddSenhaAtendenteApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('atendentes', function (Blueprint $table) {
            $table->string('senha_atendente_app')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atendentes', function (Blueprint $table) {
            $table->dropColumn('senha_atendente_app');
        });
    }
}
