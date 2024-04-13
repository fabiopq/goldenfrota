<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTanquesChangeColunmDescricao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tanques', function (Blueprint $table) {
            
            $table->dropUnique('tanques_descricao_tanque_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tanques', function (Blueprint $table) {
            $table->string('descricao_tanque')->unique(true)->change();
        });
    }
}
