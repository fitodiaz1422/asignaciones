@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">


@stop


@section('contenido')
		<section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
	              <li class="breadcrumb-item active">Administracion de Bonos</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>

	<section class="content">
      <div class="card">
        <div class="card-header">
		<form action="{{route('bono.index')}}" method="GET">
        	<div class="row">
        		<div class="col-sm-9 col-lg-10">
		          <h1 class="card-title">Administracion de Bonos</h1>
        		</div>

				<div class="col-sm-12 col-lg-2">
        			<div class="input-group">
						<div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                    </div>
	        				<input type="month" class="form-control" name="fechaasign" value="{{$fecha_c}}" onchange="submit()">
                  	</div>
			</div>
</form>
        		<div class="col-sm-3 col-lg-2">
				<button type="button" onclick="showModal()" class="btn btn-app bg-gradient-success btn-xs">
                  <i class="fas fa-plus"></i></button>
                </div>

        	</div>
        </div>


              <!-- /.card-header -->
        <div class="card-body">
		<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Ingreso</a>
                </li>
				@if (auth()->user()->hasRoles('bono.total'))
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-documentos-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="documentos" aria-selected="false">Total Bonos Asignados</a>
                </li>
				@endif
              </ul>
			  <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <div class="row">
              <div class="col-sm-12 col-lg-12 position-relative">
              
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable1" style="width:100%">
				<thead  class="thead-dark">
					<tr>
						<th>Tecnico</th>
						<th>JP</th>
						<th>Nota</th>
						<th>Monto</th>
						<th>Fecha_Ingreso</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				@php($contador = 0)
					@foreach($bono as $b)
                                <tr>
                                    <td>{{$b->name.' '.$b->apaterno}}</td>
                                    <td>{{$b->name_jp}}</td>
                                    <td>{{$b->nota}}</td>
                                    <td>{{number_format(intval($b->monto),0,',','.')}}</td>
                                    <td>{{$b->created_at}}</td>
                                <td align="center"><input type="hidden" name="datosVALOR[{{$contador}}]" id="datosVALOR{{$contador}}" value="{{$b->nota}}" ><button type="button" class="btn btn-default p-0" onclick="showModal_edit('{{$b->id}}','{{$b->name.' '.$b->apaterno}}','{{$b->fecha}}','{{$contador}}','{{$b->monto}}')">
                                    <i class="fas fa-edit" style="font-size: 24px;"></i>
                                    </button>
                                </td>
                                </tr>
                                @php($contador++)
					@endforeach
				</tbody>
			</table>
			</div>

			@if (auth()->user()->hasRoles('bono.total'))

			<div class="tab-pane" id="tab_2">
			<table id="dateTable2" class="table table-striped table-bordered table-hover table-sm dt-responsive"  style="width:100%">
              <thead  class="thead-dark">
                  <tr>
				  	  <th>Rut</th>
                      <th>Tecnico</th>
                      <th>JP 1</th>
                      <th>JP 2</th>
                      <th>JP 3</th>
                      <th>JP 4</th>
                      <th>JP 5</th>
					  <th>JP 6</th>
					  <th>JP 7</th>
					  <th>JP 8</th>
					  <th>Total</th>
                     
                  </tr>
				</thead>
                  <tbody>
                    @php($usuario = 0)
                    @php($contador = 0)
                    @php($ingreso = 0)
					@php($user_contador = 0)
					@php($monto = 0)
					

                  @foreach ($bono_total as $bt)

				  
                  
                  @if($usuario == $bt->user_id)



                  @if($contador == 0)
                    @php($usuario = $bt->user_id)
					<td>{{$bt->rut }}</td>
                    <td>{{$bt->name .' '. $bt->apaterno . ' '. $bt->amaterno }}</td>
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
					@php($monto = $bt->monto)
                  @endif
                  @if($contador == 1)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
					@php($monto = $monto + $bt->monto)
                  @endif
                  @if($contador == 2)
                    @php($usuario = $bt->user_id)
					<td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
					@php($monto = $monto + $bt->monto)
                  @endif
                  @if($contador == 3)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
    					@php($monto = $monto + $bt->monto)
                  @endif
                  @if($contador == 4)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
                        @php($monto = $monto + $bt->monto)
                  @endif
				  @if($contador == 5)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
                    @php($monto = $monto + $bt->monto)
                  @endif
				  @if($contador == 6)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
                        @php($monto = $monto + $bt->monto)
                  @endif
				  @if($contador == 7)
                    @php($usuario = $bt->user_id)
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt>nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
                        @php($monto = $monto + $bt->monto)
                  @endif
                  @php($contador++)
				 


                  @else

				  @if($contador == 1)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 2)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 3)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				 
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 4)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 5)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 6)
				  <td width="30"></td>
				  <td width="30"></td>
				
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 7)
				  <td width="30"></td>
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  
                  @if($ingreso == 0)
                  <tr>
                  @php($ingreso = 1)
                  @else
                  </tr>
                  <tr>
                  @endif    
                  @php($usuario = $bt->user_id)
                  @php($contador = 1)

				  <td>{{$bt->rut}}</td>
                    <td>{{$bt->name .' '. $bt->apaterno . ' '. $bt->amaterno }}</td>
                    <td width="30">{{$bt->name_jp .'/'. number_format(intval($bt->monto),0,',','.')}}<button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$bt->nota}}','{{$bt->created_at}}')">
                                        <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                    </button></td>
					@php($monto = $bt->monto)

                   

                    @endif
                    
                    
                   

					@php($user_contador++)

					@if($user_contador >= $bono_contador)

					@if($contador == 1)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 2)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 3)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				 
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
                  @if($contador == 4)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 5)
				  <td width="30"></td>
				  <td width="30"></td>
				  <td width="30"></td>
				  
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 6)
				  <td width="30"></td>
				  <td width="30"></td>
				
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif
				  @if($contador == 7)
				  <td width="30"></td>
				  <td width="30">{{number_format(intval($monto),0,',','.')}}</td>
                  @endif



					@endif
                  
                  @endforeach    
                  </tbody>
              
            </table>

			</div>
			@endif

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
	      <h4 class="modal-title">Asignar Bono: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('bono.store')}}" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
				<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
	                  <label>Usuario</label>
	                  <select class="form-control"  id="inputUsuario" name="usuario_id" required >
	                  	@foreach($users as $usuario)
	                    	<option value="{{$usuario->id}}">{{$usuario->name." ".$usuario->apaterno." ".$usuario->amaterno}}</option>
	                    @endforeach
	                  </select>
	                </div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label>Mes del Bono</label>
	                    <input type="month" class="form-control" id="mes_ingreso" name="mes_ingreso"  value="{{$fecha_c}}" required>
	                  </div>
					  </div>
				</div>	  
					  <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNota" name="nota" placeholder="" ></textarea>
                      </div>
					  <div class="col-sm-6">
					  <div class="form-group">
					<label>Total Bono</label>
	                    <input type="number" class="form-control" id="total_ingreso" name="total_ingreso" required>
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

