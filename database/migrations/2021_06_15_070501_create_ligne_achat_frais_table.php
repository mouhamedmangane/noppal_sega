<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneAchatFraisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_achat_frais', function (Blueprint $table) {
            $table->id();
            $table->string('descciption',100);
            $table->double(('somme'));

            $table->unsignedBigInteger('achat_id');
            $table->foreign('achat_id')->references('id')->on('achats')->onDelete('cascade');

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
        Schema::dropIfExists('ligne_achat_frais');
    }
}
