<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function( Blueprint $table){
            $table->foreign('contactpersoon_id')->references('id')->on('contactpersoons');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('mutualiteit_id')->references('id')->on('mutualiteits');
        });  
       
        Schema::table('hotels', function( Blueprint $table){
           $table->foreign('kamer_id')->references('id')->on('kamers')->onDelete('cascade');
        });            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function( Blueprint $table){
            $table->dropForeign(['contactpersoon_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['mutualiteit_id']);            
        });
        
        Schema::table('hotels', function( Blueprint $table){
            $table->dropForeign(['kamer_id']); 

        });                 

    }
}
