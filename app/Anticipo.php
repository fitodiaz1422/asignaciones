<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anticipo extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'deposito_id',
        'monto',
        'fecha',
        'estado',
        'observaciones'
    ];

    public function deposito()
    {
        return $this->belongsTo(Deposito::class, 'deposito_id', 'id');
    }

    public function getFechaParaAnticipoAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
