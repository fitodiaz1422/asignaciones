@extends('layout')

@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            
        </div>
      </div>
      <div class="card-body">
      <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Pendientes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-documentos-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="documentos" aria-selected="false">Adjudicadas</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-documentos-tab" data-toggle="pill" href="#tab_3" role="tab" aria-controls="documentos" aria-selected="false">Facturadas</a>
                </li>
              </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
          </br>
          <div class="row">
              <div class="col-sm-12 col-lg-12 position-relative">
                <label for="Monto Total">Monto Total</label>
                          <input type="text" id="monto" name="monto" value="{{number_format($mtc,0,',','.')}}" disabled>
              </div>
            </div>
</br>
            <div class="row">
              <div class="col-sm-12 col-lg-12 position-relative">
                          <button onclick="showModal()" class="btn btn-app bg-gradient-success btn-xs float-right">
                          <i class="fas fa-plus"></i></button>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="dateTable1" style="width:100%;cursor:pointer">
              <thead  class="thead-dark">
                  <tr>
                      <th>Numero</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Solicitante</th>
                      <th>Monto</th>
                      <th>Fecha</th>
                      <th>Envio</th>
                      <th>Fecha Envio</th>
                      <th>Propuesta</th>
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
          <div class="tab-pane" id="tab_2">
          </br>
          <div class="row">
              <div class="col-sm-12 col-lg-12 position-relative">
                <label for="Monto Total">Monto Total</label>
                          <input type="text" id="monto" name="monto" value="{{number_format($mta,0,',','.')}}" disabled>
              </div>
            </div>
</br>
          <table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable2" style="width:100%;cursor:pointer">
              <thead  class="thead-dark">
                  <tr>
                      <th>Numero</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Solicitante</th>
                      <th>Monto</th>
                      <th>Fecha</th>
                      <th>Envio</th>
                      <th>Fecha Envio</th>
                      <th>Facturado</th>
                      <th>Estado Proyecto</th>
                      <th>JP</th>
                      <th>Coti</th>
                      <th>N_PO</th>
                      <th>PO</th>
                      <th>N_Factura</th>
                      <th>Factura</th>
                      <th>Archivo 1</th>
                      <th>Archivo 2</th>
                  </tr>
                  </thead>
                  <tbody>
                      @foreach ($adjudicadas as $cotizacion)
                      <tr @if (auth()->user()->hasRoles('cotizaciones.edit')) ondblclick="editCotizacion('{{$cotizacion->id}}')" @endif>
                            <td>{{$cotizacion->id}}</td>
                            <td>{{$cotizacion->cliente->nombre ?? ''}}</td>
                            <td>{{$cotizacion->proyecto}}</td>
                            <td>{{$cotizacion->nombre_solicitante}}</td>
                            <td>{{$cotizacion->formated_monto}}</td>
                            <td>{{$cotizacion->formated_fecha}}</td>
                            <td>{{$cotizacion->nombre_estado}}</td>
                            <td>{{$cotizacion->formated_fecha_envio}}</td>
                            <td>{{$cotizacion->FacturaEstado}}</td>
                            <td>{{$cotizacion->nombre_estado_proyecto}}</td>
                            <td>{{$cotizacion->jp->name ?? ''}}</td>
                            <td>
                                @if ($cotizacion->pdf_cotizacion)
                                    <a href="{{$cotizacion->pdf_cotizacion}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                @endif
                            </td>
                            <td>{{$cotizacion->numero_po}}</td>
                            <td>
                            @if ($cotizacion->pdf_po)
                                    <a href="{{$cotizacion->pdf_po}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  
                                   

                                        <a id="afoto{{ $cotizacion->id}}" onclick="showModalPO({{ $cotizacion->id}},{{ $cotizacion->numero_po}})"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                    @endif    
                                @endif
                            </td>
                            <td>{{$cotizacion->numero_factura}}</td>
                            <td>
                            @if ($cotizacion->pdf_factura)
                                    <a href="{{$cotizacion->pdf_factura}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >
                                        
                            <input  accept="application/pdf" name="file-input-factura{{ $cotizacion->id}}" id="file-input-factura{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'factura');" hidden>
                            <a id="afoto{{ $cotizacion->id}}" onclick="showModalFactura({{ $cotizacion->id}},{{ $cotizacion->numero_factura}})"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                           
                            <td>
                            @if ($cotizacion->pdf_1)
                                    <a href="{{$cotizacion->pdf_1}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div > 
                                       
                            <input  accept="application/pdf" name="file-input-archivo1{{ $cotizacion->id}}" id="file-input-archivo1{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'archivo1');" hidden>
                                        <a id="aArchivo1{{ $cotizacion->id}}" onclick="$('#file-input-archivo1{{ $cotizacion->id}}').click();"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                            <td>
                            @if ($cotizacion->pdf_2)
                                    <a href="{{$cotizacion->pdf_2}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  
                            <input  accept="application/pdf" name="file-input-archivo2{{ $cotizacion->id}}" id="file-input-archivo2{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'archivo2');" hidden>
                                        <a id="aArchivo2{{ $cotizacion->id}}" onclick="$('#file-input-archivo2{{ $cotizacion->id}}').click();"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
            </table>
          </div>







          <div class="tab-pane" id="tab_3">
          </br>
          <div class="row">
              <div class="col-sm-12 col-lg-12 position-relative">
                <label for="Monto Total">Monto Total</label>
                          <input type="text" id="monto" name="monto" value="{{number_format($mtf,0,',','.')}}" disabled>
              </div>
            </div>
