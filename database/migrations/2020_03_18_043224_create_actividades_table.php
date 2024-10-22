<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100);
            $table->smallInteger('tipo_asistencia_id');
            $table->text('descripcion');
            $table->timestamp('fecha_ini')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->bigInteger('ini_by')->nullable()->unsigned();
            $table->bigInteger('fin_by')->nullable()->unsigned();
            $table->string('archivo',100)->nullable();
            $table->bigInteger('comuna_id')->nullable()->unsigned();
            $table->bigInteger('proyecto_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->unsigned();
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
        Schema::dropIfExists('actividades');
    }
}
