<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entreprises')->insert([
            "id"=>1,
            "nom"=>"SEga",
            "logo"=>"/1.png",
            "tel_1"=>"33 546 76 76",
            "tel_2"=>"77 65 786 87",
            "ninea"=>"1236546-543",
            "created_at"=>now(),
            'updated_at'=>now()
        ]);
    }
}
