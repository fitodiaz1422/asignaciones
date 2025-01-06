<?php

namespace App\Http\Excel;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

class UsuariosExcel{

    private $writer;

    private $params;

    private $select;

    private $cabecera;

    public function __construct(array $params){
        $this->params=$params;
        $this->writer = WriterEntityFactory::createXLSXWriter();
    }

    public function download(){
        $this->writer->openToBrowser('Listado de Usuarios.xlsx');
        $this->setHeaders();
        $this->setBody($this->query());
        $this->writer->close();

    }

    private function query(){
        return \App\User::select($this->select)
        ->leftjoin('empresas','empresas.id','=','users.empresa_id')
        ->leftjoin('proyectos','proyectos.id','=','users.proyecto_id')
        ->leftjoin('bancos','bancos.id','=','users.banco_id')
        ->leftjoin('cargos','cargos.id','=','users.cargo_id')
        ->leftJoin('areas','areas.id','=','users.area_id')
        ->leftjoin('comunas','comunas.id','=','users.comuna_id')
        ->leftjoin('afps','afps.id','=','users.afp_id')
        ->leftjoin('tipo_contratos','tipo_contratos.id','=','users.tipo_contrato_id')
        ->leftjoin('tipo_cuentas','tipo_cuentas.id','=','users.tipo_cuenta_id')
        ->leftjoin('previsiones','previsiones.id','=','users.prevision_id')
        ->get();
    }

    private function setHeaders(){
        $arr=datosUsuario();
        foreach ($this->params as $dat) {
            $this->select[]= $arr[$dat][1];
            $this->cabecera[]=$arr[$dat][0];
        }
        $rowFromValues = WriterEntityFactory::createRowFromArray($this->cabecera);
        $this->writer->addRow($rowFromValues);
    }

    private function setBody($query){
        foreach($query as $usuario){
            $rowFromValues = WriterEntityFactory::createRowFromArray($usuario->toArray());
            $this->writer->addRow($rowFromValues);
        }

    }

}
