<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Deposito extends Model
{
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


}
