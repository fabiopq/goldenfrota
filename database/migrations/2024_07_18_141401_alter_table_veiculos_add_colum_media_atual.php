<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableVeiculosAddColumMediaAtual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('veiculos', function (Blueprint $table) {
            
            $table->decimal('media_atual', 15, 3)->after('hodometro_decimal')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('veiculos', function (Blueprint $table) {
           
            $table->dropColumn('media_atual');
        });
    }
}
