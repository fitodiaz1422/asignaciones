@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@stop


@section('contenido')
		<section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
	              <li class="breadcrumb-item active">Asistencias</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>

	<section class="content">
      <div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-sm-9 col-lg-10">
		          <h1 class="card-title">Asistencias</h1>
        		</div>
        		<div class="col-sm-3 col-lg-2">
				<button onclick="showModal()" class="btn btn-app bg-gradient-success btn-xs">
                  <i class="fas fa-plus"></i></button>
                </div>

        	</div>
        </div>


              <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable1" style="width:100%">
				<thead  class="thead-dark">
					<tr>
						<th>Region Usuario</th>
						<th>Proyecto</th>
						<th>Rut</th>
						<th>Nombre</th>
						<th>Tipo</th>
						<th align="center">Desde</th>
						<th align="center">Hasta</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users_tipo as $hora)
					@php($username="")
                        @if($hora->Actividad)
                            @if($hora->Actividad->tipo_asistencia_id>0)
                                <tr>
                                    @php($username=$hora->Usuario->name." ".$hora->Usuario->apaterno." ".$hora->Usuario->amaterno)
                                    <td>{{$hora->Usuario->Comuna->nombre}}</td>
                                    <td>{{($hora->Usuario->Proyecto->nombre)??''}}</td>
                                    <td>{{$hora->Usuario->rut}}</td>
                                    <td>{{$username}}</td>
                                    <td>{{$hora->Actividad->nombre}}</td>
                                    <td>{{DBtoFecha($hora->minf)}}</td>
                                    <td>{{DBtoFecha($hora->maxf)}}</td>
                                </tr>
                            @endif
                        @endif
					@endforeach
				</tbody>
			</table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>


<!--modal-->
<div class="modal fade" id="modal-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Asignar Asistencias: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('asistencia.store')}}" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
					<div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" id="inputCliente" name="tipo" required>
                            @foreach($tipos_asistencias as $tipo_asis)
	                    	    <option value="{{$tipo_asis->tipo}}">{{$tipo_asis->nombre}}</option>
	                        @endforeach
                        </select>
                  	</div>
					<div class="form-group">
	                  <label>Usuario</label>
	                  <select class="form-control"  id="inputUsuario" name="usuario_id" required >
	                  	@foreach($users as $usuario)
	                    	<option value="{{$usuario->id}}">{{$usuario->name." ".$usuario->apaterno." ".$usuario->amaterno}}</option>
	                    @endforeach
	                  </select>
	                </div>
					<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text">
	                        <i class="far fa-calendar-alt"></i>
	                      </span>
	                    </div>
	                    <input type="text" class="form-control float-right" id="reservation" name="fechadatos" required>
	                  </div>
					  <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNota" name="nota" placeholder="" ></textarea>
                      </div>
	            </div>


	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-primary">Guardar</button>
	    </div>
	  </form>

	  </div>

	</div>

</div>


@stop

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">

	function showModal() {
	    $('#modal-xl').modal('show')
	}

$(document).ready(function() {
	$('#inputUsuario').select2();
    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker

    $('#dateTable1').DataTable({
        responsive:true
    });


});


</script>

@stop
