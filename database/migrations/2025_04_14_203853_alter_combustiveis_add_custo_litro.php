<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCombustiveisAddCustoLitro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('combustiveis', function (Blueprint $table) {
            $table->decimal('custo', 15, 3)->after('valor')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('combustiveis', function (Blueprint $table) {
           
            $table->dropColumn('custo');
        });
    }}
