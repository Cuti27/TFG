<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->foreignId('type')->constrained('type_device');
            $table->foreignId('headId')->constrained('head')->onDelete('cascade');
            $table->foreignId('agronicId')->nullable()->unsigned()->on('agronic_info')->onDelete('cascade');
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
        Schema::dropIfExists('device');
    }
}
