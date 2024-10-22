@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
@stop


@section('contenido')
		<section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                  <li class="breadcrumb-item active">Reportes</li>
                  <li class="breadcrumb-item active">Asistencia</li>
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
		          <h1 class="card-title">Asistencia</h1>
        		</div>
        	</div>
        </div>
        <div class="card-body">
            <form action="{{route('reportes.asistencia')}}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xs-5">
                        <input type="month" name="fecha" required class="form-control">
                      </div>
                    <div class="col-xs-3">
                        <button type="submit" class="btn bg-gradient-success">Generar Reporte</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>
    </section>
@stop

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
@stop
