<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneReglement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('ligne_reglements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reglement_id');
            $table->foreign('reglement_id')->references('id')
                        ->on('reglements')->onDelete('cascade');

            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')
                        ->on('transactions')->onDelete('cascade');

            $table->string('type',100);

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
        Schema::dropIfExists('ligne_reglement');
    }
}
