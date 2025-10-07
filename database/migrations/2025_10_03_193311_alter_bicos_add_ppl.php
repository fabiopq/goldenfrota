<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBicosAddPpl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bicos', function (Blueprint $table) {
            
            $table->decimal('ppl', 15, 3)->after('com_defeito')->default(0);
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
            $table->dropColumn('ppl');
        });
    }
}
