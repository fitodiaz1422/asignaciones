<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
	public $timestamps = false;

	public function Region(){
		return $this->belongsTo(Region::class);
	}
}
