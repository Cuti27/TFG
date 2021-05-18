<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use \Illuminate\Support\Facades\DB;
use \App\Models\TypeAnalogicalOutput;

class TypeAnalogicalOutputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('type_analogical_output')->insert([
        //     'type' => 'Variador de frecuencia',
        // ]);

        TypeAnalogicalOutput::create(['type' => 'Variador de frecuencia']);
    }
}
