<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVraagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vraags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('vraagsteller');
            $table->unsignedInteger('vraagtype');
            $table->string('vraag');
            $table->enum('status',['aangevraagd','beantwoord']);
            $table->date('datumvraag');
            $table->date('datumantwoord')->nullable();
            $table->string('antwoord')->nullable();
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
        Schema::dropIfExists('vraags');
    }
}
