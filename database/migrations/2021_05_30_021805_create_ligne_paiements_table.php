<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLignePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_paiements', function (Blueprint $table) {
            $table->id();
            $table->double('somme');

            $table->unsignedBigInteger('vente_id');
            $table->foreign('vente_id')->references('id')->on('ventes')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('done_by_user');
            $table->foreign('done_by_user')->references('id')
                        ->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_paiements');
    }
}
