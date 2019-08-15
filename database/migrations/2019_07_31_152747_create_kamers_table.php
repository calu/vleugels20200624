<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKamersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('aantal_bedden')->unsigned();
            $table->integer('soort');
            $table->integer('kamernummer')->unique();
            $table->string('beschrijving');
            $table->string('foto'); // is de url van de fato (in public/kamerfoto)                        
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
        Schema::dropIfExists('kamers');
    }
}
