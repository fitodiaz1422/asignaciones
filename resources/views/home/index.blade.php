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
			<li class="breadcrumb-item active">Inicio</li>
		  </ol>
		</div>
	  </div>
	</div>

        @if(auth()->user()->usuario_cliente == "SI" || auth()->user()->hasRoles('permisos.tecnico'))
        <div class="row clearfix" style="padding:20px 20px 0 20px">
            <div class="col-sm-12 col-lg-12">
            <img src="{{asset('img/logo.png')}}" alt="Logo de empresa">

</div>
</div>

    @else




<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-two-home-tab"  data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Datos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="password-profile" aria-selected="false">Estadisticas</a>
    </li>
</ul>
<form action="{{route('home')}}" method="GET">
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row clearfix" style="padding:20px 20px 0 20px">
                <div class="col-sm-12 col-lg-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                            <input type="hidden" name="tab_active" id="tab_active" value="1">
                            <input type="date" class="form-control" name="fecha" value="{{$fecha}}" onchange="submit()">
                    </div>
                </div>
            </div>
            <div class="row" style="padding:20px 20px 0 20px">

                @php($graf=array())
                @php($i=0)
                @foreach ($totales as $total)

                    @if (auth()->user()->hasRoles('ver_residente_pjud'))
                      @if ($total->proyecto->id == 13)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title">{{$total->proyecto->nombre}}</h3>
                            </div>

                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart{{$i}}" height="161" width="322" class="chartjs-render-monitor" style=""></canvas>
                                </div>

                                </div>

                                <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="far fa-circle text-danger"></i> Usados {{$total->usados}}</li>
                                    <li><i class="far fa-circle text-success"></i> Sin Uso {{($total->total)}}</li>
                                    @php($graf[$i++]=[$total->total,$total->usados])
                                </ul>
                                </div>

                            </div>

                            </div>

                            <div class="card-footer bg-white ">
                                <hr>
                            <ul class="nav nav-pills flex-column">
                                @foreach ($total->users as $user)
                                    <li class="nav-item">
                                        <a  class="nav-link" style="cursor:pointer">
                                            {{$user->nombre}}
                                            <span class="float-right text-danger">
                                            {{$user->count}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            </div>

                        </div>
                    </div>
                     @endif

                     @if ($total->proyecto->id == 12)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title">{{$total->proyecto->nombre}}</h3>
                            </div>

                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart{{$i}}" height="161" width="322" class="chartjs-render-monitor" style=""></canvas>
                                </div>

                                </div>

                                <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="far fa-circle text-danger"></i> Usados {{$total->usados}}</li>
                                    <li><i class="far fa-circle text-success"></i> Sin Uso {{($total->total)}}</li>
                                    @php($graf[$i++]=[$total->total,$total->usados])
                                </ul>
                                </div>

                            </div>

                            </div>

                            <div class="card-footer bg-white ">
                                <hr>
                            <ul class="nav nav-pills flex-column">
                                @foreach ($total->users as $user)
                                    <li class="nav-item">
                                        <a  class="nav-link" style="cursor:pointer">
                                            {{$user->nombre}}
                                            <span class="float-right text-danger">
                                            {{$user->count}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            </div>

                        </div>
                    </div>
                     @endif

                     @else
                     <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title">{{$total->proyecto->nombre}}</h3>
                            </div>

                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart{{$i}}" height="161" width="322" class="chartjs-render-monitor" style=""></canvas>
                                </div>

                                </div>

                                <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="far fa-circle text-danger"></i> Usados {{$total->usados}}</li>
                                    <li><i class="far fa-circle text-success"></i> Sin Uso {{($total->total)}}</li>
                                    @php($graf[$i++]=[$total->total,$total->usados])
                                </ul>
                                </div>

                            </div>

                            </div>

                            <div class="card-footer bg-white ">
                                <hr>
                            <ul class="nav nav-pills flex-column">
                                @foreach ($total->users as $user)
                                    <li class="nav-item">
                                        @if($total->proyecto->by_area)
                                            <a onclick="showTecnicosByArea('{{$total->proyecto->id}}','{{$user->id}}')" class="nav-link" style="cursor:pointer">
                                        @else
                                            <a onclick="showTecnicos('{{$total->proyecto->id}}','{{$user->id}}')" class="nav-link" style="cursor:pointer">
                                        @endif
                                            {{$user->nombre ? $user->nombre : 'SIN AREA'}}
                                            <span class="float-right text-danger">
                                            {{$user->count}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            </div>

                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="tab-pane" id="tab_2">
            <div class="row clearfix" style="padding:20px 20px 0 20px">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                    <input type="date" class="form-control" name="fecha2" value="{{$fecha2}}" onchange="submit()">
                            </div></br></br>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

  </section>


<!--modal-->
<div class="modal fade" id="modal-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Tecnicos Disponibles </h4>
	    </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table  class="table table-bordered table-striped table-hover " style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Rut</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th><span id="nombre_disponible">Comuna</span></th>
                                </tr>
                            </thead>
                            <tbody id="table_tecnicos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	</div>
</div>

@stop
@section('scripts')
	<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script>

    $(document).ready(function() {
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            $('#tab_active').val(e.target.id);
        });

            $('#{{$tab_active}}').tab('show');

    } );

        function showTecnicos(proyecto,region) {
            html="";
            fecha='{{str_replace("/","",str_replace("-","",$fecha))}}';
            $('#table_tecnicos').html("");
            $('#nombre_disponible').html("Comuna");
    	    $.ajax({
	        type: 'GET',
	        url: "/users/ajax/getDisponibles/"+proyecto+"/"+region+"/"+fecha,
	        dataType: 'json',
            success: function (data) {
                $.each(data, function(index, element) {
                    html+="<tr>'";
                    html+='<td>'+element.rut+'</td>'+'<td>'+element.name+'</td>';
                    html+='<td>'+element.apaterno+" "+element.amaterno+'</td>'+'<td>'+element.comuna+'</td>';
                    html+="</tr>";
                    });
                $('#table_tecnicos').html(html);
                $('#modal-xl').modal('show');
                }
		    });
        }
        function showTecnicosByArea(proyecto,area) {
            html="";
            fecha='{{str_replace("/","",str_replace("-","",$fecha))}}';
            $('#table_tecnicos').html("");
            $('#nombre_disponible').html("Area");
    	    $.ajax({
	        type: 'GET',
	        url: "/users/ajax/getByArea/"+proyecto+"/"+fecha+"/"+area,
	        dataType: 'json',
            success: function (data) {
                $.each(data, function(index, element) {
                    html+="<tr>'";
                    html+='<td>'+element.rut+'</td>'+'<td>'+element.name+'</td>';
                    html+='<td>'+element.apaterno+" "+element.amaterno+'</td>'+'<td>'+(element?.area  ?? 'SIN AREA' )+'</td>';
                    html+="</tr>";
                    });
                $('#table_tecnicos').html(html);
                $('#modal-xl').modal('show');
                }
		    });
        }
    </script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            label:false,
            labels: {!!json_encode($total2->pluck('nombre'))!!},
            datasets: [{
                data: {!!json_encode($total2->pluck('cantidad'))!!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>


  @foreach ($graf as $key => $gra)
  <script>
  var pieChartCanvas = $('#pieChart{{$key}}').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Tecnicos Usados',
          'Tecnicos Sin Uso',
      ],
      datasets: [
        {
          data: [{{$gra[1]}},{{$gra[0]}}],
          backgroundColor : ['#f56954', '#00a65a'],
        }
      ]
    }
    var pieOptions     = {
      legend: {
        display: false
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions
    })
	</script>
  @endforeach
  @endif
@stop
