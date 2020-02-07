<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSysadminemailToAlgemeens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('algemeens', function (Blueprint $table) {
           $table->string('sysadmin_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('algemeens', function (Blueprint $table) {
            $table->dropColumn('sysadmin_email');
        });
    }
}
