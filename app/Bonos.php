<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonos extends Model
{
    protected $table = 'bonos';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
