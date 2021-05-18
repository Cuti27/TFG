<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use \Illuminate\Support\Facades\DB;
use App\Models\TypeDigitalOutput;

class TypeDigitalOutputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDigitalOutput::create(['type' => 'Sector']);
        TypeDigitalOutput::create(['type' => 'Bomba']);
        TypeDigitalOutput::create(['type' => 'Abono']);
        // DB::table('type_digital_output')->insert([
        //     'type' => 'Sector',
        // ]);

        // DB::table('type_digital_output')->insert([
        //     'type' => 'Bomba',
        // ]);

        // DB::table('type_digital_output')->insert([
        //     'type' => 'Abono',
        // ]);
    }
}
