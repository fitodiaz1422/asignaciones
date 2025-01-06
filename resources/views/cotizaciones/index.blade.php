@extends('layout')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker.css')}}">
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
            <li class="breadcrumb-item active">Cotizaciones</li>
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
                    <h1>Cotizaciones</h1>
                </div>
                <div class="col-sm-3 col-lg-2">
                    <button onclick="showModal()" class="btn btn-app bg-gradient-success btn-xs">
                        <i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="dateTable1" style="width:100%;cursor:pointer">
              <thead  class="thead-dark">
                  <tr>
                      <th>Numero</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Solicitante</th>
                      <th>Monto</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>Fecha Envio</th>
                      <th>Respuesta</th>
                      <th>JP</th>
                      <th></th>
                  </tr>
                  <tbody>
                      @foreach ($cotizaciones as $cotizacion)
                      <tr ondblclick="editCotizacion('{{$cotizacion->id}}')">
                            <td>{{$cotizacion->id}}</td>
                            <td>{{$cotizacion->cliente->nombre ?? ''}}</td>
                            <td>{{$cotizacion->proyecto}}</td>
                            <td>{{$cotizacion->nombre_solicitante}}</td>
                            <td>{{$cotizacion->formated_monto}}</td>
                            <td>{{$cotizacion->formated_fecha}}</td>
                            <td>{{$cotizacion->nombre_estado}}</td>
                            <td>{{$cotizacion->formated_fecha_envio}}</td>
                            <td>{{$cotizacion->nombre_estado_respuesta}}</td>
                            <td>{{$cotizacion->jp->name ?? ''}}</td>
                            <td>
                                @if ($cotizacion->pdf_cotizacion)
                                    <a href="{{$cotizacion->pdf_cotizacion}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                @endif
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
              </thead>
          </table>
      </div>
    </div>
</section>


<!--modal Create-->
<div class="modal fade" id="modal-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Crear Cotizacion </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('cotizaciones.store')}}" enctype="multipart/form-data" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
					<div class="form-group">
                        <label>Cliente</label>
                        <select class="form-control" name="cliente_id" required>
                            @foreach($clientes as $cliente)
	                    	    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
	                        @endforeach
                        </select>
                  	</div>
                     <div class="form-group">
                        <label>Solicitante</label>
                        <input type="text" class="form-control"  name="nombre_solicitante" maxlength="200" required>
                  	</div>
                    <label>Fecha Entrega</label><br>
					<div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
	                    <input type="text" class="form-control float-right" id="fecha_entrega" name="fecha_entrega" required>
                    </div>
                    <div class="form-group">
                        <label>Proyecto</label>
                        <input type="text" class="form-control"  name="proyecto" maxlength="200">
                  	</div>
                    <div class="form-group">
                        <label>Tipo Actividad</label>
                        <input type="text" class="form-control"  name="tipo_actividad" maxlength="50">
                  	</div>
                      <div class="form-group">
                        <label>Monto</label>
                        <input type="number" class="form-control"  name="monto" min="0" required>
                  	</div>
                    <div class="form-group">
                        <label>Estado Respuesta</label>
                        <select class="form-control" name="estado_respuesta" required>
                            <option value="0">PENDIENTE</option>
                            <option value="1">ADJUDICADO</option>
                            <option value="2">ANULADO</option>
                        </select>
                  	</div>
                    <div class="form-group">
                        <label>Estado Proyecto</label>
                        <select class="form-control" name="estado_proyecto" required>
                            <option value="0">PENDIENTE</option>
                            <option value="1">EN PROCESO</option>
                            <option value="2">FINALIZADO</option>
                        </select>
                  	</div>
                    <div class="form-group">
                        <label>Tipo Facturacion</label>
                        <input type="text" class="form-control"  name="tipo_facturacion" maxlength="100">
                  	</div>
                    <div class="form-group">
                        <label>Pagado</label>
                        <select class="form-control" name="pagado" required>
                            <option value="0">NO PAGADO</option>
                            <option value="1">PAGADO</option>
                        </select>
                  	</div>
					<div class="form-group">
                        <label>JP</label>
                        <select class="form-control"  id="inputUsuario" name="usuario_id" required >
                            @foreach($users as $usuario)
                                <option value="{{$usuario->id}}">{{$usuario->name." ".$usuario->apaterno." ".$usuario->amaterno}}</option>
                            @endforeach
                        </select>
	                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputFile">Subir Cotizacion</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_cotizacion"  id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                              </div>
                            </div>
                          </div>
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

