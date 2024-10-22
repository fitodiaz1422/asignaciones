<?php

namespace App\Http\Excel;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;

class AsignacionExcel{

    private $fecha;

    private $writer;

    private $findeMes;

    private $tipos;

    private $tmp_tipos=array();

    public function __construct($fecha){
        $this->fecha=$fecha;
        $this->writer = WriterEntityFactory::createXLSXWriter();
        $findeMes= \DateTime::createFromFormat('Ym',  $this->fecha);
       // $this->findeMes=$findeMes->modify('last day of this month')->format('d');
        $this->tipos=\App\TipoAsistencia::where('estado','=','ACTIVO')->get();
    }

    private function query(){
       /* $total=DB::table('users_actividades')->selectRaw('users.id,actividades.tipo_asistencia_id,right(users_actividades.fecha,2) as dia')
        ->leftJoin('users','users.id','=','users_actividades.user_id')
        ->rightjoin('actividades','actividades.id', '=', 'users_actividades.actividad_id')
        ->whereRaw('left(users_actividades.fecha,6) = '.$this->fecha)
        ->groupby('users_actividades.user_id','users_actividades.fecha','users.id','actividades.tipo_asistencia_id')
        ->orderby('fecha','asc')
        ->get();*/

        //$total = 0;
        $total=DB::table('users_actividades')->selectRaw('users.id,actividades.tipo_asistencia_id,right(users_actividades.fecha,2) as dia')
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
            $values = ['Rut', 'Nombre', 'Apellidos','7','8','9','10','11','12','13','14','15','16','17','18','19','20'];
           /* $values =array_merge($values ,$this->setDias());
            $values =array_merge($values ,$this->tipos->pluck('nombre')->toArray());*/
            $rowFromValues = WriterEntityFactory::createRowFromArray($values);
            $this->writer->addRow($rowFromValues);
    }

    private function getColor($color){
        return (new StyleBuilder())
            ->setBackgroundColor($color)
            ->build();
    }

    private function getAtrasos(){
        return \App\Atraso::selectRaw('user_id,sum(diferencia) as atraso')->whereRaw('left(fecha,6)='.$this->fecha)->groupby('user_id')->get();
    }

    private function getAnticipos(){
        return \App\Anticipo::selectRaw('user_id,sum(monto) as monto')->whereYear('created_at', '=', substr($this->fecha,0,4))
        ->whereMonth('created_at', '=', substr($this->fecha,4,2))->groupby('user_id')->get();
    }

    private function setBody($data){
         $users=$this->getUsers();
         //$atrasos=$this->getAtrasos();
         //$anticipos=$this->getAnticipos();
            foreach ($users as $user) {
                //$atraso=$atrasos->where('user_id',$user->id)->first();
                //$anticipo=$anticipos->where('user_id',$user->id)->first();
                $cells = [
                    WriterEntityFactory::createCell($user->rut),
                    WriterEntityFactory::createCell($user->name),
                    WriterEntityFactory::createCell($user->apaterno. " " . $user->amaterno),
                   // WriterEntityFactory::createCell($user->funcion),
                   // WriterEntityFactory::createCell(($atraso->atraso)??0),
                   // WriterEntityFactory::createCell(0+(($anticipo->monto)??0)),
                ];

               // $this->setHeadersTipos();

             /*  for($i=1;$i<=$this->findeMes;$i++){
                    $dia=$data->where('id',$user->id)->where('dia',str_pad($i, 2, '0', STR_PAD_LEFT))->first();
                    if($dia){
                        $tipo=$this->tipos->where('tipo',$dia->tipo_asistencia_id)->first();
                        $cells[]=WriterEntityFactory::createCell('',$this->getColor($tipo->color));
                        $this->tmp_tipos[$tipo->tipo]=$this->tmp_tipos[$tipo->tipo]+1;
                    }else{
                        $cells[]=WriterEntityFactory::createCell('');
                    }
                }
                foreach($this->tmp_tipos as $tmp_tipo){
                    $cells[]=WriterEntityFactory::createCell($tmp_tipo);
                }*/
                //dd($this->tmp_tipos->toArray());
                //$cells =array_merge($cells ,$this->tmp_tipos->toArray());
                $row = WriterEntityFactory::createRow($cells);
                $this->writer->addRow($row);
                unset($row_data);
            }
    }

    public function download(){
        $this->writer->openToBrowser('Asignacion '.$this->fecha.'.xlsx');
       // $this->setDescriptions();
        $this->setHeaders();
        $this->setBody($this->query());
        $this->writer->close();

    }

    private function getUsers(){
        return \App\User::whereIn('proyecto_id',[12,13])->get();
    }

}
