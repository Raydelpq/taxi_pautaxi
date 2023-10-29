<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierres', function (Blueprint $table) {
            $table->id();
            $table->date('star');
            $table->date('end');
            $table->double('importe');
            $table->double('ganancia');
            $table->integer('viajes');
            $table->integer('viajes_eliminados');
            $table->foreignId('administrador_id')->references('id')->on('administradors')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        /*Schema::create('cierre_salarios', function (Blueprint $table) {
            $table->id();
            $table->string('model',50);
            $table->foreignId('comercial_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cierre_id')->references('id')->on('cierres')->onUpdate('cascade')->onDelete('cascade');
            $table->float('salario');
            $table->timestamps();
        });

        Schema::create('cierre_gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cierre_id')->references('id')->on('cierres')->onUpdate('cascade')->onDelete('cascade');
            $table->text('name');
            $table->float('valor');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cierres');
    }
};
