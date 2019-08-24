<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('reservatiesoort',['hotel', 'dagverblijf', 'therapie']);
            $table->enum('status',['aangevraagd', 'actief', 'voorbij']);

            $table->bigInteger('user_id')->unsigned()->nullable();
            
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
        Schema::dropIfExists('services');
    }
}
