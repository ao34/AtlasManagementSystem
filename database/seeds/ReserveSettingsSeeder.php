<?php

use Illuminate\Database\Seeder;

class ReserveSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reserve_settings')->insert([
            'setting_reserve' => '2023-1-31',
            'setting_part' => '1',
        ]);
        DB::table('reserve_settings')->insert([
            'setting_reserve' => '2023-1-10',
            'setting_part' => '3',
        ]);
    }
}
