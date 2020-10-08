<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReteurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reteurns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained();
            $table->timestamps();
        });
        Schema::create('article_reteurns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained();
            $table->foreignId('reteurn_id')->constrained();
            $table->integer('qnt');
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
        Schema::dropIfExists('article_reteurns');
        Schema::dropIfExists('reteurns');
    }
}
