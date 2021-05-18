<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'type_device',
            'type_analogical_output',
            'type_analogical_input',
            'type_digital_output',
            'type_digital_input',
        ]);


        $this->call(TypeDeviceSeeder::class);
        $this->call(TypeDigitalOutputSeeder::class);
        $this->call(TypeDigitalInputSeeder::class);
        $this->call(TypeAnalogicalInputSeeder::class);
        $this->call(TypeAnalogicalOutputSeeder::class);
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
