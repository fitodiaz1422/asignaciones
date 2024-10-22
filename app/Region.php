<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
	public $timestamps = false;
	protected $table="regiones";

	public function Pais(){
		return $this->belongsTo(Pais::class);
	}

}
