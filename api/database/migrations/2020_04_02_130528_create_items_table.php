<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app.itens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('quantidade');
            $table->unsignedBigInteger('instituicao_id');
            $table->foreign('instituicao_id')
                ->references('id')->on('app.instituicao');
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
        Schema::dropIfExists('app.itens');
    }
}
