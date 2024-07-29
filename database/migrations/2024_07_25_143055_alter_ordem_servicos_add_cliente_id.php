<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterOrdemServicosAddClienteId extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {

            $table->integer('cliente_id')->unsigned()->nullable()->after('data_fechamento');
            $table->foreign('cliente_id')->references('id')->on('clientes');

            // Update the cliente_id column with the id from the clientes table

        });
        
        DB::statement('
        UPDATE ordem_servicos
        SET cliente_id = (
            SELECT cliente_id
            FROM veiculos
            WHERE veiculos.id = ordem_servicos.veiculo_id
        )
     ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servicos', function (Blueprint $table) {

            $table->dropUnique('DROP FOREIGN KEY ordem_servicos_cliente_id_foreign');
            $table->integer('veiculo_id')->unsigned()->change();
        });
    }
}
