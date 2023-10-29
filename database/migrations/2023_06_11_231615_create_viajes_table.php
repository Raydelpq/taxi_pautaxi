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
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->String('telegram_message_id',75)->nullable();
            $table->foreignId('colaborador_id')->references('id')->on('colaboracions')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('moneda')->references('id')->on('divisas')->onUpdate('cascade')->onDelete('cascade')->nullable();
            //$table->string('moneda',4);
            $table->float('moneda_valor');
            $table->integer('costo');
            $table->float('fondo_antes');
            $table->float('descuento');
            $table->string('origen');
            $table->string('destino');
            $table->boolean('back')->default(0);
            $table->boolean('aire')->default(0);
            $table->timestamp('fecha')->nullable();;
            $table->integer('pasajeros')->nullable();;
            $table->string('observaciones')->nullable();;
            $table->foreignId('taxista_id')->references('id')->on('taxistas')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('model',50);
            $table->foreignId('comercial_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cliente_id')->references('id')->on('clientes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('viajes');
    }
};
