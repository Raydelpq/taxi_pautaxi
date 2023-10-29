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
        Schema::create('cierre_gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cierre_id')->references('id')->on('cierres')->onUpdate('cascade')->onDelete('cascade');
            $table->text('name');
            $table->float('valor');
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
        Schema::dropIfExists('cierre_gastos');
    }
};
