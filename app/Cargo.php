<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
	public $timestamps = false;

    public function roles(){
        return $this->belongsToMany(Role::Class,'roles_cargos');
    }

    public function notifyroles(){
        return $this->belongsToMany(Notifyrole::class,'notifyroles_cargos');
    }

}
