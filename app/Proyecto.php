<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
	public $timestamps = false;

	public function User(){
		return $this->hasMany(User::class);
	}


	public function Tecnico(){
		$posts = $this->User->get();
    }

    public function Cliente(){
		return $this->belongsTo(Cliente::class);
	}

}
