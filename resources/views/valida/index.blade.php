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
	              <li class="breadcrumb-item active">Validacion Rendiciones</li>
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
		          <h1 class="card-title">Validacion Rendiciones</h1>
        		</div>


        	</div>
        </div>


              <!-- /.card-header -->
			  <div class="card-body">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#a-validar" role="tab" aria-controls="a-validar-home" aria-selected="true">A VALIDAR</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#pendientes" role="tab" aria-controls="pendientes-profile" aria-selected="false">PENDIENTES</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show active" id="a-validar" role="tabpanel" aria-labelledby="a-validar-tab">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable1" style="width:100%;cursor:pointer">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Region Usuario</th>
                                    <th>Proyecto</th>
                                    <th>Ciudad de Trabajo</th>
                                    <th>Nombre</th>
                                    <th>Actividad</th>
                                    <th>Depositado</th>
                                    <th>Rendido</th>
                                    <th>Adjuntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($saldototal=0)
                                @foreach($depositos as $deposito)
                                @php($username="")
                                <tr  ondblclick="getDeposito('{{$deposito->actividad_id}}',1)" >
                                    @php($username=$deposito->Usuario->name." ".$deposito->Usuario->apaterno." ".$deposito->Usuario->amaterno)
                                    <td>{{($deposito->Usuario->Comuna->nombre)??''}}</td>
                                    <td>{{($deposito->Usuario->Proyecto->nombre)??''}}</td>
                                    <td></td>
                                    <td>{{$username}}</td>
                                <td>{{($deposito->Actividad->nombre)??''}}</td>
                                <td align="center" >{{$deposito->deposito_depositado}}</td>
                                <td>{{$deposito->rendido}}</td>
                                <td>
                                    @foreach ($deposito->Rendicion as $item)
                                    <a  target="_blank" href=" {{($item->archivo)}}"><i class="fas fa-archive"></i></a>
                                    @endforeach
                                 </td>
                                </tr>
                                @php($saldototal+=$deposito->deposito_depositado-$deposito->rendido_real)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pendientes" role="tabpanel" aria-labelledby="pendientes-tab">
						<table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable2" style="width:100%;cursor:pointer">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Region Usuario</th>
                                    <th>Proyecto</th>
                                    <th>Ciudad de Trabajo</th>
                                    <th>Nombre</th>
                                    <th>Actividad</th>
                                    <th>Depositado</th>
									<th>Rendido</th>
									<th>Validado</th>
                                    <th>Adjuntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($saldototal=0)
                                @foreach($pendientes as $deposito)
                                @php($username="")
                                <tr ondblclick="getDeposito('{{$deposito->actividad_id}}',2)" >
                                    @php($username=(($deposito->usuario->name)?? 'Usuario')." ".(($deposito->usuario->apaterno)?? 'Eliminado')." ".(($deposito->usuario->amaterno)??''))
                                    <td>{{($deposito->Usuario->Comuna->nombre)??''}}</td>
                                    <td>{{($deposito->Usuario->Proyecto->nombre)??''}}</td>
                                    <td>{{($deposito->Actividad->Comuna->nombre) ??''}}</td>
                                    <td>{{$username}}</td>
                                <td>{{($deposito->Actividad->nombre)??''}}</td>
                                <td align="center" >{{$deposito->deposito_depositado}}</td>
								<td>{{$deposito->rendido}}</td>
								<td>{{$deposito->rendido_real}}</td>
                                <td>
                                    @foreach ($deposito->Rendicion as $item)
                                    <a  target="_blank" href=" {{($item->archivo)}}"><i class="fas fa-archive"></i></a>
                                    @endforeach
                                 </td>
                                </tr>
                                @php($saldototal+=$deposito->deposito_depositado-$deposito->rendido_real)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>

			</div>
        <!-- /.card-body -->
      </div>
	  <!-- /.card -->

	  <div class="modal fade" id="modal2-xl" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-xl">
		  <div class="modal-content">
			  <form action="{{route('valida.store')}}"  method="POST" enctype="multipart/form-data">
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
											<p><strong>Validacion de la Rendicion</strong></p>
											<input type="number" min="1" class="form-control" id="inputMonto" name="monto" required/>
                                        </div>
                                        <div class="col-sm-12"><br><br>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="aprobado" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1">Marcar como Aprobado?</label>
                                              </div>
                                        </div>
										<div class="col-sm-12"><br><br>
                                            <div class="form-group">
                                                <label>Nota</label>
                                                <textarea class="form-control" rows="6" id="inputNota" name="nota" placeholder="" ></textarea>
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

	function getDeposito(act_id,type) {
	    var token = '{{csrf_token()}}';
	    var data={id:act_id,_token:token};
      $('#mdlNombre').html("");
      $('#actividadIniFin').val("");
      $('#mdlCuerpo').html("");
	    $.ajax({
	        type: 'POST',
	        url: '{{route('asignaciones.get_ajax_actividad')}}',
	        dataType: 'json',
	        data: data,
	        success: function (data) {
            if(type==1){
              $('#inputMonto').prop('readonly',false);
            }else{
              $('#inputMonto').prop('readonly',true);
              $('#inputMonto').val(data.deposito.rendido_real);
            }
            console.log(data.actividad.id);
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
        responsive:true
    });

	$('#dateTable2').DataTable({
        responsive:true
    });
  });

});

</script>

@stop
