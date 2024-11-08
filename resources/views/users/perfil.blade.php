@extends('layout')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection

@section('contenido')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item active">{{$user->name." ".$user->apaterno}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 col-lg-10">
                    <h1>{{$user->name." ".$user->apaterno}}</h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_3" role="tab" aria-controls="password-profile" aria-selected="false">Contraseña</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form action="{{route('users.self_update',$user->id)}}" method="POST" id="formStore" enctype="multipart/form-data">
                            @csrf
                            @method('put')

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
                                    <label>Rut</label>
                                    <input type="text" class="form-control" disabled value="{{($user->rut)}}">
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
                                    <input type="text" class="form-control" maxlength="255" name="amaterno" required value="{{($user->amaterno)}}">
                                </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Fecha Nacimiento</label>
                                        <input type="date" class="form-control"  name="fechaNacimiento" required value="{{($user->fechaNacimiento)}}">
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
                                        <input type="text" class="form-control" maxlength="50" required name="estado_civil" value="{{($user->estado_civil)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Nacionalidad</label>
                                        <input type="text" class="form-control" maxlength="100" required name="nacionalidad" value="{{($user->nacionalidad)}}">
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
                                        <input type="text" class="form-control" maxlength="200" required name="direccion" value="{{($user->direccion)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Fono</label>
                                        <input type="text" class="form-control" maxlength="30" required name="fono" value="{{($user->fono)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Email Personal</label>
                                        <input type="email" class="form-control" maxlength="255" required name="emailPersonal" value="{{($user->emailPersonal)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        <select class="form-control" required name="banco_id">
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
                                        <select class="form-control" required name="tipo_cuenta_id" >
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
                                        <input type="text" class="form-control" required maxlength="100" name="nro_cuenta" value="{{($user->nro_cuenta)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Contacto emergencia</label>
                                        <input type="text" class="form-control" maxlength="255" required name="contacto_nombre" value="{{($user->contacto_nombre)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Fono Contacto emergencia</label>
                                        <input type="text" class="form-control" maxlength="30" required name="contacto_fono" value="{{($user->contacto_fono)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Titulo Profesional</label>
                                        <input type="text" class="form-control" maxlength="100" required name="titulo_profesional" value="{{($user->titulo_profesional)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Institucion de Estudio</label>
                                        <input type="text" class="form-control" maxlength="100" required name="institucion_estudio" value="{{($user->institucion_estudio)}}">
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
                                        <input type="text" class="form-control" disabled value="{{($user->afp->nombre ?? '')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cargas</label>
                                        <input type="number" class="form-control" disabled value="{{($user->cargas)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Salud</label>
                                        <input type="text" class="form-control" disabled value="{{($user->prevision->nombre ?? '')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Pactado Isapre</label>
                                        <input type="text" class="form-control" disabled value="{{($user->tipo_pacto_isapre)}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Monto Pactado</label>
                                        <input type="number" class="form-control" disabled value="{{($user->monto_pactado)}}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Herramientas</h3>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" disabled>
                                        @foreach($herramientas  as $herramienta)
                                        <option value="{{$herramienta->id}}" {{ $user->herramientas->pluck('id')->contains($herramienta->id) ? 'selected' :'' }}>{{$herramienta->nombre}}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <hr>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <form action="{{route('users.update_self_password')}}" method="POST">
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
                                        <label>Contraseña Actual</label>
                                        <input type="password" class="form-control" maxlength="255" name="old_password" required value="">
                                    </div>
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
<script type="text/javascript">

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

    $(document).ready(function() {
        $('#afoto1').click(function(){
            $('#file-input1').click();
        });
    });
</script>

@endsection