<!--modal editar Bono-->
<div class="modal fade" id="modal-xl_edit" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Editar Bono: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('bono.edit')}}" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
				<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
	                  <label>Usuario</label>
					  <input type="hidden" id="bono_id" name="bono_id" values = "">
					  <input type="text" id="inputUsuario_edit" name="usuario_id" values="" disabled> 
	                </div>
					</div>
					<div class="col-sm-6">
					<div class="form-group">
					<label>Mes del Bono</label>
	                    <input type="month" class="form-control" id="mes_ingreso_edit" name="mes_ingreso"  value="" disabled>
	                  </div>
					  </div>
				</div>	  
					  <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNota_edit" name="nota" placeholder="" ></textarea>
                      </div>
					  <div class="col-sm-6">
					  <div class="form-group">
					<label>Total Bono</label>
	                    <input type="number" class="form-control" id="total_ingreso_edit" name="total_ingreso" value="" required>
	                  </div>
					  </div>
	            </div>


	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-warning">Editar</button>
	    </div>
	  </form>

	  </div>

	</div>
	
</div>

<!-- /.modal-info-tecnico -->
<div class="modal fade" id="modal5-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
    
	  <div class="modal-content">
	    <div class="modal-header">
          <h4 class="modal-title">Informacion Bono: <span id="mdlNombreFalta"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
          </button>

        </div>
        

	    	<div class="modal-body">
	            <div class="card-body">
					  <div class="form-group">
					  <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNota2" name="nota2" disabled></textarea>
                      
                    </br>
                    
                    <label>Fecha de Creacion: <span id="mdlfecha"></span></label>
                    </br>
                    
                       
                      </div>
	            </div>
	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
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

<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>




<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js') }}"></script>


<script type="text/javascript">



	function showModal() {
	    $('#modal-xl').modal('show')
	}

	function showModal_edit($id,$user,$mes,$nota,$monto) {
	    $nota2 =$('#datosVALOR'+$nota).val();
		$('#bono_id').val($id);
		$('#inputUsuario_edit').val($user);

		$fecha_c = $mes.substr(0, 7);

		
		$('#mes_ingreso_edit').val($fecha_c);
		$('#inputNota_edit').val($nota2);
		$('#total_ingreso_edit').val($monto);

	    $('#modal-xl_edit').modal('show')
	}


$(document).ready(function() {
	$('#inputUsuario').select2();
    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker

  

	

});

$('#dateTable2').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            ordering:false,
            paginate:false,
            searching:false,
            info:false,
            buttons: [
				{
      extend: 'excel',
	  title: 'Bonos',
      exportOptions: {
          columns: ':visible',
          format: {
              body: function(data, row, column, node) {
                  data = $('<p>' + data + '</p>').text();
                  return $.isNumeric(data.replace('.', '')) ? data.replace('.', '') : data;
              }
          }
      }
  }
                ],
        });

function showInfoTecnico(bono_nota,$fecha) {
	    //$('#inputNota').html(bono_nota);
		$('#inputNota2').text(bono_nota);
	    
	    $('#mdlfecha').html($fecha);
		
	    $('#modal5-xl').modal('show')
	}


</script>

@stop
