<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
       Schema::disableForeignKeyConstraints();
       Schema::create('contacts', function (Blueprint $table) {
           $table->id();
           $table->string('nom', 250);
           $table->string('email', 100)->nullable();
           $table->double('compte', 15, 2)->nullable();
           $table->string('ncni', 50)->nullable();
           $table->string('ncni_photo_1', 50)->nullable();
           $table->string('ncni_photo_2', 50)->nullable();
           $table->string('fonction', 250)->nullable();
           $table->string('photo', 250)->nullable();
           $table->string('adresse', 250)->nullable();




           $table->boolean('is_client')->default(0);
           $table->boolean('is_fournisseur')->default(0);
           $table->boolean('archiver')->default(0);

           $table->unsignedBigInteger('done_by_user')->default(1);//Auth::user()->id) par defaut user connecté
           $table->foreign('done_by_user')
           ->references('id')
           ->on('users')
           ->onDelete('restrict')
           ->onUpdate('restrict');





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
       Schema::dropIfExists('contacts');
   }
}
