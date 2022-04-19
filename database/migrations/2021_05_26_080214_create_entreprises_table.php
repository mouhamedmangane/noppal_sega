<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom',100);
            $table->string('nom_2',100)->nullable();
            $table->string('logo',255)->nullable();
            $table->string('tel_1',255)->nullable();
            $table->string('tel_2',255)->nullable();
            $table->string('tel_3',255)->nullable();
            $table->string('ninea',50)->nullable();

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
        Schema::dropIfExists('entreprises');
    }
}
