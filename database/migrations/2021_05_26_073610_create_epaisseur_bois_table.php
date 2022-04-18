<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpaisseurBoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epaisseur_bois', function (Blueprint $table) {
            $table->unsignedDouble('id')->primary();
            $table->string('nom',50);
            $table->boolean('archived')->default(0);
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
        Schema::dropIfExists('epaisseur_bois');
    }
}
