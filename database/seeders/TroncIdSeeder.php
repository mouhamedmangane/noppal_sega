<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class TroncIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range('A', 'Z') as $char1) {
            // foreach (range('A', 'Z') as $char2) {
                foreach (range(0, 9) as $char3) {
                    foreach (range(0, 9) as $char4) {
                        DB::table('tronc_ids')->insert([
                            'id'=>$char1.$char3.$char4,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            // }
        }
    }
}
