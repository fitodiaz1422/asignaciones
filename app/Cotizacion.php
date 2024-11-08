<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
	public $timestamps = false;
    public $table= 'cotizaciones';

    protected $appends = ['nombre_estado_respuesta','nombre_estado_proyecto',
    'nombre_pago','nombre_estado','formated_monto','formated_fecha','formated_fecha_envio','FacturaEstado'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function jp(){
        return $this->belongsTo(User::class,'jp_id','id');
    }

    public function getFormatedMontoAttribute(){
        return number_format($this->monto,0,',','.');
    }

    public function getFormatedFechaAttribute(){
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

    public function getFormatedFechaEnvioAttribute(){
        return Carbon::parse($this->fecha_envio)->format('d/m/Y');
    }

    public function getNombreEstadoRespuestaAttribute(){
        switch ($this->estado_respuesta) {
            case '0':
                return "PENDIENTE";
                break;
            case '1':
                return "ADJUDICADO";
                break;
            case '2':
                return "ANULADO";
                break;
            return "ERROR";
                break;
        }
    }

    public function getNombreEstadoProyectoAttribute(){
        switch ($this->estado_proyecto) {
            case '0':
                return "PENDIENTE";
                break;
            case '1':
                return "EN PROCESO";
                break;
            case '2':
                return "FINALIZADO";
                break;
            case '3':
                return "RECURRENTE";
                break;    
            return "ERROR";
                break;

        }
    }

    public function getNombrePagoAttribute(){
        switch ($this->pago) {
            case '0':
                return "NO PAGADO";
                break;
            case '1':
                return "PAGADO";
                break;
            return "ERROR";
                break;
        }
    }

    public function getNombreEstadoAttribute(){
        switch ($this->estado) {
            case '0':
                return "NULO";
                break;
            case '1':
                return "PENDIENTE";
                break;
            case '2':
                return "ENVIADO";
                break;
            return "ERROR";
                break;
        }
    }

    public function getFacturaEstadoAttribute(){
        switch ($this->estado_factura) {
            case '0':
                return "PENDIENTE";
                break;
            case '1':
                return "FACTURADO";
                break;
            return "ERROR";
                break;
        }
    }
}
