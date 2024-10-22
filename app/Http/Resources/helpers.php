<?php

function activeMenu($route){
	return request()->is($route) ? 'active' : '';
}

function getColor($id){
	if($id==-1){
		return "bg-danger";
	}
	if($id>0){
		return "bg-primary";
	}
	return "bg-warning";
}

function getNotifiColor($type){
    switch($type) {
      case 'OK':
            return "callout callout-success";
        break;
      case 'Alert':
            return "callout callout-warning";
        break;
      case 'Error':
            return "callout callout-danger";
        break;
      default:
            return "callout callout-info";
        break;
    }
}

	function DBtoFecha($fecha,$separator="/",$name=false){
		$year=substr($fecha, 0,4);
		$month=substr($fecha, 4,2);
		$day=substr($fecha, 6,2);


		if ($name){
			return monthName($month)." ".$year;
		}
		if($day){
			return $day.$separator.$month.$separator.$year;
		}else{
			return $month.$separator.$year;
		}

    }

    function FechatoDB($fecha){
        $year=substr($fecha, 6,4);
        $month=substr($fecha, 3,2);
        $day=substr($fecha, 0,2);
        return $year.$month.$day;
      }



	function monthName($month){
		switch ($month) {
			case 1:
				return "Enero";
				break;
			case 2:
				return "Febrero";
				break;
			case 3:
				return "Marzo";
				break;
			case 4:
				return "Abril";
				break;
			case 5:
				return "Mayo";
				break;
			case 6:
				return "Junio";
				break;
			case 7:
				return "Julio";
				break;
			case 8:
				return "Agosto";
				break;
			case 9:
				return "Septiembre";
				break;
			case 10:
				return "Octubre";
				break;
			case 11:
				return "Noviembre";
				break;
			case 12:
				return "Diciembre";
				break;
			default:
				return "Error";
				break;
		}
	}

	function generateLink($role,$route,$params=[]){
		if(auth()->user()->hasRoles($role)){
		  $dblclick="ondblclick=window.location.href='".route($route,$params)."' ";
		  $touch="ontouchend=window.location.href='".route($route,$params)."' ";
		  return $dblclick.$touch;
		}
		return "";
      }

      function datosUsuario(){
        $arr =array(
            0=>['Empresa','empresas.nombre as empresa'],
            1=>['Rut','users.rut'],
            2=>['Nombres','users.name'],
            3=>['Apellido Paterno','users.apaterno'],
            4=>['Apellido Materno','users.amaterno'],
            5=>['Fecha Naciemiento','users.fechaNacimiento'],
            6=>['Sexo','users.sexo'],
            7=>['Estado Civil','users.estado_civil'],
            8=>['Nacionalidad','users.nacionalidad'],
            9=>['Direccion','users.direccion'],
            10=>['Telefono','users.fono'],
            11=>['Email','users.email'],
            12=>['Email Personal','users.emailPersonal'],
            13=>['Nombre Contacto','users.contacto_nombre'],
            14=>['Telefono Contacto','users.contacto_fono'],
            15=>['Fecha Ingreso','users.fechaIngreso'],
            16=>['Fecha Termino Contrato','users.fechaTermino'],
            17=>['Comuna','comunas.nombre as comuna'],
            18=>['Proyecto','proyectos.nombre as proyecto'],
            19=>['Cargo','cargos.nombre as cargo'],
            20=>['Estado','users.estado_contrato'],
            21=>['Tipo Contrato','tipo_contratos.nombre as tipocontrato'],
            22=>['Sueldo','users.sueldo_establecido'],
            23=>['Horas Semanales','users.horas_semanales'],
            24=>['Sueldo Base','users.sueldo_base'],
            25=>['Colacion','users.colacion'],
            26=>['Gratificacion','users.gratificacion'],
            27=>['AFP','afps.nombre as afp'],
            28=>['Cotizacion especial','users.cotizacion_especial'],
            29=>['Tramo asignacion','users.tramo_asignacion'],
            30=>['Jubilado','users.jubilado'],
            31=>['Cargas','users.cargas'],
            32=>['Seguro Cesantia','users.seguro_cesantia'],
            33=>['Seguro Accidentes','users.seguro_accidentes'],
            34=>['Salud','previsiones.nombre as prevision'],
            35=>['Pacto Salud','users.tipo_pacto_isapre'],
            36=>['Monto Salud','users.monto_pactado'],
            37=>['Moneda GES','users.moneda_ges'],
            38=>['Monto GES','users.monto_ges'],
            39=>['Trabajador Joven','users.trabajador_joven'],
            40=>['Banco','bancos.nombre as bancos'],
            41=>['Tipo Cuenta','tipo_cuentas.nombre as tipocuenta'],
            42=>['Nro. Cuenta','users.nro_cuenta'],
            43=>['Funcion','users.funcion'],
            44=>['Dias Vacaciones','users.dias_vacaciones'],
            45=>['Titulo Profesional','users.titulo_profesional'],
            46=>['Institucion estudio','users.institucion_estudio'],
            47=>['Contrato 1','users.contrato1'],
            48=>['Contrato 2','users.contrato2'],
            49=>['Contrato 3','users.contrato3'],
            50=>['Contrato 4','users.contrato4'],
            51=>['Contrato 5','users.contrato5'],
            52=>['Contrato 6','users.contrato6'],
        );
        return $arr;
    }

    function count_inasistencia($id, $mes, $anio){

      $contar_Inasistencia = DB::table('actividades')
      ->Join('users_actividades', function($join)
      {
          $join->on('actividades.id','=','users_actividades.actividad_id')
               ->where('users_actividades.hora','=',7);
      })
      ->Join('users','users.id','=','actividades.user_id')
    ->where('actividades.tipo_asistencia_id','=','-1')
    ->where('users.id','=',$id)
    ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
    ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
    ->count();

    return $contar_Inasistencia;

   

    }
