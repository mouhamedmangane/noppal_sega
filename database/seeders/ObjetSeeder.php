<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ObjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('objets')->insert([
            'nom' => 'vente_bois',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'encaissement',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'contact',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'tronc',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'planche',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'transformation_bois',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'entreprise',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'bois',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'epaisseur planche',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'role',
            'done_by_user' => 1,
        ]);

        DB::table('objets')->insert([
            'nom' => 'user',
            'done_by_user' => 1,
        ]);
    }
}
