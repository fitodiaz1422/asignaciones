@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
	              <li class="breadcrumb-item active">Depositos</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>

	<section class="content">
      <div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-sm-12 col-lg-12">
		          <h1 class="card-title">Depositos</h1>
        		</div>


        	</div>
        </div>


              <!-- /.card-header -->
			  <div class="card-body">
				<table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable1" style="width:100%;cursor:pointer">
					<thead  class="thead-dark">
						<tr>
						    <th>Coordinador</th>
							<th>Region Usuario</th>
							<th>Proyecto</th>
							<th>Ciudad de Trabajo</th>
                            <th data-priority="1">Nombre</th>
                            <th data-priority="2">Fecha para Deposito</th>
                            <th data-priority="3" >Monto</th>
						</tr>
					</thead>
					<tbody>
						@foreach($depositos as $deposito)

						@php($username=(($deposito->usuario->name)?? 'Usuario')." ".(($deposito->usuario->apaterno)?? 'Eliminado')." ".(($deposito->usuario->amaterno)??''))
						<tr ondblclick="getDeposito('{{$deposito->actividad_id}}')" >
                            <td>{{$deposito->coordinacion_name}}</td>
                            <td>{{($deposito->usuario->Comuna->nombre)??''}}</td>
                            <td>{{($deposito->usuario->Proyecto->nombre) ??''}}</td>
                            <td>{{($deposito->Actividad->Comuna->nombre) ??''}}</td>
                            <td>{{$username}}</td>
                            <td>{{$deposito->fecha_para_deposito}}</td>
                            <td align="center" >{{$deposito->deposito_solicitado}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
        <!-- /.card-body -->
      </div>
	  <!-- /.card -->

	  <div class="modal fade" id="modal2-xl" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-xl">
		  <div class="modal-content">
			  <form action="{{route('depositos.store')}}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="modal-header">
			  <h4 class="modal-title">Tarea: <span id="mdlNombre"></span></h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			  </button>
			</div>
				<div class="modal-body">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-6">
								  <span id="mdlCuerpo"></span>
							</div>
							<div class="col-sm-6">

									<div class="row">

										<div class="col-sm-6">
											<p>Monto Depositado</p>
											<input type="number" min="1" class="form-control"  name="monto" required/>
										</div>
										<div class="col-sm-12"><br><br>
											<div class="form-group">
												<label for="exampleInputFile">Subir Comprobante</label>
												<div class="input-group">
												  <div class="custom-file">
													<input type="file" class="custom-file-input" name="archivo" required id="exampleInputFile">
													<label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
												  </div>
												</div>
											  </div>
										</div>
										<input type="hidden" name="actividad_id" id="actividadIniFin"/>
										<div class="col-sm-12">
											<button type="submit" class="btn btn-primary" >Guardar</button>
										</div>
									</div>

							</div>
						</div>

					</div>
			 </div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</form>

		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>



    </section>




@stop

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">

	function getDeposito(act_id) {
	    var token = '{{csrf_token()}}';
	    var data={id:act_id,_token:token};
	    $.ajax({
	        type: 'POST',
	        url: '{{route('asignaciones.get_ajax_actividad')}}',
	        dataType: 'json',
	        data: data,
	        success: function (data) {
	        	$('#mdlNombre').html(data.actividad.nombre);
	    		$('#actividadIniFin').val(data.actividad.id);
	        	$('#mdlCuerpo').html(data.actividad.descripcion.replace(/\n/g, "</br>"));
	        	$('#modal2-xl').modal('show')
	       },
	        error: function (request, status, error) {
	        	$('#mdlNombre').html("");
	    		$('#actividadIniFin').val("");
	        	$('#mdlCuerpo').html("");
	        }
		})

	}

$(document).ready(function() {
  bsCustomFileInput.init();
  $(function () {
    $('#dateTable1').DataTable({
        responsive: true,
        ordering:false,
    });
  });

});

</script>

@stop
