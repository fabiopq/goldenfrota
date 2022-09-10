<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMotoristaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('motoristas', function (Blueprint $table) {
                      
           
            $table->string('rg')->nullable()->change();
            $table->string('endereco')->nullable()->change();
            $table->string('numero')->nullable()->change();
            $table->string('bairro')->nullable()->change();
            $table->string('cidade')->nullable()->change();
            $table->integer('uf_id')->nullable()->change();
            $table->string('cep')->nullable()->change();
            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motoristas', function (Blueprint $table) {
            $table->string('rg')->change();
            $table->string('endereco')->change();
            $table->string('numero')->change();
            $table->string('bairro')->change();
            $table->string('cidade')->change();
            $table->integer('uf_id')->change();
            $table->string('cep')->change();
            
            
           
            
        });
    }
}
