<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterOrdemServicosDropVeiculoIdForeignKeyVeiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('
        ALTER TABLE ordem_servicos DROP FOREIGN KEY ordem_servicos_veiculo_id_foreign;
     ');
        Schema::table('ordem_servicos', function (Blueprint $table) {

            //$table->dropUnique('DROP FOREIGN KEY ordem_servicos_veiculo_id_foreign');
            $table->integer('veiculo_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {

            $table->foreign('veiculo_id')->references('id')->on('clientes');
            $table->integer('veiculo_id')->unsigned()->change();
        });
    }
}
