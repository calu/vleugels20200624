<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactuursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factuurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('factuurvolgnummer');
            $table->integer('jaar');
            $table->date('datum');
            $table->integer('serviceable_id');
            $table->string('serviceable_type');
            $table->string('omschrijving');
            $table->integer('aantal');
            $table->float('prijs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factuurs');
    }
}
