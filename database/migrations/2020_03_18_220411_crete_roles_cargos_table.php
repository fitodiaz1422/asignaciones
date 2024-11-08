<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteRolesCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_cargos', function (Blueprint $table) {
            $table->bigInteger('cargo_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->unique(['cargo_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_cargos');
    }
}
