<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWijzigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wijzigs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('serviceable_id');
            $table->string('serviceable_type');
            $table->enum('rubriek',['wijziging', 'annulatie']);                     
            $table->date('datumvan')->nullable();
            $table->date('datumtot')->nullable();
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
        Schema::dropIfExists('wijzigs');
    }
}
