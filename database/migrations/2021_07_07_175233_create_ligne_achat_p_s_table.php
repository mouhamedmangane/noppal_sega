<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneAchatPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_achat_p_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("depense_id");
            $table->foreign('depense_id')->references('id')->on('depenses')->onDelete('cascade');

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
        Schema::dropIfExists('ligne_achat_p_s');
    }
}
