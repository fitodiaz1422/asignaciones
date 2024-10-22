<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Actividad extends Model
{
	protected $table="users_actividades";


	public function Usuario(){
		return $this->belongsTo(User::class,'user_id','id')->withTrashed();
	}

	public function Actividad(){
		return $this->belongsTo(Actividad::class);
	}

}