</br>
          <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="dateTable3" style="width:100%;cursor:pointer">
              <thead  class="thead-dark">
                  <tr>
                      <th>Numero</th>
                      <th>Cliente</th>
                      <th>Proyecto</th>
                      <th>Solicitante</th>
                      <th>Monto</th>
                      <th>Fecha</th>
                      <th>Envio</th>
                      <th>Fecha Envio</th>
                      <th>Propuesta</th>
                      <th>Facturada</th>
                      <th>JP</th>
                      <th>Coti</th>
                      <th>N_PO</th>
                      <th>PO</th>
                      <th>N_Factura</th>
                      <th>Factura</th>
                      <th>Archivo 1</th>
                      <th>Archivo 2</th>
                  </tr>
                  <tbody>
                      @foreach ($facturadas as $cotizacion)
                      <tr @if (auth()->user()->hasRoles('cotizaciones.edit')) ondblclick="editCotizacion('{{$cotizacion->id}}')" @endif>
                            <td>{{$cotizacion->id}}</td>
                            <td>{{$cotizacion->cliente->nombre ?? ''}}</td>
                            <td>{{$cotizacion->proyecto}}</td>
                            <td>{{$cotizacion->nombre_solicitante}}</td>
                            <td>{{$cotizacion->formated_monto}}</td>
                            <td>{{$cotizacion->formated_fecha}}</td>
                            <td>{{$cotizacion->nombre_estado}}</td>
                            <td>{{$cotizacion->formated_fecha_envio}}</td>
                            <td>{{$cotizacion->nombre_estado_respuesta}}</td>
                            <td>{{$cotizacion->FacturaEstado}}</td>
                            <td>{{$cotizacion->jp->name ?? ''}}</td>
                            <td>
                                @if ($cotizacion->pdf_cotizacion)
                                    <a href="{{$cotizacion->pdf_cotizacion}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                @endif
                            </td>
                            <td>{{$cotizacion->numero_po}}</td>
                            <td>
                            @if ($cotizacion->pdf_po)
                                    <a href="{{$cotizacion->pdf_po}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  

                                        <a id="afoto{{ $cotizacion->id}}" onclick="showModalPO({{ $cotizacion->id}},{{ $cotizacion->numero_po}})"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                            <td>{{$cotizacion->numero_factura}}</td>
                            <td>
                            @if ($cotizacion->pdf_factura)
                                    <a href="{{$cotizacion->pdf_factura}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  
                            <input  accept="application/pdf" name="file-input-factura{{ $cotizacion->id}}" id="file-input-factura{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'factura');" hidden>
                                        <a id="afoto{{ $cotizacion->id}}" onclick="showModalFactura({{ $cotizacion->id}},{{ $cotizacion->numero_factura}})"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                           
                            <td>
                            @if ($cotizacion->pdf_1)
                                    <a href="{{$cotizacion->pdf_1}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  
                            <input  accept="application/pdf" name="file-input-archivo1{{ $cotizacion->id}}" id="file-input-archivo1{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'archivo1');" hidden>
                                        <a id="aArchivo1{{ $cotizacion->id}}" onclick="$('#file-input-archivo1{{ $cotizacion->id}}').click();"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                            <td>
                            @if ($cotizacion->pdf_2)
                                    <a href="{{$cotizacion->pdf_2}}" target="_blank" ><img src="{{asset('img/pdf.png')}}" width="30"/></a>
                                    @else
                                    @if (auth()->user()->hasRoles('cotizaciones.edit'))
                                    <div >  
                            <input  accept="application/pdf" name="file-input-archivo2{{ $cotizacion->id}}" id="file-input-archivo2{{ $cotizacion->id}}" type="file" class="fileh" onchange="readURL(this,{{ $cotizacion->id}},'archivo2');" hidden>
                                        <a id="aArchivo2{{ $cotizacion->id}}" onclick="$('#file-input-archivo2{{ $cotizacion->id}}').click();"><img id="foto{{ $cotizacion->id}}" width="30px" src='{{ asset('img/add.png')}}'></a>
                                        </div>
                                        @endif
                                @endif
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
              </thead>
            </table>
          </div>











        </div>
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
	                    <input type="date" class="form-control float-right" id="fecha_entrega" name="fecha_entrega" value = "{{date('Y-m-d')}}" required>
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
                        <label>Estado Propuesta</label>
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
                            <option value="3">RECURRENTE</option>
                        </select>
                  	</div>
                    <div class="form-group">
                        <label>Tipo Facturacion</label>
                        <input type="text" class="form-control"  name="tipo_facturacion" maxlength="100">
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


