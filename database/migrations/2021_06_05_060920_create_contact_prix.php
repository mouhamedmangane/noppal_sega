<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPrix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_prix', function (Blueprint $table) {
            $table->id();
            $table->double('prix_vente');
            $table->double('prix_achat');
            $table->unsignedBigInteger('bois_produit_id');
            $table->foreign('bois_produit_id')->references('id')->on('bois_produits')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts')
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
        Schema::dropIfExists('contact_prix');
    }
}
