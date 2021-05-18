<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use \Illuminate\Support\Facades\DB;
use App\Models\TypeDigitalInput;

class TypeDigitalInputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDigitalInput::create(['type' => 'Pulsador']);
        TypeDigitalInput::create(['type' => 'Sonda de nivel']);
        TypeDigitalInput::create(['type' => 'Presostato']);
        TypeDigitalInput::create(['type' => 'Alarma']);
        TypeDigitalInput::create(['type' => 'Pluviometro']);
        TypeDigitalInput::create(['type' => 'Anemometro']);
        TypeDigitalInput::create(['type' => 'Contador volumetrico']);
        // DB::table('type_digital_input')->insert([
        //     'type' => 'Pulsador',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Sonda de nivel',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Presostato',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Alarma',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Pluviometro',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Anemometro',
        // ]);

        // DB::table('type_digital_input')->insert([
        //     'type' => 'Contador volumetrico',
        // ]);
    }
}