<!--modal Adjudicado-->
<div class="modal fade" id="modal-xl2" aria-hidden="true" style="display: none;">
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
	                    <input type="date" class="form-control float-right" id="fecha_entrega" name="fecha_entrega" required>
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
	                    <input type="date" class="form-control float-right" id="edit_fecha_entrega" name="fecha_entrega" required>
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
                        <input type="number" class="form-control"  name="edit_monto" id="edit_monto" min="0" required>
                  	</div>
                    <div class="form-group">
                        <label>Estado Propuesta</label>
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
                            <option value="3">RECURRENTE</option>
                        </select>
                  	</div>

                    <div class="form-group">
                        <label>Estado Facturacion</label>
                        <select class="form-control" name="estado_factura" id="estado_factura" required>
                            <option value="0">PENDIENTE</option>
                            <option value="1">FACTURADO</option>
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
                    <div class="col-sm-12">
                        
                            <div class="form-group">
                                <label for="exampleInputFile">Subir PO</label>
                                <div class="form-group">
                                <label>NUMERO PO</label>
                        <input type="text" id="npo2" name= "npo2" values="">
	                </div>
                  <div id="pdf_po" class="hidden">
                                <div class="input-group">
                                <div class="custom-file">
                                
                                    <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_po"  id="edit_pdf_po">
                                    <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        
                            <div class="form-group">
                                <label for="exampleInputFile">Subir Factura</label>
                                <div class="form-group">
                                <label>NUMERO FACTURA</label>
                        <input type="text" id="nfactura2" name= "nfactura2" values="">
	                </div>
                  <div id="pdf_factura" class="hidden">
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_factura"  id="edit_pdf_factura">
                                    <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <div id="pdf_archivo1" class="hidden">
                            <div class="form-group">
                                <label for="exampleInputFile">Subir Archivo1</label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_archivo1"  id="edit_pdf_archivo1">
                                    <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div id="pdf_archivo2" class="hidden">
                            <div class="form-group">
                                <label for="exampleInputFile">Subir Archivo2</label>
                                <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_archivo2"  id="edit_pdf_archivo2">
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



<!--modal PO-->
<div class="modal fade" id="modal-xlPO" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Subir PO </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('cotizaciones.subirPO')}}" enctype="multipart/form-data" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
                <input type="hidden" id= "cotiId" name = "cotiId" values="">
				
                   					<div class="form-group">
                        <label>NUMERO PO</label>
                        <input type="text" id="npo" name= "npo" values="">
	                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputFile">Subir PO</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_po"  id="exampleInputFile">
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




<!--modal Factura-->
<div class="modal fade" id="modal-xlFactura" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Subir Factura </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('cotizaciones.subirFactura')}}" enctype="multipart/form-data" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
                <input type="hidden" id= "cotiId2" name = "cotiId2" values="">
				
                   					<div class="form-group">
                        <label>NUMERO Factura</label>
                        <input type="text" id="nfactura" name= "nfactura" values="">
	                </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputFile">Subir Factura</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="application/pdf" name="pdf_factura2"  id="exampleInputFileFactura">
                                <label class="custom-file-label" for="exampleInputFileFactura">Seleccione Archivo</label>
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
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js') }}"></script>