<!--modal Edit-->
<div class="modal fade" id="edit_modal-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Editar Cotizacion <span id="numero_cotizacion"></span></h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('cotizaciones.update')}}" enctype="multipart/form-data" >
			 {{ csrf_field() }}
             @method('put')
	    	<div class="modal-body">
	            <div class="card-body">
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="0">NULO</option>
                            <option value="1">PENDIENTE</option>
                            <option value="2">ENVIADO</option>
                        </select>
                  	</div>
					<div class="form-group">
                        <label>Cliente</label>
                        <select class="form-control" name="cliente_id"  id="cliente_id" required>
                            @foreach($clientes as $cliente)
	                    	    <option value="{{$cliente->id}}" >{{$cliente->nombre}}</option>
	                        @endforeach
                        </select>
                  	</div>
                     <div class="form-group">
                        <label>Solicitante</label>
                        <input type="text" class="form-control"  name="nombre_solicitante"  id="nombre_solicitante" maxlength="200" required>
                  	</div>
                    <label>Fecha Entrega</label><br>
					<div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
	                    <input type="text" class="form-control float-right" id="edit_fecha_entrega" name="fecha_entrega" required>
                    </div>
                    <div class="form-group">
                        <label>Proyecto</label>
                        <input type="text" class="form-control"  name="proyecto" id="proyecto" maxlength="200">
                  	</div>
                    <div class="form-group">
                        <label>Tipo Actividad</label>
                        <input type="text" class="form-control"  name="tipo_actividad" id="tipo_actividad" maxlength="50">
                  	</div>
                      <div class="form-group">
                        <label>Monto</label>
                        <input type="number" class="form-control"  name="monto" id="monto" min="0" required>
                  	</div>
                    <div class="form-group">
                        <label>Estado Respuesta</label>
                        <select class="form-control" name="estado_respuesta"  id="estado_respuesta" required>
                            <option value="0">PENDIENTE</option>
                            <option value="1">ADJUDICADO</option>
                            <option value="2">ANULADO</option>
                        </select>
                  	</div>
                    <div class="form-group">
                        <label>Estado Proyecto</label>
                        <select class="form-control" name="estado_proyecto" id="estado_proyecto" required>
                            <option value="0">PENDIENTE</option>
                            <option value="1">EN PROCESO</option>
                            <option value="2">FINALIZADO</option>
                        </select>
                  	</div>
                    <div class="form-group">
                        <label>Tipo Facturacion</label>
                        <input type="text" class="form-control"  name="tipo_facturacion"  id="tipo_facturacion" maxlength="100">
                  	</div>
                    <div class="form-group">
                        <label>Pagado</label>
                        <select class="form-control" name="pagado"  id="pagado" required>
                            <option value="0">NO PAGADO</option>
                            <option value="1">PAGADO</option>
                        </select>
                  	</div>
					<div class="form-group">
                        <label>JP</label>
                        <select class="form-control"  name="usuario_id" id="usuario_id" required >
                            @foreach($users as $usuario)
                                <option value="{{$usuario->id}}">{{$usuario->name." ".$usuario->apaterno." ".$usuario->amaterno}}</option>
                            @endforeach
                        </select>
	                </div>
                    <input type="hidden" id="cotizacion_id" name="cotizacion_id">
                    <div class="col-sm-12">
                        <div id="pdf_div" class="hidden">
                            <div class="form-group">
                                <label for="exampleInputFile">Subir Cotizacion</label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_cotizacion"  id="edit_pdf_cotizacion">
                                    <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                                </div>
                                </div>
                            </div>
                        </div>

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


@endsection

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/datepicker/datepicker.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#dateTable1').DataTable( {
            "order": [ 0, "asc" ],
            responsive:true,
            "pageLength": 25
        } );
        bsCustomFileInput.init();
        $('#fecha_entrega').datepicker();
    } );

    function showModal() {
	    $('#modal-xl').modal('show')
	}

    function editCotizacion(id) {

        $.ajax({
	        type: 'get',
	        url: '/cotizaciones/ajax/'+id,
	        dataType: 'json',
	        success: function (data) {
                $('#cotizacion_id').val(data.id);
                $('#estado').val(data.estado);
                $('#cliente_id').val(data.cliente_id);
                $('#nombre_solicitante').val(data.nombre_solicitante);
                $('#edit_fecha_entrega').val(data.fecha_entrega);
                $('#proyecto').val(data.proyecto);
                $('#tipo_actividad').val(data.tipo_actividad);
                $('#monto').val(data.monto);
                $('#estado_respuesta').val(data.estado_respuesta);
                $('#estado_proyecto').val(data.estado_proyecto);
                $('#tipo_facturacion').val(data.tipo_facturacion);
                $('#pagado').val(data.pagado);
                $('#usuario_id').val(data.jp_id);
                if(data.pdf_cotizacion){
                    $('#pdf_div').hide();
                }else{
                    $('#pdf_div').show();
                }
                $('#edit_modal-xl').modal('show')
	       },
	        error: function (request, status, error) {
                alert("Error");
	        }
		})

	}
</script>

@endsection
