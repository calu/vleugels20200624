<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlgemeensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('algemeens', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('iban');
        $table->string('bic');
        $table->string('banknaam');
        $table->string('factuur_afzendernaam');
        $table->string('factuur_afzenderstraatennummer');
        $table->string('factuur_afzenderZipenGemeente');
        $table->string('factuur_afzenderTelefoon');
        $table->string('factuur_afzenderEmail');   
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
        Schema::dropIfExists('algemeens');
    }
}
