<?php

namespace App\Http\Excel;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;

class AtrasoExcel{

    private $fecha;

    private $writer;

    private $findeMes;

    private $tipos;

    private $tmp_tipos=array();

    public function __construct($fecha){
        $this->fecha=$fecha;
        $this->writer = WriterEntityFactory::createXLSXWriter();
        $findeMes= \DateTime::createFromFormat('Ym',  $this->fecha);
        $this->findeMes=$findeMes->modify('last day of this month')->format('d');
        $this->tipos=\App\TipoAsistencia::where('estado','=','ACTIVO')->get();
    }

    private function query(){
        $total=DB::table('atrasos')->selectRaw('users.id,actividades.tipo_asistencia_id,right(users_actividades.fecha,2) as dia')
        ->leftJoin('users','users.id','=','users_actividades.user_id')
        ->rightjoin('actividades','actividades.id', '=', 'users_actividades.actividad_id')
        ->whereRaw('left(users_actividades.fecha,6) = '.$this->fecha)
        ->groupby('users_actividades.user_id','users_actividades.fecha','users.id','actividades.tipo_asistencia_id')
        ->orderby('fecha','asc')
        ->get();
        return ($total);
    }

    private function setHeadersTipos(){
        unset($this->tmp_tipos);
        foreach($this->tipos as $tipo){
            $this->tmp_tipos[$tipo->tipo]=0;
        }
    }

    private function setDias(){
        for ($i=1; $i <= $this->findeMes ; $i++) {
            $values[]=$i;
        }
        return $values;

    }

    private function setDescriptions(){

        foreach($this->tipos as $tipo){
            $cells = [
                WriterEntityFactory::createCell('',$this->getColor($tipo->color)),
                WriterEntityFactory::createCell($tipo->nombre),
            ];
            $row = WriterEntityFactory::createRow($cells);
            $this->writer->addRow($row);
        }
    }

    private function setHeaders(){
            $values = ['Rut', 'Nombre', 'Apellidos','Cargo','Proyecto','Region','Minutos Atraso','Fecha','Hora_inicio','Hora_llegada'];
           // $values =array_merge($values ,$this->setDias());
           // $values =array_merge($values ,$this->tipos->pluck('nombre')->toArray());
            $rowFromValues = WriterEntityFactory::createRowFromArray($values);
            $this->writer->addRow($rowFromValues);
    }

    private function getColor($color){
        return (new StyleBuilder())
            ->setBackgroundColor($color)
            ->build();
    }

    private function getAtrasos(){
        return \App\Atraso::select('users.rut', 'users.name', 'users.apaterno', 'users.amaterno', 'users.funcion','proyectos.nombre as py','regiones.nombre as rg','atrasos.diferencia as atraso', 'atrasos.fecha', 'atrasos.hora_inicio', 'atrasos.hora_llegada')
        ->join('users','atrasos.user_id','users.id')
        ->join('proyectos','users.proyecto_id','proyectos.id')
        ->join('comunas','users.comuna_id','comunas.id')
        ->join('regiones','comunas.region_id','regiones.id')->whereRaw('left(atrasos.fecha,6)='.$this->fecha)->get();
    }

    private function getAnticipos(){
        return \App\Anticipo::selectRaw('user_id,sum(monto) as monto')->whereYear('created_at', '=', substr($this->fecha,0,4))
        ->whereMonth('created_at', '=', substr($this->fecha,4,2))->groupby('user_id')->get();
    }

    private function setBody(){
        // $users=$this->getUsers();
         $users=$this->getAtrasos();
         //$anticipos=$this->getAnticipos();
            foreach ($users as $user) {
               // $atraso=$atrasos->where('user_id',$user->id)->first();
                //$anticipo=$anticipos->where('user_id',$user->id)->first();

              

              //  foreach($atraso as $at)
              //  {
                    $cells = [
                        WriterEntityFactory::createCell($user->rut),
                        WriterEntityFactory::createCell($user->name),
                        WriterEntityFactory::createCell($user->apaterno. " " . $user->amaterno),
                        WriterEntityFactory::createCell($user->funcion),
                        WriterEntityFactory::createCell($user->py),
                        WriterEntityFactory::createCell($user->rg),
                        WriterEntityFactory::createCell(($user->atraso)??0),
                        WriterEntityFactory::createCell((($user->fecha)??0)),
                        WriterEntityFactory::createCell((($user->hora_inicio)??0)),
                        WriterEntityFactory::createCell((($user->hora_llegada)??0)),
                    ];

                    $row = WriterEntityFactory::createRow($cells);
                    $this->writer->addRow($row);
                    unset($row_data);

             //   }
               
            }
    }

    public function download(){
        $this->writer->openToBrowser('Atraso '.$this->fecha.'.xlsx');
       // $this->setDescriptions();
        $this->setHeaders();
      //  $this->setBody($this->query());
        $this->setBody();
        $this->writer->close();

    }

    private function getUsers(){
        return \App\User::select('users.*','proyectos.nombre as py','regiones.nombre as rg')
        ->join('proyectos','users.proyecto_id','proyectos.id')
        ->join('comunas','users.comuna_id','comunas.id')
        ->join('regiones','comunas.region_id','regiones.id')
        ->get();
    }

}
