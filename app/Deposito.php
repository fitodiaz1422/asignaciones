<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposito extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public function getFechaParaDepositoAttribute($value){
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function Actividad(){
        return $this->belongsTo(Actividad::class);
    }

    public function Usuario(){
		return $this->belongsTo(User::class,'user_id','id');
    }

    public function Archivo(){
      return $this->hasMany(Deposito_Archivo::class);
      }

     public function Rendicion(){
       return $this->Archivo()->where('tipo','RENDICION');//cambiar a get()
     }

     public function Comprobante(){
      return $this->Archivo()->where('tipo','DEPOSITO')->get();
    }

    public function anticipo(){
      return $this->hasOne(Anticipo::class,'deposito_id','id');
    }


}
