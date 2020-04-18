<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWijzigstatusToWijzigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wijzigs', function (Blueprint $table) {
            $table->enum('wijzigstratus', ['aangevraagd', 'aanvaard', 'geweigerd']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wijzigs', function (Blueprint $table) {
            $table->dropColumn('wijzigstatus');
        });
    }
}
