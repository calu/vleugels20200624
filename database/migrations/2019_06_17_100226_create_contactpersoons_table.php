<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactpersoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactpersoons', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('voornaam');
            $table->string('familienaam');
            $table->string('relatie');
            $table->string('straat');
            $table->string('huisnummer');
            $table->string('bus')->nullable();
            $table->string('postcode');
            $table->string('gemeente');
            $table->string('telefoon')->nullable();
            $table->string('gsm')->nullable();
            $table->string('email')->nullable();
            $table->enum('rubriek', ['hotel', 'dagverblijf', 'therapie']);
            $table->string('vraag'); 
            
            $table->boolean('openstaand')->default(1);   
                                 
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
        Schema::dropIfExists('contactpersoons');
    }
}
