<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app.enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('complemento');
            $table->string('cep');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();

            $table->unsignedBigInteger('cidade_id');
            $table->foreign('cidade_id')
                ->references('id')->on('app.cidades');

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
        Schema::dropIfExists('app.enderecos');
    }
}
