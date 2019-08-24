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

        Schema::table('services', function( Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
        });
 
        Schema::table('client_services', function( Blueprint $table){
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelet('cascade');
       });    
       
        Schema::table('hotels', function( Blueprint $table){
           $table->foreign('kamer_id')->references('id')->on('kamers')->onDelete('cascade');
           $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
       });            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function( Bluepring $table){
            Schema::dropForeign('contactpersoon_id');
            Schema::dropForeign('user_id');
            Schema::dropForeign('mutualiteit_id');            
        });
        
        Schema::table('services', function( Blueprint $table){
            Schema::dropForeign('user_id');  // moet dit wel?
        });        
        
        Schema::table('client_services', function( Blueprint $table){
            $table->dropForeign('client_id');
            $table->dropForeign('service_id');
        }); 
        
        Schema::table('hotels', function( Blueprint $table){
            $table->dropForeign('kamer_id'); 
            $table->dropForeign('service_id'); 
        });                 

    }
}
