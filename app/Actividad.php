<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model
{
	protected $table="actividades";
    use SoftDeletes;

    public function Comuna(){
        return $this->belongsTo(Comuna::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Deposito(){
        return $this->hasOne('App\Deposito');
    }

    public function TipoAsistencia(){
        return $this->belongsTo(TipoAsistencia::class,'tipo_asistencia_id','tipo');
    }

}
