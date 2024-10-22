@extends('layout')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link href="{{ asset('plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection

@section('contenido')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Usuario</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <form action="{{route('users.destroy',$user->id)}}" method="POST" id="frmDestroy">
    @csrf
    @method('delete')
  </form>


    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 col-lg-10">
                    <h1>{{$user->name." ".$user->apaterno}}</h1>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <button class="btn btn-app bg-gradient-danger btn-xs" type="button" onclick="frmDestroy.submit()"><i class="fas fa-trash "></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-documentos-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="documentos" aria-selected="false">Documentos Legales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_3" role="tab" aria-controls="password-profile" aria-selected="false">Contraseña</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form action="{{route('users.update',$user->id)}}" method="POST" id="formStore" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="row">
            <div class="col-md-2">
                    <div class="form-group">
                <label for="">Crear Usuario Cliente</label>
                   <input type="checkbox" id="user_cliente" name="user_cliente" onclick="usuarioCliente()" @if($users_clientes_count > 0) checked @endif>
                   </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="div_user" @if($users_clientes_count > 0) @else style="display:none" @endif>
               
                    <div class="col-md-12">
                        <h3>Usuario Cliente</h3>
                    </div>
                    <div class="col-md-2">
                    <div class="form-group">
                   
                        <label>Seleccionar Cliente</label>
                        <select multiple="multiple" id="cliente_user" name="cliente_user[]">
                        @foreach ($clientes as $cliente)
  
						      <option value="{{$cliente->id}}" {{ $users_clientes->firstWhere('clientes_id',$cliente->id) ? 'selected' :'' }} >{{$cliente->razon_social}}</option>
    
					      @endforeach
					    </select>
                        
                    </div>
                    </div>
                  
                </div>
                <hr>

                            <div class="row">
                                <div class="col-md-10">
                                    <h3>Fotografia</h3>
                                    <input name="imagen"  accept="image/*" id="file-input1" type="file" class="fileh" onchange="readURL(this,'#foto1');" style="display: none"/>
                                    <a id="afoto1" href="#"><img id="foto1" width="100px" src="{{Storage::url($user->imagen)}}"></a>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-app bg-gradient-success btn-xs" type="sumbit"><i class="fas fa-save"></i></button>
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
                                    <input type="text" class="form-control" maxlength="30" name="rut" id="rut" onblur="validaRut(this.value);"  required value="{{($user->rut)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" maxlength="255" name="name" required  value="{{($user->name)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control" maxlength="255" name="apaterno" required value="{{($user->apaterno)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control" maxlength="255" name="amaterno"  value="{{($user->amaterno)}}">
                                </div>
                                </div>


                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha Nacimiento</label>
                                    <input type="date" class="form-control"  name="fechaNacimiento" value="{{($user->fechaNacimiento)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control" name="sexo" required>
                                        <option value="M" @if($user->sexo=='M') selected @endif >MASCULINO</option>
                                        <option value="F" @if($user->sexo=='F') selected @endif >FEMENINO</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Estado Civil</label>
                                    <input type="text" class="form-control" maxlength="50"  name="estado_civil" value="{{($user->estado_civil)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" class="form-control" maxlength="100"  name="nacionalidad" value="{{($user->nacionalidad)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Comuna</label>
                                    <select class="form-control" name="comuna_id" required>
                                        <option value="">-- Seleccione --</option>
                                        @foreach($comunas  as $comuna)
                                            <option value="{{$comuna->id}}" @if($user->comuna_id==$comuna->id) selected @endif >{{$comuna->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text" class="form-control" maxlength="200" name="direccion" value="{{($user->direccion)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fono</label>
                                    <input type="text" class="form-control" maxlength="30" name="fono" value="{{($user->fono)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Email Personal</label>
                                    <input type="email" class="form-control" maxlength="255" name="emailPersonal" value="{{($user->emailPersonal)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Banco</label>
                                    <select class="form-control" name="banco_id">
                                        <option value="">-- Seleccione --</option>
                                        @foreach($bancos  as $banco)
                                        <option value="{{$banco->id}}" @if($user->banco_id==$banco->id) selected @endif >{{$banco->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo de Cuenta</label>
                                    <select class="form-control" name="tipo_cuenta_id" >
                                        <option value="">-- Seleccione --</option>
                                        @foreach($tipocuentas  as $tipocuenta)
                                        <option value="{{$tipocuenta->id}}" @if($user->tipo_cuenta_id==$tipocuenta->id) selected @endif >{{$tipocuenta->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cuenta Bancaria</label>
                                    <input type="text" class="form-control"  maxlength="100" name="nro_cuenta" value="{{($user->nro_cuenta)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Contacto emergencia</label>
                                    <input type="text" class="form-control" maxlength="255" name="contacto_nombre" value="{{($user->contacto_nombre)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fono Contacto emergencia</label>
                                    <input type="text" class="form-control" maxlength="30" name="contacto_fono" value="{{($user->contacto_fono)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Titulo Profesional</label>
                                    <input type="text" class="form-control" maxlength="100" name="titulo_profesional" value="{{($user->titulo_profesional)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Institucion de Estudio</label>
                                    <input type="text" class="form-control" maxlength="100" name="institucion_estudio" value="{{($user->institucion_estudio)}}">
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
                                        <select class="form-control" name="empresa_id" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($empresas  as $empresa)
                                            <option value="{{$empresa->id}}" @if($user->empresa_id==$empresa->id) selected @endif >{{$empresa->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Proyecto</label>
                                        <select class="form-control" name="proyecto_id" >
                                            <option value="">-- Seleccione --</option>
                                            @foreach($proyectos  as $proyecto)
                                                <option value="{{$proyecto->id}}" @if($user->proyecto_id==$proyecto->id) selected @endif >{{$proyecto->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cargo</label>
                                        <input type="text" class="form-control" maxlength="50" name="funcion" value="{{($user->funcion)}}">
                                    </div>
                                    </div>

                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha Ingreso</label>
                                    <input type="date" class="form-control" maxlength="10" name="fechaIngreso" value="{{($user->fechaIngreso)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="estado_contrato" required>
                                        <option value="1" @if($user->estado_contrato=='1') selected @endif >ACTIVO</option>
                                        <option value="0" @if($user->estado_contrato=='0') selected @endif >NO ACTIVO</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo de Contrato</label>
                                    <select class="form-control" name="tipo_contrato_id" required>
                                        <option value="">-- Seleccione --</option>
                                        @foreach($tipocontratos  as $tipocontrato)
                                        <option value="{{$tipocontrato->id}}" @if($user->tipo_contrato_id==$tipocontrato->id) selected @endif >{{$tipocontrato->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sueldo</label>
                                    <input type="number" class="form-control" min="0"  name="sueldo_establecido" value="{{($user->sueldo_establecido)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sueldo Base</label>
                                    <input type="number" class="form-control" min="0"  name="sueldo_base" value="{{($user->sueldo_base)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Horas Semanales</label>
                                    <input type="number" class="form-control" min="0" name="horas_semanales" value="{{($user->horas_semanales)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Colacion</label>
                                    <input type="number" class="form-control" min="0" name="colacion" value="{{$user->colacion}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Dias Vacaciones</label>
                                    <input type="number" class="form-control" min="0" name="dias_vacaciones" value="{{$user->dias_vacaciones}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Gratificacion</label>
                                    <input type="text" class="form-control" maxlength="50" name="gratificacion" value="{{($user->gratificacion)}}">
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
                                    <select class="form-control" name="afp_id" >
                                        <option value="">-- Seleccione --</option>
                                        @foreach($afps  as $afp)
                                        <option value="{{$afp->id}}" @if($user->afp_id==$afp->id) selected @endif >{{$afp->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cotizacion Especial</label>
                                    <input type="text" class="form-control" maxlength="50" name="cotizacion_especial" value="{{($user->cotizacion_especial)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tramo Asignado</label>
                                    <input type="text" class="form-control" maxlength="50" name="tramo_asignacion" value="{{($user->tramo_asignacion)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jubilado</label>
                                    <select class="form-control" name="jubilado" >
                                        <option value="0" @if($user->jubilado=='0') selected @endif >NO</option>
                                        <option value="1" @if($user->jubilado=='1') selected @endif >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cargas</label>
                                    <input type="number" class="form-control" min="0"  name="cargas" value="{{($user->cargas)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seguro Cesantia</label>
                                    <select class="form-control" name="seguro_cesantia" >
                                        <option value="0" @if($user->seguro_cesantia=='0') selected @endif >NO</option>
                                        <option value="1" @if($user->seguro_cesantia=='1') selected @endif >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seguro Accidentes</label>
                                    <select class="form-control" name="seguro_accidentes"  >
                                        <option value="0" @if($user->seguro_accidentes=='0') selected @endif >NO</option>
                                        <option value="1" @if($user->seguro_accidentes=='1') selected @endif >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Salud</label>
                                    <select class="form-control" name="prevision_id" >
                                        <option value="">-- Seleccione --</option>
                                        @foreach($previsiones  as $prevision)
                                        <option value="{{$prevision->id}}" @if($user->prevision_id==$prevision->id) selected @endif >{{$prevision->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Pactado Isapre</label>
                                    <input type="text" class="form-control"  maxlength="10" name="tipo_pacto_isapre" value="{{($user->tipo_pacto_isapre)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Monto Pactado</label>
                                    <input type="number" class="form-control"  min="0" step="0.001" name="monto_pactado" value="{{($user->monto_pactado)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Moneda GES</label>
                                    <input type="text" class="form-control"  maxlength="50" name="moneda_ges" value="{{($user->moneda_ges)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Monto GES</label>
                                    <input type="number" class="form-control"  min="0" name="monto_ges" value="{{($user->monto_ges)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Trabajador Joven</label>
                                    <select class="form-control" name="trabajador_joven" >
                                        <option value="0" @if($user->trabajador_joven=='0') selected @endif >NO</option>
                                        <option value="1" @if($user->trabajador_joven=='1') selected @endif >SI</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Habilidades</h3>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" id="select_skills" name="skills[]" multiple="multiple">
                                        @foreach($skills  as $skill)
                                        <option value="{{$skill->id}}" {{ $user->skills->pluck('id')->contains($skill->id) ? 'selected' :'' }}>{{$skill->nombre}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Herramientas</h3>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" id="select_herramientas" name="herramientas[]" multiple="multiple">
                                        @foreach($herramientas  as $herramienta)
                                        <option value="{{$herramienta->id}}" {{ $user->herramientas->pluck('id')->contains($herramienta->id) ? 'selected' :'' }}>{{$herramienta->nombre}}</option>
                                        @endforeach
                                        </select>
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
                                            <select class="form-control" name="cargo_id" onchange="getRolesGroup(this.value)">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($cargos  as $cargo)
                                                <option value="{{$cargo->id}}" @if($user->cargo_id==$cargo->id) selected @endif >{{$cargo->nombre}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @php($anterior="")
                                @php($count=0)
                                @foreach($roles as $role)
                                    @if($role->global_group==$anterior)
                                        <li><input type="checkbox" id="{{$role->id}}" name="roles[]" value="{{$role->id}}"  {{ $user->roles->pluck('id')->contains($role->id) ? 'checked' :'' }} >
                                        <label for="{{$role->id}}">{{$role->description}}</label></li>
                                    @else
                                        @if($anterior!="")
                                                </ul>
                                            </div>
                                        @endif
                                        @if($count==4)
                                            <div class="clearfix"></div>
                                            @php($count=0)
                                        @endif
                                        <div class="col-md-3">
                                            <p><strong>{{$role->global_group}}</strong></p>
                                            <ul class="list-unstyled">
                                                <li><input type="checkbox" id="{{$role->id}}" name="roles[]" value="{{$role->id}}" {{ $user->roles->pluck('id')->contains($role->id) ? 'checked' :'' }} >
                                                <label for="{{$role->id}}">{{$role->description}}</label></li>
                                        @php($anterior=$role->global_group)
                                        @php($count++)
                                    @endif
                                @endforeach
                                            </ul>
                                        </div>


                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Notificaciones</h3>
                                </div>
                                @php($anterior="")
                                @php($count=0)
                                @foreach($notifications as $notification)
                                    @if($notification->global_group==$anterior)
                                        <li><input type="checkbox" id="not-{{$notification->id}}" name="notifications[]" value="{{$notification->id}}"  {{ $user->notifyroles->pluck('id')->contains($notification->id) ? 'checked' :'' }} >
                                        <label for="not-{{$notification->id}}">{{$notification->description}}</label></li>
                                    @else
                                        @if($anterior!="")
                                                </ul>
                                            </div>
                                        @endif
                                        @if($count==4)
                                            <div class="clearfix"></div>
                                            @php($count=0)
                                        @endif
                                        <div class="col-md-3">
                                            <p><strong>{{$notification->global_group}}</strong></p>
                                            <ul class="list-unstyled">
                                                <li><input type="checkbox" id="not-{{$notification->id}}" name="notifications[]" value="{{$notification->id}}" {{ $user->notifyroles->pluck('id')->contains($notification->id) ? 'checked' :'' }} >
                                                <label for="not-{{$notification->id}}">{{$notification->description}}</label></li>
                                        @php($anterior=$notification->global_group)
                                        @php($count++)
                                    @endif
                                @endforeach
                                            </ul>
                                        </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        adasd
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <form action="{{route('users.updatepassword',$user->id)}}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row clearfix">
                                <div class="col-sm-10">
                                    <h3>Cambiar Contraseña</h3>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-app bg-gradient-success btn-xs" type="sumbit"><i class="fas fa-save"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" maxlength="255" name="password" required value="{{(old('password'))}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Repetir Password</label>
                                        <input type="password" class="form-control" maxlength="255" name="reppassword" required >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{ asset('plugins/multi-select/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript">
	function getRolesGroup(value){
		if(value==0){
			var input = $( "#formStore input:checkbox" ).prop('checked',false);
		}else{
             $.ajax({
                type: 'GET',
                url: "/cargos/ajax/get/"+value,
                dataType: 'json',
                success: function (data) {
                var input = $( "#formStore input:checkbox" ).prop('checked',false);
                    $.each(data.roles, function(index, element) {
             		 $( "#"+element.id ).prop('checked',true);
                    });
                    $.each(data.notifyroles, function(index, element) {
             		 $( "#not-"+element.id ).prop('checked',true);
                    });
                }
            });
		}
    }



    function validaRut(val){
        if(val.trim()==""||val=='{{$user->rut}}'){
            return;
        }
        url= '{{route('users.ajax.valida_rut',':q')}}';
        url= url.replace(':q', val);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (data) {
            },
            error: function (request, status, error) {
                errorDialog(request.responseJSON.message);
                $('#rut').val('{{$user->rut}}');
                $('#rut').focus();
            },
        })
    }

    function readURL(input,img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(img).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

function errorDialog(text){
	Swal.fire({
	title: 'Error!',
	text: text,
	icon: 'error',
    });
}

function usuarioCliente(){
    checkBox = document.getElementById('user_cliente');

    if(checkBox.checked) {
        
        $('#div_user').show();
   
}
else{
    $('#div_user').hide();
}
}

    $(document).ready(function() {
        $('#select_skills').select2();
        $('#select_herramientas').select2();
        $('#cliente_user').multiSelect();
        $('#afoto1').click(function(){
            $('#file-input1').click();
        });
    });

</script>

@endsection
