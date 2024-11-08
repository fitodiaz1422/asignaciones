<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('actividad_id')->unsigned();
            $table->bigInteger('deposito_solicitado');
            $table->bigInteger('deposito_depositado')->nullable();
            $table->bigInteger('rendido')->nullable();
            $table->bigInteger('rendido_real')->nullable();
            $table->string('estado')->default('NO RENDIDO');
            $table->boolean('aprobado')->default(0);
            $table->text('notas')->nullable();
            $table->datetime('fecha_para_deposito')->nullable();
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
        Schema::dropIfExists('depositos');
    }
}

