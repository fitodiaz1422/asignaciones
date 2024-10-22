<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->string('rut',30)->unique();
            $table->string('name');
            $table->string('apaterno')->nullable();
            $table->string('amaterno')->nullable();
            $table->string('fechaNacimiento',10)->nullable();
            $table->char('sexo')->nullable();
            $table->string('estado_civil',50)->nullable();
            $table->string('nacionalidad',100)->nullable();
            $table->string('direccion',200)->nullable();
            $table->string('fono',30)->nullable();
            $table->string('email')->unique();
            $table->string('emailPersonal')->nullable();
            $table->string('contacto_nombre',255)->nullable();
            $table->string('contacto_fono',30)->nullable();
            $table->string('fechaIngreso',10)->nullable();
            $table->string('fechaTermino',10)->nullable();
            $table->bigInteger('comuna_id')->nullable()->unsigned();
            $table->bigInteger('proyecto_id')->nullable()->unsigned();
            $table->bigInteger('cargo_id')->nullable()->unsigned();
            $table->boolean('estado_contrato')->nullable();
            $table->bigInteger('tipo_contrato_id')->unsigned();
            $table->bigInteger('sueldo_establecido')->nullable();
            $table->smallInteger('horas_semanales')->nullable();
            $table->bigInteger('sueldo_base')->nullable()->unsigned();
            $table->boolean('colacion')->default(0);
            $table->string('gratificacion',50)->nullable();
            $table->bigInteger('afp_id')->nullable()->unsigned();
            $table->string('cotizacion_especial',50)->nullable();
            $table->string('tramo_asignacion',50)->nullable();
            $table->boolean('jubilado')->default(0);
            $table->integer('cargas')->default(0);
            $table->boolean('seguro_cesantia')->default(0);
            $table->boolean('seguro_accidentes')->default(0);
            $table->bigInteger('prevision_id')->nullable()->unsigned();
            $table->string('tipo_pacto_isapre',10)->nullable();
            $table->decimal('monto_pactado',15,3)->nullable();
            $table->string('moneda_ges',50)->nullable();
            $table->smallInteger('monto_ges')->nullable();
            $table->boolean('trabajador_joven')->default(1);
            $table->bigInteger('banco_id')->nullable()->unsigned();
            $table->bigInteger('tipo_cuenta_id')->nullable()->unsigned();
            $table->string('nro_cuenta',100)->nullable();
            $table->string('funcion',255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('imagen')->nullable();
            $table->smallInteger('dias_vacaciones')->nullable();
            $table->string('titulo_profesional',100)->nullable();
            $table->string('institucion_estudio',100)->nullable();
            $table->string('contrato1',255)->nullable();
            $table->string('contrato2',255)->nullable();
            $table->string('contrato3',255)->nullable();
            $table->string('contrato4',255)->nullable();
            $table->string('contrato5',255)->nullable();
            $table->string('contrato6',255)->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
