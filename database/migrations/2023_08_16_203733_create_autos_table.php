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
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('auto_horario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auto_id')->references('id')->on('autos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('horario_id')->references('id')->on('horarios')->onUpdate('cascade')->onDelete('cascade');
            $table->float('costo');
            $table->float('precio_min');
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
        Schema::dropIfExists('autos');
    }
};
