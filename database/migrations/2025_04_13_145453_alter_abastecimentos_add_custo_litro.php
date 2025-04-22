<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAbastecimentosAddCustoLitro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
            $table->decimal('custo_litro', 15, 3)->after('valor_litro')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abastecimentos', function (Blueprint $table) {
           
            $table->dropColumn('custo_litro');
        });
    }
}
