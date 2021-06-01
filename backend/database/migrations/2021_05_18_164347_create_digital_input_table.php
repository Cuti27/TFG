<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDigitalInputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_input', function (Blueprint $table) {
            $table->id();
            $table->string("input");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->foreignId('type')->constrained('type_digital_input');
            $table->string('deviceId');
            $table->foreign('deviceId')->references('id')->on('device');
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
        Schema::dropIfExists('digital_input');
    }
}
