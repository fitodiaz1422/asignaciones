@extends('layout')


@section('css')
<link href="{{ asset('plugins/multi-select/css/multi-select.css') }}" rel="stylesheet">
@stop


@section('contenido')
		<section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                  <li class="breadcrumb-item active">Reportes</li>
                  <li class="breadcrumb-item active">Usuarios</li>
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
		          <h1 class="card-title">Usuarios</h1>
        		</div>
        	</div>
        </div>
        <div class="card-body">
            <form action="{{route('reportes.usuarios')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                    </div>
					<div class="col-md-2 ">
                        <button type="submit" class="btn bg-gradient-success">Generar Reporte</button>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<select multiple="multiple" required id="campos" name="campos[]">
                            @foreach ($arr as $key => $ar)
                                    <option value={{$key}} >
                                    {{$ar[0]}}</option>
                                @endforeach
						</select>
					</div>
                </div>
            </form>
        </div>
      </div>
    </section>
@stop

@section('scripts')
<script src="{{ asset('plugins/multi-select/js/jquery.multi-select.js') }}"></script>
<script>
	$(document).ready(function() {
		$('#campos').multiSelect({
		  	selectableHeader: "<div class='custom-header'>Campos Disponibles</div>",
            selectionHeader: "<div class='custom-header'>Campos Seleccionados</div>",
		});
        $('.ms-list').css('height',450);
        $('.ms-container').css('width','100%');
	});
</script>
@stop
