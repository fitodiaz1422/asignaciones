@extends('layout')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('contenido')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Usuarios</a></li>
            <li class="breadcrumb-item active">Ver Usuario</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4 col-lg-6">
                    <h1>{{$user->name." ".$user->apaterno}}</h1>
                </div>
                <div class="col-sm-2 col-lg-2">
                    @if($user->deleted_at)
                        <h1 style="background-color:red; padding:10px;color:#f0f0f0;text-align:center">Eliminado</h1>
                    @endif
                </div>
                <div class="col-sm-3 col-lg-2">
                    @if(auth()->user()->hasRoles('users.destroy'))
                    <form action="{{route('users.reactive',$user->id)}}" method="POST" >
                        @csrf
                        <button type="submit" class="btn btn-app bg-gradient-info btn-xs" ><i class="fas fa-check"></i></button>
                    </form>
                    @endif
                </div>
                <div class="col-sm-3 col-lg-2">
                    <a class="btn btn-app bg-gradient-success btn-xs" href="{{route('users.edit',$user->id)}}"><br><i class="fas fa-edit"></i></a>
                    </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Datos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_3" role="tab" aria-controls="password-profile" aria-selected="false">Documentos</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-10">
                                <h3>Fotografia</h3>
                                <img width="100px" src="{{Storage::url($user->imagen)}}"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Datos</h3>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Correo</label>
                                    <p>{{($user->email)}}</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Rut</label>
                                    <p>{{($user->rut)}}</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Nombres</label>
                                <p>{{($user->name)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <p>{{($user->apaterno)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <p>{{($user->amaterno)}}</p>
                            </div>
                            </div>


                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Fecha Nacimiento</label>
                                <p>{{($user->fechaNacimiento)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Sexo</label>
                                <p>{{($user->sexo)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado Civil</label>
                                <p>{{($user->estado_civil)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Nacionalidad</label>
                                <p>{{($user->nacionalidad)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Comuna</label>
                                <p>{{(($user->Comuna->nombre) ?? '')}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Direccion</label>
                                <p>{{($user->direccion)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Fono</label>
                                <p>{{($user->fono)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Email Personal</label>
                                <p>{{($user->emailPersonal)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Banco</label>
                                <p>{{($user->Banco->nombre) ??''}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipo de Cuenta</label>
                                <p>{{($user->TipoCuenta->nombre)??''}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Cuenta Bancaria</label>
                                <p>{{($user->nro_cuenta)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Contacto emergencia</label>
                                <p>{{($user->contacto_nombre)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Fono Contacto emergencia</label>
                                <p>{{($user->contacto_fono)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Titulo Profesional</label>
                                <p>{{($user->titulo_profesional)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Institucion de Estudio</label>
                                <p>{{($user->institucion_estudio)}}</p>
                            </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Datos Laborales</h3>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Empresa</label>
                                    <p>{{($user->Empresa->nombre)??''}}</p>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Proyecto</label>
                                    <p>{{($user->Proyecto->nombre)??''}}</p>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cargo</label>
                                    <p>{{($user->funcion)}}</p>
                                </div>
                                </div>

                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Fecha Ingreso</label>
                                <p>{{($user->fechaIngreso)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <p>{{($user->estado_contrato) ? 'ACTIVO' : 'NO ACTIVO'}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipo de Contrato</label>
                                    <p>{{($user->TipoContrato->nombre)??''}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Sueldo</label>
                                <p>{{($user->sueldo_establecido)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Sueldo Base</label>
                                <p>{{($user->sueldo_base)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Horas Semanales</label>
                                <p>{{($user->horas_semanales)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Colacion</label>
                                <p>{{$user->colacion}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Dias Vacaciones</label>
                                <p>{{$user->dias_vacaciones}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Gratificacion</label>
                                <p>{{($user->gratificacion)}}</p>
                            </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Datos Previsionales</h3>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>AFP</label>
                                <p>{{($user->Afp->nombre)??''}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Cotizacion Especial</label>
                                <p>{{($user->cotizacion_especial)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Tramo Asignado</label>
                                <p>{{($user->tramo_asignacion)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Jubilado</label>
                                <p>{{($user->jubilado) ? 'SI' : 'NO'}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Cargas</label>
                                <p>{{($user->cargas)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Seguro Cesantia</label>
                                <p>{{($user->seguro_cesantia) ? 'SI' : 'NO'}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Seguro Accidentes</label>
                                <p>{{($user->seguro_accidentes) ? 'SI' : 'NO'}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Salud</label>
                                <p>{{($user->Prevision->nombre)??''}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Pactado Isapre</label>
                                <p>{{($user->tipo_pacto_isapre)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Monto Pactado</label>
                                <p>{{($user->monto_pactado)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Moneda GES</label>
                                <p>{{($user->moneda_ges)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Monto GES</label>
                                <p>{{($user->monto_ges)}}</p>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="form-group">
                                <label>Trabajador Joven</label>
                                <p>{{($user->trabajador_joven) ? 'SI' : 'NO'}}</p>
                            </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h3>Habilidades</h3>
                            </div>
                            <div class="col-md-12">
                                <dvi class="row">
                                    @foreach($user->Skills  as $skill)
                                    <div class="col-md-2">
                                        <p>{{($skill->nombre)}}</p>
                                    </div>
                                    @endforeach
                                </dvi>
                            </div>
                        </div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h3>Herramientas</h3>
                            </div>
                            <div class="col-md-12">
                                <dvi class="row">
                                    @foreach($user->Herramientas  as $herramienta)
                                    <div class="col-md-2">
                                        <p>{{($herramienta->nombre)}}</p>
                                    </div>
                                    @endforeach
                                </dvi>
                            </div>
                        </div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <h3>Permisos</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <p>{{($user->Cargo->nombre)??''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    asdasd
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')


@endsection
