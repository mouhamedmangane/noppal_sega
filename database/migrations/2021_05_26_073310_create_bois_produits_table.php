<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoisProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bois_produits', function (Blueprint $table) {
            $table->id();

            //coummun
            $table->unsignedDouble('longueur')->nullable();
            $table->string('discriminant',50);

            //tronc
            $table->string('identifiant',10)->nullable();
            $table->unsignedDouble('poids')->nullable();
            $table->unsignedDouble('diametre')->nullable();
            $table->unsignedDouble('circonference')->nullable();
            $table->boolean('archived')->default(0);
            $table->dateTime("couper")->nullable();
            $table->dateTime("reserver")->default(0);


            //Planche
            $table->unsignedDouble('largueur')->nullable();
            $table->unsignedDouble('m3')->nullable();
            $table->unsignedDouble('epaisseur_bois_id')->nullable();

            // $table->foreign('epaisseur_bois_id')->references('id')->on('epaisseurs')
            //       ->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('achat_id')->nullable();
            $table->foreign('achat_id')->references("id")->on("achats")->onDelete('cascade');

            $table->unsignedInteger('quantite')->nullable();
            $table->boolean('is_zero')->nullable();





            $table->unsignedBigInteger('bois_id');
            $table->foreign('bois_id')->references('id')
                  ->on('bois')->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('bois_produits');
    }
}
