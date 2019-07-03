<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\StatuutType;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voornaam');
            $table->string('familienaam');
            $table->string('straat');
            $table->string('huisnummer');
            $table->string('bus')->nullable();
            $table->string('postcode');
            $table->string('gemeente');
            $table->string('telefoon')->nullable();
            $table->string('gsm')->nullable();
            $table->date('geboortedatum');
            $table->string('RRN');
            $table->biginteger('mutualiteit_id')->unsigned();
            $table->string('factuur_naam');
            $table->string('factuur_straat');
            $table->string('factuur_huisnummer');
            $table->string('factuur_bus');
            $table->string('factuur_postcode');
            $table->string('factuur_gemeente');
            $table->string('factuur_email');
            $table->tinyInteger('statuut')->unsigned()->default(StatuutType::RTH);
            $table->biginteger('contactpersoon_id')->unsigned();
            $table->biginteger('user_id')->unsigned();
            
            $table->foreign('contactpersoon_id')->references('id')->on('contactpersoons');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('mutualiteit_id')->references('id')->on('mutualiteits');
            // nog een foreign key on client-code
           
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
        Schema::dropIfExists('clients');
        Schema::dropForeign('contactpersoon_id');
        Schema::dropForeign('user_id');
        Schema::dropForeign('mutualiteit_id');
    }
}
