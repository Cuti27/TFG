<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigitalOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_output', function (Blueprint $table) {
            $table->id();
            $table->string("output");
            $table->foreignId('type')->constrained('type_analogical_output');
            $table->foreignId("deviceId")->constrined("device");
            $table->foreignId("programId")->nullable()->unsigned()->on('programs');
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
        Schema::dropIfExists('digital_output');
    }
}
