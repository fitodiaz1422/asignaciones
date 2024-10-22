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
            <li class="breadcrumb-item"><a href="{{route('cargos.index')}}">Cargos</a></li>
            <li class="breadcrumb-item active">Crear Cargo</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
<form action="{{route('cargos.store')}}" method="POST">
@csrf
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-9 col-lg-10">
                        <h1>Crear Cargo</h1>
                    </div>
                    <div class="col-sm-3 col-lg-2">
                        <button class="btn btn-app bg-gradient-success btn-xs" type="sumbit"><i class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
        		<div class="col-sm-6 col-lg-2">
                    <b>Nombre</b>
        			<div class="input-group">
	        			<input type="text" maxlength="100" class="form-control" name="nombre">
                  	</div>
                </div>
                <br><br>
                <h4>PERMISOS</h4><br>
                <div class="row clearfix">
                    @php($anterior="")
                    @php($count=0)
                    @foreach($roles as $role)
                        @if($role->global_group==$anterior)
                            <li><input type="checkbox" id="{{$role->id}}" name="roles[]" value="{{$role->id}}">

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
                                    <li><input type="checkbox" id="{{$role->id}}" name="roles[]" value="{{$role->id}}" >
                                        <label for="{{$role->id}}">{{$role->description}}</label></li>
                            @php($anterior=$role->global_group)
                            @php($count++)
                        @endif
                    @endforeach
                        </ul>
                    </div>
                </div>
                <hr>
                <h4>NOTIFICACIONES</h4><br>
                <div class="row clearfix">
                    @php($anterior="")
                    @php($count=0)
                    @foreach($notifications as $notification)
                        @if($notification->global_group==$anterior)
                            <li><input type="checkbox" id="not-{{$notification->id}}" name="notifications[]" value="{{$notification->id}}">

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
                                    <li><input type="checkbox" id="not-{{$notification->id}}" name="notifications[]" value="{{$notification->id}}" >
                                        <label for="not-{{$notification->id}}">{{$notification->description}}</label></li>
                            @php($anterior=$notification->global_group)
                            @php($count++)
                        @endif
                    @endforeach
                        </ul>
                    </div>
                </div>
          </div>
        </div>
    </section>
</form>
@endsection

@section('scripts')


@endsection