<script>
    $(document).ready(function() {
       /* $('#dateTable1').DataTable( {
            "order": [ 0, "asc" ],
            responsive:true,
            "pageLength": 25
        } );
        bsCustomFileInput.init();
        $('#fecha_entrega').datepicker();*/

        $('#dateTable1').DataTable({
          
            dom: 'Blfrtip',
            pageLength: 50,
            responsive: true,
            ordering:true,
            paginate:true,
            searching:true,
            info:false,
            buttons: [
                    'excelHtml5'
                ],
        });
       


    } );


    $(document).ready(function() {
        $('#dateTable2').DataTable({
          "lengthMenu": [ 10, 25, 50, 75, 100 ],
          pageLength: 50,
            dom: 'Blfrtip',
            responsive: true,
            ordering:true,
            paginate:true,
            searching:true,
            info:true,
            buttons: [
                    'excelHtml5'
                ],
        });
    });

    $(document).ready(function() {
        $('#dateTable3').DataTable({
            dom: 'Blfrtip',
            pageLength: 50,
            responsive: true,
            ordering:true,
            paginate:true,
            searching:true,
            info:true,
            buttons: [
                    'excelHtml5'
                ],
        });
    });

    function showModal() {
	    $('#modal-xl').modal('show')
	}

  function showModalPO($id,$numero) {
	    $('#modal-xlPO').modal('show');
      $('#cotiId').val($id);
      $('#npo').val($numero);
	}

  function showModalFactura($id,$numero) {
	    $('#modal-xlFactura').modal('show');
      $('#cotiId2').val($id);
      $('#nfactura').val($numero);
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
                $('#edit_fecha_entrega').val(data.fecha_entrega.substr(0,10));
                $('#proyecto').val(data.proyecto);
                $('#tipo_actividad').val(data.tipo_actividad);
                $('#edit_monto').val(data.monto);
                $('#estado_respuesta').val(data.estado_respuesta);
                $('#estado_proyecto').val(data.estado_proyecto);
                $('#estado_factura').val(data.estado_factura);

                $('#nfactura2').val(data.numero_factura);
                $('#npo2').val(data.numero_po);

                
               
                $('#tipo_facturacion').val(data.tipo_facturacion);
                $('#pagado').val(data.pagado);
                $('#usuario_id').val(data.jp_id);
                if(data.pdf_cotizacion){
                    $('#pdf_div').hide();
                }else{
                    $('#pdf_div').show();
                }
                if(data.pdf_po){
                    $('#pdf_po').hide();
                }else{
                    $('#pdf_po').show();
                }
                if(data.pdf_factura){
                    $('#pdf_factura').hide();
                }else{
                    $('#pdf_factura').show();
                }
                if(data.pdf_1){
                    $('#pdf_archivo1').hide();
                }else{
                    $('#pdf_archivo1').show();
                }
                if(data.pdf_2){
                    $('#pdf_archivo2').hide();
                }else{
                    $('#pdf_archivo2').show();
                }
                $('#edit_modal-xl').modal('show')
	       },
	        error: function (request, status, error) {
                alert("Error");
	        }
		})

	}

  function readURL(input,solicitud,tipo) {

if (input.files && input.files[0]) {

 
     var file = input.files[0];

     
     var data1 = new FormData();
     data1.append('archivo',file);
     data1.append('solicitud',solicitud);
     data1.append('tipo',tipo);
     

     $('.page-loader-wrapper').fadeIn();
     $.ajax({
         url: "/importCotiPDF",
         type:'POST',
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         contentType:false,
         data:data1,
         processData:false,
         cache:false,
         success: function (data,request) {
          location.reload();
           /* successDialog("Archivo Subido Correctamente!");
             var reader = new FileReader();
             reader.onload = function (e) {
             $("#foto"+solicitud).attr('src', "{{ asset('img/add.png')}}");}*/
         },
         error: function (request, status, error) {
             errorDialog(request.responseJSON.message);
         },
         complete: function () {
             $('.page-loader-wrapper').fadeOut();
         }
     });

}
}
</script>

@endsection
