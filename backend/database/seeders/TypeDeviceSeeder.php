<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use \Illuminate\Support\Facades\DB;
use App\Models\TypeDevice;

class TypeDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('type_device')->insert([
        //     'type' => 'ESP32',
        // ]);

        // DB::table('type_device')->insert([
        //     'type' => 'Logo',
        // ]);

        // DB::table('type_device')->insert([
        //     'type' => 'Agronic',
        // ]);

        TypeDevice::create(['type' => 'ESP32']);
        TypeDevice::create(['type' => 'Logo']);
        TypeDevice::create(['type' => 'Agronic']);
    }
}
