<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBicosAddDefeito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bicos', function (Blueprint $table) {
            $table->boolean('com_defeito')->nullable()->after('endereco');
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
            $table->dropColumn('com_defeito');
        });
    }
}
