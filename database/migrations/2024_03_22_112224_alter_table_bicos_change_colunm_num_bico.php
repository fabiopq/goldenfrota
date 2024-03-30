<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBicosChangeColunmNumBico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('bicos', function (Blueprint $table) {
            //$table->integer('num_bico')->unique(false)->change();
            $table->dropUnique('bicos_num_bico_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bicos', function (Blueprint $table) {

            $table->integer('num_bico')->unique(true)->change();
        });
    }
}
