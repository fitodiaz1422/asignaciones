@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                  <li class="breadcrumb-item active">Reportes</li>
                  <li class="breadcrumb-item active">Control Coordinacion</li>
	            </ol>
	          </div>
	        </div>
	      </div>
	    </section>

	<section class="content">
      <div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-sm-9 col-lg-10">
		          <h1 class="card-title">Control Coordinacion</h1>
        		</div>
        	</div>
        </div>
        <div class="card-body">
            <form action="{{route('reportes.control_coordinacion')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xs-5">
                        <input type="date" name="fechaini" value="{{(old('fechaini'))}}" required class="form-control">
                      </div>
                      <div class="col-xs-5">
                        <input type="date" name="fechafin" value="{{(old('fechafin'))}}" required class="form-control">
                      </div>
                    <div class="col-xs-3">
                        <button type="submit" class="btn bg-gradient-success">Generar Reporte</button>
                    </div>
                  </div>
                  @if(isset($collection))
                  <br><hr>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover table-sm dt-responsive" id="dateTable1" style="width:100%;cursor:pointer">
                                <thead  class="thead-dark">
                                    <tr>
                                        <th>Coordinador</th>
                                        <th>Actividades</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collection as $c)
                                        <tr>
                                            <td>{{($c->nombre)}}</td>
                                            <td>{{($c->actividades)}}</td>
                                            <td>{{($c->ini)}}</td>
                                            <td>{{($c->fin)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                    </div>
                  @endif
            </form>
        </div>
      </div>
    </section>
@stop

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
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
        $('#dateTable1').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            ordering:false,
            paginate:false,
            searching:false,
            info:false,
            buttons: [
                    'excelHtml5'
                ],
        });
    });
</script>
@stop
