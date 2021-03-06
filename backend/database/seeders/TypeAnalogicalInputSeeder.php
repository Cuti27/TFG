<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use \Illuminate\Support\Facades\DB;
use \App\Models\TypeAnalogicalInput;

class TypeAnalogicalInputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //type_analogical_input
        TypeAnalogicalInput::create(['type' => 'No configurado']);
        TypeAnalogicalInput::create(['type' => 'Humedad']);
        TypeAnalogicalInput::create(['type' => 'pH']);
        TypeAnalogicalInput::create(['type' => 'Conductividad electrica del agua',]);
        TypeAnalogicalInput::create(['type' => 'Temperatura']);
        TypeAnalogicalInput::create(['type' => 'Radiacion solar']);
        TypeAnalogicalInput::create(['type' => 'Humedad relativa']);
        TypeAnalogicalInput::create(['type' => 'Presion']);
        TypeAnalogicalInput::create(['type' => 'Presostato diferencial']);
    }
}
