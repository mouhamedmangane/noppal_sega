<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id'=>1,
            'nom' => 'Administration',
            'description' => 'c est l admin',
            'archiver' => 0,
            'done_by_user' => 1,
        ]);
        DB::table('roles')->insert([
            'id'=>2,
            'nom' => 'Secretaire',
            'description' => 'c est l admin',
            'archiver' => 0,
            'done_by_user' => 1,
        ]);
    }
}
