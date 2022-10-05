<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBicosAddColumnEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bicos', function (Blueprint $table) {
            $table->string('endereco')->nullable()->after('permite_insercao');
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
            $table->dropColumn('endereco');
        });
    }
}
