<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsNullableInFactuurs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factuurs', function (Blueprint $table) {
            $table->integer('factuurvolgnummer')->nullable()->change();
            $table->integer('jaar')->nullable()->change();
            $table->date('datum')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factuurs', function (Blueprint $table) {
            //
        });
    }
}
