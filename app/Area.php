<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = ['nombre', 'descripcion', 'activo'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
