<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAsistencia extends Model
{
	public $timestamps = false;
    protected $table="tipo_asistencias";
    protected $primaryKey="tipo";
}
