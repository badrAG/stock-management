<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('qnt');
            $table->float('prix');
            $table->string('photo')->default('https://bisg.org/global_graphics/default-store-350x350.jpg');
            $table->string('slug');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('marque_id')->constrained();
            $table->foreignId('modele_id')->constrained();
            $table->foreignId('fournisseur_id')->constrained();
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
        Schema::dropIfExists('articles');
    }
}
