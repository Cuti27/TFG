<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgronicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agronic_info', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->string('deviceId');
            $table->foreign('deviceId')->references('id')->on('device')->onDelete('cascade');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
        Schema::dropIfExists('agronic_info');
    }
}
