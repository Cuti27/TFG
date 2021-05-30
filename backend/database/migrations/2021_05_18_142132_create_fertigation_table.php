<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fertigation', function (Blueprint $table) {
            $table->id();
            $table->boolean('phPreIrrigation');
            $table->boolean('phIrrigation');
            $table->boolean('phPostIrrigation');
            $table->integer('ph');
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
        Schema::dropIfExists('fertigation');
    }
}
