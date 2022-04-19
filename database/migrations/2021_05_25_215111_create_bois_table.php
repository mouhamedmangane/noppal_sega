<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bois', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->unsignedDouble("prix_tronc");
            $table->unsignedDouble("prix_planche");

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
        Schema::dropIfExists('bois');
    }
}
