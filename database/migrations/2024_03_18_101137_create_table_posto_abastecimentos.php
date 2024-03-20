<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePostoAbastecimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posto_abastecimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nome')->nullable();
            $table->boolean('ativo')->default(true);
            $table->text('ftp_server')->nullable();
            $table->text('ftp_user')->nullable();
            $table->text('ftp_pass')->nullable();
            $table->integer('ftp_port')->nullable()->default(21);
            $table->text('ftp_root')->nullable();
            $table->boolean('ftp_passive')->nullable();
            $table->boolean('ftp_ssl')->nullable();
            $table->integer('ftp_timeout')->nullable()->default(30);
            $table->text('automacao_valor_combustivel')->nullable();
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
        Schema::dropIfExists('posto_abastecimentos');
    }
}
