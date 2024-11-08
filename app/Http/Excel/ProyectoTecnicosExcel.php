<?php

namespace App\Http\Excel;

use App\Proyecto;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

class ProyectoTecnicosExcel{

    private $fecha;

    private $proyecto;

    private $writer;

    private $findeMes;

    private $tipos;

    private $tmp_tipos=array();

    public function __construct($fecha,Proyecto $proyecto){
        $this->fecha=$fecha;
        $this->proyecto=$proyecto;
        $this->writer = WriterEntityFactory::createXLSXWriter();
        $findeMes= \DateTime::createFromFormat('Ym',  $this->fecha);
        $this->findeMes=$findeMes->modify('last day of this month')->format('d');
        $this->tipos=\App\TipoAsistencia::all();
    }

    private function query(){
        $proyecto=$this->proyecto->id;
        $total=\App\User_Actividad::selectRaw('users_actividades.user_id ,right(users_actividades.fecha,2) as dia')
        ->join('actividades', function ($join) use ($proyecto){
            $join->on('actividades.id', '=', 'users_actividades.actividad_id')->where('actividades.tipo_asistencia_id',0)
            ->where('actividades.proyecto_id',$proyecto);
        })
        ->whereRaw('left(users_actividades.fecha,6) = '.$this->fecha)
        ->groupBy('users_actividades.user_id','users_actividades.fecha')->with('usuario')
        ->orderby('fecha','asc')->get();
        return ($total);
    }

    private function setDias(){
        for ($i=1; $i <= $this->findeMes ; $i++) {
            $values[]=$i;
        }
        return $values;

    }

    private function setHeaders(){
            $values = ['Rut', 'Nombre', 'Apellidos','Cargo'];
            $values =array_merge($values ,$this->setDias());
            $rowFromValues = WriterEntityFactory::createRowFromArray($values);
            $this->writer->addRow($rowFromValues);
    }


    private function setBody($data){
         $users=$this->getUsers();
            foreach ($users as $user) {
                $cells = [
                    WriterEntityFactory::createCell($user->rut),
                    WriterEntityFactory::createCell($user->name),
                    WriterEntityFactory::createCell($user->apaterno. " " . $user->amaterno),
                    WriterEntityFactory::createCell($user->funcion),
                ];
               for($i=1;$i<=$this->findeMes;$i++){
                    $dia=$data->where('user_id',$user->id)->where('dia',str_pad($i, 2, '0', STR_PAD_LEFT))->first();
                    if($dia){
                        $cells[]=WriterEntityFactory::createCell('X');
                    }else{
                        $cells[]=WriterEntityFactory::createCell('');
                    }
                }
                $row = WriterEntityFactory::createRow($cells);
                $this->writer->addRow($row);
                unset($row_data);
            }
    }

    public function download(){
        $this->writer->openToBrowser('Proyecto Tecnicos '.$this->fecha.'.xlsx');
        $this->setHeaders();
        $this->setBody($this->query());
        $this->writer->close();

    }

    private function getUsers(){
        return \App\User::all();
    }

}
