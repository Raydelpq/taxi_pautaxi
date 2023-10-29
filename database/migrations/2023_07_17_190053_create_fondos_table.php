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
        Schema::create('fondos', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('taxista_id')->references('id')->on('taxistas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('model',50);
            $table->foreignId('comercial_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type',15);
            $table->integer('saldo');
            $table->integer('fondo');
            $table->integer('activo'); 
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
        Schema::dropIfExists('fondos');
    }
};
