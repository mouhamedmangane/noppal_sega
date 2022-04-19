<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id();
            $table->double('prix_total');
            $table->double('prix_unitaire');
            $table->integer("quantite");
            $table->unsignedBigInteger('bois_produit_id');
            $table->foreign('bois_produit_id')->references('id')->on('bois_produits')
                  ->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('ligne_ventes');
    }
}
