<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelWijzigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_wijzigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id');
            $table->enum('rubriek',['wijziging', 'annulatie']);
            $table->string('wijziging')->nullable();
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
        Schema::dropIfExists('hotel_wijzigs');
    }
}
