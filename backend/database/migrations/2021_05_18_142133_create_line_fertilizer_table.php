<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLineFertilizerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Todo: hacer migrate
        Schema::create('line_fertilizer', function (Blueprint $table) {
            $table->id();
            $table->string('fertilizer');
            $table->string('controlType');
            $table->string('consigna');
            $table->string('time');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $table->foreignId('fertirrigationId')->constrained('fertigation')->onDelete('cascade');
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
        Schema::dropIfExists('line_fertilizer');
    }
}
