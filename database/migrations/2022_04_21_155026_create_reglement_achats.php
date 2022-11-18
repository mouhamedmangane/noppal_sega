<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReglementAchats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('reglement_achats', function (Blueprint $table) {
                $table->id();
                $table->foreign('id')->references('id')->on('ligne_reglements')->onDelete('cascade');

                $table->double(('somme'));
                $table->double(('somme_detail'))->nullable();

                $table->double('poids');
                $table->string('note',255);

                $table->boolean('ouvert')->default(1);

                $table->unsignedBigInteger('fournisseur_id');
                $table->foreign('fournisseur_id')->references('id')->on('contacts')->onDelete('cascade');

                $table->unsignedBigInteger('chauffeur_id');
                $table->foreign('chauffeur_id')->references('id')->on('contacts')->onDelete('cascade');


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
        Schema::dropIfExists('reglement_achats');
    }
}
