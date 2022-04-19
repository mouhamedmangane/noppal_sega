<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('telephone')->nullable();
            $table->unsignedBigInteger("contact_id")->nullable();
            $table->string('etat');
            $table->string('note',255)->nullable();

            $table->unsignedBigInteger('done_by_user');
            $table->foreign('contact_id')->references('id')
            ->on('contacts')->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('ventes');
    }
}
