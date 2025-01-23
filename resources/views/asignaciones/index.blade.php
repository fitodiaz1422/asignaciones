@extends('layout')


@section('css')
<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
@stop


@section('contenido')
		<section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
	              <li class="breadcrumb-item active">Asignaciones</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>

	<section class="content">
      <div class="card">
        <div class="card-header">
			<form action="{{route('asignaciones.index')}}" method="GET">
        	<div class="row">
        		<div class="col-sm-6 col-lg-3">
		          <h1 class="card-title">Asignaciones</h1>
				</div>
				<div class="col-sm-6 col-lg-2">
                    @if(!auth()->user()->hasRoles('permisos.coordinador'))
                    <label>Proyecto</label>
					<div class="form-group">
	                  <select class="form-control select2"  id="select_proyecto_filter" name="filter_proyecto_id" onchange="submit()">
                        <option value=""> -- Todos --</option>
    	                  	@foreach($proyectos as $proyecto)
    	                    	<option value="{{$proyecto->id}}" @if($filter_proyecto_id==$proyecto->id) selected @endif>{{$proyecto->nombre}}</option>
    	                    @endforeach
	                  </select>
	                </div>
	                @endif
				</div>
				<div class="col-sm-6 col-lg-2">
                      <label>Region</label>
					<div class="form-group">
	                  <select class="form-control select2"  id="select_region_filter" name="filter_region_id" onchange="submit()">
                        <option value=""> -- Todos --</option>
    	                  	@foreach($regiones as $region)
    	                    	<option value="{{$region->id}}" @if($filter_region_id==$region->id) selected @endif>{{$region->nombre}}</option>
    	                    @endforeach
	                  </select>
	                </div>
				</div>
				<div class="col-sm-6 col-lg-2">
                    <label>Tecnicos Asignados</label>
					<div class="form-group">
	                  <select class="form-control select2"  id="select_filter_sin_asignar" name="filter_sin_asignar" onchange="submit()">
                        <option value="-1" @if($filter_sin_asignar==-1) selected @endif> -- Todos --</option>
    	                <option value="1" @if($filter_sin_asignar==1) selected @endif>Sin Asignacion</option>
    	                <option value="0" @if($filter_sin_asignar==0) selected @endif>Con Asignacion</option>
	                  </select>
	                </div>
				</div>
        		<div class="col-sm-6 col-lg-2">
                    <label>Fecha</label>
        			<div class="input-group">
						<div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                    </div>
	        				<input type="date" class="form-control" name="fechaasign" value="{{$date}}" onchange="submit()">
                  	</div>
				</div>
				@if (auth()->user()->hasRoles('asignaciones.masiva'))
				<div class="col-sm-3 col-lg-1">
				<button type="button" onclick="showModal_masiva()" class="btn btn-app bg-gradient-success btn-xs">
                  <i class="fas fa-plus"></i></button>
                </div>
				@endif
			</div>
			</form>
        </div>
              <!-- /.card-header -->
        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-home-tab"  data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Empresa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="password-profile" aria-selected="false">Red de Servicio</a>
            </li>
        </ul>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
        			<table class="table table-striped table-bordered table-hover compact table-sm " id="dateTable1" style="width:100%">
        				<thead  class="thead-dark">
        					<tr>
        					    <th>Region</th>
        						<th>Comuna</th>
        						<th>Proyecto</th>
        						<th>Grupo</th>
        						<th>Ciudad de Trabajo</th>
        						<th>Coordinador</th>
        						<th>Nombre</th>
                                <th align="center">7:00</th>
                                <th align="center">8:00</th>
        						<th align="center">9:00</th>
        						<th align="center">10:00</th>
        						<th align="center">11:00</th>
        						<th align="center">12:00</th>
        						<th align="center">13:00</th>
        						<th align="center">14:00</th>
        						<th align="center">15:00</th>
        						<th align="center">16:00</th>
        						<th align="center">17:00</th>
        						<th align="center">18:00</th>
        						<th align="center">19:00</th>
        						<th></th>
                                <th></th>
                                <th></th>
        					</tr>
        				</thead>
        				<tbody>
        				@if (auth()->user()->hasRoles('solo_lectura_asignacion_residente_pjud'))
        					@foreach($users->where('proyecto_id','<>',14) as $user)
        					@if($user->proyecto->id == 13)

        							@php($username="")
        							@php($coordinador1="")
        							@php($coordinador2="")
        							@php($coordinador3="")
        							<tr>
        								@php($username=$user->name." ".$user->apaterno." ".$user->amaterno)
        								@php($username =$username."/")
        								<td>{{($user->Comuna->Region->codigo) ?? ''}}</td>
        								<td>{{($user->Comuna->nombre) ?? ''}}</td>

        								<td>{{($user->Proyecto->nombre) ?? ''}}</td>
        								<td>{{($user->cargo->nombre) ?? ''}}</td>

        								@php($horacount=7)
        								@php($arr=[-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-3])
        								@php($arr2=["","","","","","","","","","","","","",""])
        								@php($arr3=["","","","","","","","","","","","","",""])
        								@php($arr4=["","","","","","","","","","","","","",""])
        								@php($arr5=["","","","","","","","","","","","","",""])
        								@php($arr6=["","","","","","","","","","","","","",""])
        								@php($lugar_trabajo="")
        								@foreach($user->HorasDia(str_replace("-", "", $date) ) as $hora)
        									@php($contador=$hora->hora-$horacount)
        									@php($arr[$contador]=$hora->actividad_id)
        									@php($arr2[$contador]=$hora->Actividad->nombre)
        									@php($arr3[$contador]=$hora->Actividad->tipo_asistencia_id)
        									@php($arr4[$contador]=($hora->Actividad->fecha_ini) ?? null)
        									@php($arr5[$contador]=($hora->Actividad->fecha_ini && $hora->Actividad->fecha_fin) ? 'bg-success' : getColor($hora->Actividad->tipo_asistencia_id))
        									@php($arr6[$contador]=($hora->Actividad->archivo) ?? null)
        									@php($lugar_trabajo=($hora->Actividad->Comuna->nombre) ?? '')
        									@php($coordinador2=($hora->Actividad->coordinacion_name) ?? '')
        									@if($coordinador3==$coordinador2)
        									@else
        									@php($coordinador3=$coordinador2)
        									@php($coordinador1 = $coordinador1 . "/" . $coordinador2)
        									@endif

        								@endforeach
        								<td>{{$lugar_trabajo}}</td>

        								<td>{{$coordinador1}}</td>
        								<td>{{$username}} <button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-book-reader" style="font-size: 24px;"></i>
        											</button></td>
        									@php($colspan=-1)
        									@php($anterior=$arr[0])
        									@php($cant=0)
        									@foreach($arr as $key => $valor)
        										@php($colspan++)
        										@if($anterior!=$valor)
        											@if($anterior==-2)
        											<td  colspan="{{$colspan}}"></td>
        											@php($cant++)
        											@else
        											<td align="center" style="cursor:pointer" onclick="getTarea('{{$anterior}}')" class="{{$arr5[$key-1]}} color-palette border border-light" colspan="{{$colspan}}">{{$arr2[$key-1]}}
        												@if($arr4[$key-1])
        												<i class="fas fa-check" style="font-size: 12px;"></i>
        												@endif
        												@if($arr6[$key-1])
        												<i class="fas fa-file-pdf" style="font-size: 12px;"></i>
        												@endif
        											</td>
        											@php($cant++)
        											@endif
        											@php($colspan=0)
        										@endif
        										@php($anterior=$valor)
        									@endforeach
        									@while ($cant<13)
        										<td style="display: none;"></td>
        										@php($cant++)
        									@endwhile

        									@if(auth()->user()->hasRoles('asignaciones.create'))
        										<td  align="center"><button type="button" class="btn btn-default p-0" >
        											<i class="fas fa-edit" style="font-size: 24px;"></i>
        											</button>
        										</td>
        									@else
        										<td></td>
        									@endif

        								@if($futuro)
        									<td  align="center">
        										@if(auth()->user()->hasRoles('asignaciones.create'))
        											<button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-user-slash" style="font-size: 24px;"></i>
        											</button>
        										@endif
        									</td>
        									<td  align="center">
        										@if(auth()->user()->hasRoles('asignaciones.create'))
        											<button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-clock" style="font-size: 24px;"></i>
        											</button>
        										@endif
        									</td>
        									@else
        									<td></td>
        									<td></td>
        								@endif
        							</tr>
        							@endif
        								@if($user->proyecto->id == 12)

        							@php($username="")
        							@php($coordinador1="")
        							@php($coordinador2="")
        							@php($coordinador3="")
        							<tr>
        								@php($username=$user->name." ".$user->apaterno." ".$user->amaterno)
        								@php($username =$username."/")
        								<td>{{($user->Comuna->Region->codigo) ?? ''}}</td>
        								<td>{{($user->Comuna->nombre) ?? ''}}</td>

        								<td>{{($user->Proyecto->nombre) ?? ''}}</td>
        								<td>{{($user->cargo->nombre) ?? ''}}</td>

        								@php($horacount=7)
        								@php($arr=[-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-3])
        								@php($arr2=["","","","","","","","","","","","","",""])
        								@php($arr3=["","","","","","","","","","","","","",""])
        								@php($arr4=["","","","","","","","","","","","","",""])
        								@php($arr5=["","","","","","","","","","","","","",""])
        								@php($arr6=["","","","","","","","","","","","","",""])
        								@php($lugar_trabajo="")
        								@foreach($user->HorasDia(str_replace("-", "", $date) ) as $hora)
        									@php($contador=$hora->hora-$horacount)
        									@php($arr[$contador]=$hora->actividad_id)
        									@php($arr2[$contador]=$hora->Actividad->nombre)
        									@php($arr3[$contador]=$hora->Actividad->tipo_asistencia_id)
        									@php($arr4[$contador]=($hora->Actividad->fecha_ini) ?? null)
        									@php($arr5[$contador]=($hora->Actividad->fecha_ini && $hora->Actividad->fecha_fin) ? 'bg-success' : getColor($hora->Actividad->tipo_asistencia_id))
        									@php($arr6[$contador]=($hora->Actividad->archivo) ?? null)
        									@php($lugar_trabajo=($hora->Actividad->Comuna->nombre) ?? '')
        									@php($coordinador2=($hora->Actividad->coordinacion_name) ?? '')
        									@if($coordinador3==$coordinador2)
        									@else
        									@php($coordinador3=$coordinador2)
        									@php($coordinador1 = $coordinador1 . "/" . $coordinador2)
        									@endif

        								@endforeach
        								<td>{{$lugar_trabajo}}</td>

        								<td>{{$coordinador1}}</td>
        								<td>{{$username}} <button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-book-reader" style="font-size: 24px;"></i>
        											</button></td>
        									@php($colspan=-1)
        									@php($anterior=$arr[0])
        									@php($cant=0)
        									@foreach($arr as $key => $valor)
        										@php($colspan++)
        										@if($anterior!=$valor)
        											@if($anterior==-2)
        											<td  colspan="{{$colspan}}"></td>
        											@php($cant++)
        											@else
        											<td align="center" style="cursor:pointer" onclick="getTarea('{{$anterior}}')" class="{{$arr5[$key-1]}} color-palette border border-light" colspan="{{$colspan}}">{{$arr2[$key-1]}}
        												@if($arr4[$key-1])
        												<i class="fas fa-check" style="font-size: 12px;"></i>
        												@endif
        												@if($arr6[$key-1])
        												<i class="fas fa-file-pdf" style="font-size: 12px;"></i>
        												@endif
        											</td>
        											@php($cant++)
        											@endif
        											@php($colspan=0)
        										@endif
        										@php($anterior=$valor)
        									@endforeach
        									@while ($cant<13)
        										<td style="display: none;"></td>
        										@php($cant++)
        									@endwhile

        									@if(auth()->user()->hasRoles('asignaciones.create'))
        										<td  align="center"><button type="button" class="btn btn-default p-0" >
        											<i class="fas fa-edit" style="font-size: 24px;"></i>
        											</button>
        										</td>
        									@else
        										<td></td>
        									@endif

        								@if($futuro)
        									<td  align="center">
        										@if(auth()->user()->hasRoles('asignaciones.create'))
        											<button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-user-slash" style="font-size: 24px;"></i>
        											</button>
        										@endif
        									</td>
        									<td  align="center">
        										@if(auth()->user()->hasRoles('asignaciones.create'))
        											<button type="button" class="btn btn-default p-0" >
        												<i class="fas fa-clock" style="font-size: 24px;"></i>
        											</button>
        										@endif
        									</td>
        									@else
        									<td></td>
        									<td></td>
        								@endif
        							</tr>
        							@endif
        							@endforeach


        				@else
        					@foreach($users->where('proyecto_id','<>',14) as $user)


        					@php($username="")
        					 @php($coordinador1="")
        					 @php($coordinador2="")
        					 @php($coordinador3="")
        					<tr>
        						@php($username=$user->name." ".$user->apaterno." ".$user->amaterno)
        						@php($username =$username."/")
        						<td>{{($user->Comuna->Region->codigo) ?? ''}}</td>
        						<td>{{($user->Comuna->nombre) ?? ''}}</td>

        						<td>{{($user->Proyecto->nombre) ?? ''}}</td>
        						<td>{{($user->cargo->nombre) ?? ''}}</td>

        			            @php($horacount=7)
        				        @php($arr=[-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-3])
        				        @php($arr2=["","","","","","","","","","","","","",""])
        				        @php($arr3=["","","","","","","","","","","","","",""])
        				        @php($arr4=["","","","","","","","","","","","","",""])
        						@php($arr5=["","","","","","","","","","","","","",""])
                                @php($arr6=["","","","","","","","","","","","","",""])
                                @php($lugar_trabajo="")
        			            @foreach($user->HorasDia(str_replace("-", "", $date) ) as $hora)
        				            @php($contador=$hora->hora-$horacount)
        				            @php($arr[$contador]=$hora->actividad_id)
        				            @php($arr2[$contador]=$hora->Actividad->nombre)
        				            @php($arr3[$contador]=$hora->Actividad->tipo_asistencia_id)
        				            @php($arr4[$contador]=($hora->Actividad->fecha_ini) ?? null)
        				            @php($arr5[$contador]=($hora->Actividad->fecha_ini && $hora->Actividad->fecha_fin) ? 'bg-success' : getColor($hora->Actividad->tipo_asistencia_id))
                                    @php($arr6[$contador]=($hora->Actividad->archivo) ?? null)
                                    @php($lugar_trabajo=($hora->Actividad->Comuna->nombre) ?? '')
                                    @php($coordinador2=($hora->Actividad->coordinacion_name) ?? '')
                                    @if($coordinador3==$coordinador2)
                                    @else
                                     @php($coordinador3=$coordinador2)
                                     @php($coordinador1 = $coordinador1 . "/" . $coordinador2)
                                    @endif

        						@endforeach
        						<td>{{$lugar_trabajo}}</td>

        						<td>{{$coordinador1}}</td>
        						<td>{{$username}} <button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$user->id}}','{{$username}}','{{$user->fono}}','{{$user->rut}}','{{$user->emailPersonal}}','{{$user->direccion}}','{{$user->Comuna->nombre}}','{{$user->Comuna->Region->codigo}}')">
                                                <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                            </button></td>
        			            	@php($colspan=-1)
        							@php($anterior=$arr[0])
        							@php($cant=0)
        		            		@foreach($arr as $key => $valor)
        		            			@php($colspan++)
        		            			@if($anterior!=$valor)
        		            				@if($anterior==-2)
        									<td  colspan="{{$colspan}}"></td>
        									@php($cant++)
        		            				@else
        			            			 <td align="center" style="cursor:pointer" onclick="getTarea('{{$anterior}}')" class="{{$arr5[$key-1]}} color-palette border border-light" colspan="{{$colspan}}">{{$arr2[$key-1]}}
        										@if($arr4[$key-1])
        				            			  <i class="fas fa-check" style="font-size: 12px;"></i>
        										@endif
        										@if($arr6[$key-1])
        				            			  <i class="fas fa-file-pdf" style="font-size: 12px;"></i>
                                                @endif
        									</td>
        									@php($cant++)
        		            				@endif
        		            				@php($colspan=0)
        								@endif
        								@php($anterior=$valor)
        							 @endforeach
        							 @while ($cant<13)
        							 	<td style="display: none;"></td>
        								 @php($cant++)
        							 @endwhile

                                    @if(auth()->user()->hasRoles('asignaciones.create'))
                                        <td  align="center"><button type="button" class="btn btn-default p-0" onclick="showModal('{{$user->id}}','{{$username}}',[{!! implode(",",$arr) !!}])">
                                            <i class="fas fa-edit" style="font-size: 24px;"></i>
                                            </button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                @if($futuro)
                                    <td  align="center">
                                        @if(auth()->user()->hasRoles('asignaciones.create'))
                                            <button type="button" class="btn btn-default p-0" onclick="showFalta('{{$user->id}}','{{$username}}')">
                                                <i class="fas fa-user-slash" style="font-size: 24px;"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td  align="center">
                                        @if(auth()->user()->hasRoles('asignaciones.create'))
                                            <button type="button" class="btn btn-default p-0" onclick="showAtraso('{{$user->id}}','{{$username}}')">
                                                <i class="fas fa-clock" style="font-size: 24px;"></i>
                                            </button>
                                        @endif
                                    </td>
                                    @else
                                    <td></td>
                                    <td></td>
                                @endif
        					</tr>
        					@endforeach

        				@endif
        				</tbody>
        			</table>
        		</div>
		        <div class="tab-pane" id="tab_2">
    			    <table class="table table-striped table-bordered table-hover compact table-sm " id="dateTable2" style="width:100%">
        				<thead  class="thead-dark">
        					<tr>
        					    <th>Region</th>
        						<th>Comuna</th>
        						<th>Proyecto</th>
        						<th>Grupo</th>
        						<th>Ciudad de Trabajo</th>
        						<th>Coordinador</th>
        						<th>Nombre</th>
                                <th align="center">7:00</th>
                                <th align="center">8:00</th>
        						<th align="center">9:00</th>
        						<th align="center">10:00</th>
        						<th align="center">11:00</th>
        						<th align="center">12:00</th>
        						<th align="center">13:00</th>
        						<th align="center">14:00</th>
        						<th align="center">15:00</th>
        						<th align="center">16:00</th>
        						<th align="center">17:00</th>
        						<th align="center">18:00</th>
        						<th align="center">19:00</th>
        						<th></th>
                                <th></th>
                                <th></th>
        					</tr>
        				</thead>
        				<tbody>
        				@foreach($users->where('proyecto_id',14)  as $user)


        					@php($username="")
        					 @php($coordinador1="")
        					 @php($coordinador2="")
        					 @php($coordinador3="")
        					<tr>
        						@php($username=$user->name." ".$user->apaterno." ".$user->amaterno)
        						@php($username =$username."/")
        						<td>{{($user->Comuna->Region->codigo) ?? ''}}</td>
        						<td>{{($user->Comuna->nombre) ?? ''}}</td>

        						<td>{{($user->Proyecto->nombre) ?? ''}}</td>
        						<td>{{($user->cargo->nombre) ?? ''}}</td>

        			            @php($horacount=7)
        				        @php($arr=[-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-2,-3])
        				        @php($arr2=["","","","","","","","","","","","","",""])
        				        @php($arr3=["","","","","","","","","","","","","",""])
        				        @php($arr4=["","","","","","","","","","","","","",""])
        						@php($arr5=["","","","","","","","","","","","","",""])
                                @php($arr6=["","","","","","","","","","","","","",""])
                                @php($lugar_trabajo="")
        			            @foreach($user->HorasDia(str_replace("-", "", $date) ) as $hora)
        				            @php($contador=$hora->hora-$horacount)
        				            @php($arr[$contador]=$hora->actividad_id)
        				            @php($arr2[$contador]=$hora->Actividad->nombre)
        				            @php($arr3[$contador]=$hora->Actividad->tipo_asistencia_id)
        				            @php($arr4[$contador]=($hora->Actividad->fecha_ini) ?? null)
        				            @php($arr5[$contador]=($hora->Actividad->fecha_ini && $hora->Actividad->fecha_fin) ? 'bg-success' : getColor($hora->Actividad->tipo_asistencia_id))
                                    @php($arr6[$contador]=($hora->Actividad->archivo) ?? null)
                                    @php($lugar_trabajo=($hora->Actividad->Comuna->nombre) ?? '')
                                    @php($coordinador2=($hora->Actividad->coordinacion_name) ?? '')
                                    @if($coordinador3==$coordinador2)
                                    @else
                                     @php($coordinador3=$coordinador2)
                                     @php($coordinador1 = $coordinador1 . "/" . $coordinador2)
                                    @endif

        						@endforeach
        						<td>{{$lugar_trabajo}}</td>

        						<td>{{$coordinador1}}</td>
        						<td>{{$username}} <button type="button" class="btn btn-default p-0" onclick="showInfoTecnico('{{$user->id}}','{{$username}}','{{$user->fono}}','{{$user->rut}}','{{$user->emailPersonal}}','{{$user->direccion}}','{{$user->Comuna->nombre}}','{{$user->Comuna->Region->codigo}}')">
                                                <i class="fas fa-book-reader" style="font-size: 24px;"></i>
                                            </button></td>
        			            	@php($colspan=-1)
        							@php($anterior=$arr[0])
        							@php($cant=0)
        		            		@foreach($arr as $key => $valor)
        		            			@php($colspan++)
        		            			@if($anterior!=$valor)
        		            				@if($anterior==-2)
        									<td  colspan="{{$colspan}}"></td>
        									@php($cant++)
        		            				@else
        			            			 <td align="center" style="cursor:pointer" onclick="getTarea('{{$anterior}}')" class="{{$arr5[$key-1]}} color-palette border border-light" colspan="{{$colspan}}">{{$arr2[$key-1]}}
        										@if($arr4[$key-1])
        				            			  <i class="fas fa-check" style="font-size: 12px;"></i>
        										@endif
        										@if($arr6[$key-1])
        				            			  <i class="fas fa-file-pdf" style="font-size: 12px;"></i>
                                                @endif
        									</td>
        									@php($cant++)
        		            				@endif
        		            				@php($colspan=0)
        								@endif
        								@php($anterior=$valor)
        							 @endforeach
        							 @while ($cant<13)
        							 	<td style="display: none;"></td>
        								 @php($cant++)
        							 @endwhile

                                    @if(auth()->user()->hasRoles('asignaciones.create'))
                                        <td  align="center"><button type="button" class="btn btn-default p-0" onclick="showModal('{{$user->id}}','{{$username}}',[{!! implode(",",$arr) !!}])">
                                            <i class="fas fa-edit" style="font-size: 24px;"></i>
                                            </button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif

                                @if($futuro)
                                    <td  align="center">
                                        @if(auth()->user()->hasRoles('asignaciones.create'))
                                            <button type="button" class="btn btn-default p-0" onclick="showFalta('{{$user->id}}','{{$username}}')">
                                                <i class="fas fa-user-slash" style="font-size: 24px;"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td  align="center">
                                        @if(auth()->user()->hasRoles('asignaciones.create'))
                                            <button type="button" class="btn btn-default p-0" onclick="showAtraso('{{$user->id}}','{{$username}}')">
                                                <i class="fas fa-clock" style="font-size: 24px;"></i>
                                            </button>
                                        @endif
                                    </td>
                                    @else
                                    <td></td>
                                    <td></td>
                                @endif
        					</tr>
        					@endforeach

        				</tbody>
        			</table>
        		</div>
        	</div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
<!--modal para modificar la hora-->
<div class="modal fade" id="modificar" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Modificar Hora: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('asignaciones.hora')}}"  enctype="multipart/form-data">
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
	            	<div class="row">
	            		<div class="col-sm-6">

							 <div class="form-group" id="bodyReferenciasModal">

		                      </div>


	            		</div>
						<div class="col-sm-6">
						<div id="motivo_id" ><label>Motivo</label>
							<select class="form-control select2" id="motivo_modificar" name="motivo_modificar" required>
								@foreach($motivos as $motivo)
								  @if($motivo->tipo == "MODIFICAR")
									<option value="{{$motivo->id}}">{{$motivo->name}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div id="solicitado_id" ><label>Solicitado Por</label>
							<select class="form-control select2" id="solicitado_modificar" name="solicitado_modificar" required>
								@foreach($solicitados as $solicitado)

									<option value="{{$solicitado->id}}">{{$solicitado->name . ' ' . $solicitado->apaterno . ' '. $solicitado->amaterno}}</option>

								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="exampleInputFile">Subir Respaldo</label>
							<div class="input-group">
							<div class="custom-file">
								<input type="file" id="archivo_modificar" name="archivo_respaldo_modificar" accept="image/png, image/jpeg,.pdf">
							</div>

							</div>
						</div>
					</div>




	            	</div>
	        		<input type="hidden" class="form-control" name="fechadatos2" value="{{$date}}">
	            	<input type="hidden" name="user_id2" id="modal-user-id2"/>
					<input type="hidden" name="actividad_id_modificacion" id="actividad_id_modificacion" />
	            	<input type="hidden" name="coordinacion2" value="{{auth()->user()->id}}"/>
	            	<input type="hidden" name="coordinacion_name2" value="{{auth()->user()->name.' '.auth()->user()->apaterno}}"/>
	            </div>
	            <!-- /.card-body -->

	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-primary">Editar</button>
	    </div>
	  </form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div> <!-- /Fin del Modal -->

<!--modal-->
<div class="modal fade" id="modal-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title" id="title">Asignar Tarea: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('asignaciones.store')}}" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
	            	<div class="row">
	            		<div class="col-sm-6">
						<div class="form-group">
	                        <label>Proyecto</label>
	                        <select class="form-control select2" id="inputCliente" name="proyecto_id" required>
	                          @foreach ($proyectos as $poyecto)
	                          	<option value="{{$poyecto->id}}">{{$poyecto->nombre}}</option>
	                          @endforeach
	                        </select>
	                      </div>
		                  <div class="form-group">
		                    <label for="inputActividad">Nro. Actividad</label>
		                    <input type="text" class="form-control" id="inputActividad" name="actividad" required>
		                  </div>
		                  <div class="form-group">
		                    <label for="inputDireccion">Direccion</label>
		                    <input type="text" class="form-control" id="inputDireccion" name="direccion" required>
		                  </div>
						<div class="form-group">
		                  <label>Comuna</label>
		                  <select class="form-control select2"  id="inputComuna" name="comuna_id" required>
		                  	@foreach($comunas as $comuna)
		                    	<option value="{{$comuna->id}}">{{$comuna->nombre}}</option>
		                    @endforeach
		                  </select>
		                </div>
		                  <div class="form-group">
		                    <label for="inputUsuario">Usuario</label>
		                    <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
		                  </div>
			                  <div class="form-group">
			                    <label for="inputDetalle">Detalle</label>
			                    <input type="text" class="form-control" id="inputDetalle" name="detalle" required>
			                  </div>
	            		</div>

	            		<div class="col-sm-6">
	            		    <div class="form-group">
		                  <label>Centro de Costo</label>
		                  <select class="form-control select2"  id="inputCcosto" name="costo_id" required>
		                      <option value="0">Seleccione Centro de Costo</option>
		                  	@foreach($costo as $costo)
		                    	<option value="{{$costo->id}}">{{$costo->descripcion}}</option>
		                    @endforeach
		                  </select>
		                </div>
							 <div class="form-group">
		                        <label>Horas</label>
		                        <select multiple="" class="form-control" id="inputHoras" name="horas[]" required>
                                  <option id="hora7" value="7">7:00</option>
                                  <option id="hora8" value="8">8:00</option>
		                          <option id="hora9" value="9">9:00</option>
		                          <option id="hora10" value="10">10:00</option>
		                          <option id="hora11" value="11">11:00</option>
		                          <option id="hora12" value="12">12:00</option>
		                          <option id="hora13" value="13">13:00</option>
		                          <option id="hora14" value="14">14:00</option>
		                          <option id="hora15" value="15">15:00</option>
		                          <option id="hora16" value="16">16:00</option>
		                          <option id="hora17" value="17">17:00</option>
		                          <option id="hora18" value="18">18:00</option>
		                          <option id="hora19" value="19">19:00</option>
		                        </select>
		                      </div>
							  <div class="form-group">
		                        <label>Nota</label>
		                        <textarea class="form-control" rows="6" id="inputNota" name="nota" placeholder="" ></textarea>
		                      </div>
			                  <div class="form-group">
			                    <label for="inputDeposito">Deposito</label>
			                    <input type="number" class="form-control" min="0" id="inputDeposito" name="deposito" required>
                              </div>
                              <label>Fecha Hora para deposito</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation" name="fecha_para_deposito" required>
                              </div>

	            		</div>
	            	</div>
	        		<input type="hidden" class="form-control" name="fechadatos" value="{{$date}}">
	            	<input type="hidden" name="user_id" id="modal-user-id"/>
	            	<input type="hidden" name="coordinacion" value="{{auth()->user()->id}}"/>
	            	<input type="hidden" name="coordinacion_name" value="{{auth()->user()->name.' '.auth()->user()->apaterno}}"/>
	            </div>
	            <!-- /.card-body -->

	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-primary">Guardar</button>
	    </div>
	  </form>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal2-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">

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

						@if (auth()->user()->hasRoles('solo_lectura_asignacion_residente_pjud'))

	            				<div class="row" id="divIniFin">

                                        <div class="col-sm-12">
                                            <form action="{{route('asignaciones.set_ajax_iniciafin')}}" method="POST" id="forminifin">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <br><br>
                                                        <span id="spanIni"></span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <br><br>
                                                        <span id="spanFin"></span>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="actividad_id" id="actividadIniFin"/>
                                            </form>
                                        </div>
                                        <div class="col-sm-12 hidden" id="div-update"><br><br>

                                        </div>
                                        <div class="col-sm-12" id="div-file"><br><br>

                                        </div>

	            				</div>

						@else
						<div class="row" id="divIniFin">
                                    @if(auth()->user()->hasRoles('asignaciones.iniciafin'))
                                        <div class="col-sm-12">
                                            <form action="{{route('asignaciones.set_ajax_iniciafin')}}" method="POST" id="forminifin">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <button type="submit" class="btn btn-primary" id="btnIni" name="inifin" disabled value="iniciar">Iniciar</button><br><br>
                                                        <span id="spanIni"></span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button type="submit" class="btn btn-primary" id="btnFin" disabled name="inifin" value="finalizar">Finalizar</button>	<br><br>
                                                        <span id="spanFin"></span>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="actividad_id" id="actividadIniFin"/>
                                            </form>
                                        </div>
                                        <div class="col-sm-12 hidden" id="div-update"><br><br>
                                            <form action="{{route('asignaciones.upload_checklist')}}" method="POST" enctype="multipart/form-data" id="forminifin">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Subir CheckList</label>
                                                    <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="archivo" required disabled id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Seleccione Archivo</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary" id="btnsubir" disabled >Subir</button>
                                                    </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="actividad_id" id="actividadUploadCheck"/>
                                            </form>
                                        </div>
                                        <div class="col-sm-12" id="div-file"><br><br>
                                            <form action="{{route('asignaciones.delete_checkList')}}" method="POST" id="forminifin">
                                                @csrf
                                                @method('DELETE')
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <a href="#" id="afile" target="_blank"><i class="fas fa-file-pdf" style="font-size: 48px;color:red"></i></a>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button class="btn btn-danger" onclick="deleteFileModal();" id="btndelete">Eliminar</button>
                                                        <input type="hidden" name="eliminar" id="inputeliminar">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="actividad_id" id="actividadDeleteCheck"/>
                                            </form>
                                        </div>
                                    @endif
	            				</div>

						@endif

	            		</div>
	            	</div>

	            </div>
	     </div>
		    <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <label id="creada">Actividad Creada:</label>
              @if(auth()->user()->hasRoles('asignaciones.destroy'))
              <form action="{{route('asignaciones.destroy')}}" method="POST" id="deleteAsignacion">
                {{ csrf_field() }}
                @method('delete')
                <button type="button" class="btn btn-danger" onclick="deleteModal();" data-dismiss="modal">Eliminar Asignacion</button>
                <input type="hidden" name="delete_id" id="delete_asign">
				<button type="button" class="btn btn-info" onclick="modificarModal();" data-dismiss="modal">Modificar Asignacion</button>
                <input type="hidden" name="delete_id2" id="delete_asign2">
              </form>
              @endif
            </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal3-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
    <form action="{{route('asignaciones.set_ajax_falta')}}" method="POST">
	    {{ csrf_field() }}
	  <div class="modal-content">
	    <div class="modal-header">
          <h4 class="modal-title">Marcar Falta: <span id="mdlNombreFalta"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
          </button>

        </div>
        <div class="" id="err_div" style="display: none;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                El usuario tiene tareas asignadas, debe eliminarlas primero antes de asignar la falta.
            </div>
        </div>

	    	<div class="modal-body">
	            <div class="card-body">
					  <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNotaFalta" name="nota" placeholder="" ></textarea>
                      </div>
	            </div>
	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-danger" >Marcar como Falta</button>
	    </div>
	        <input type="hidden" class="form-control" name="fechafalta" value="{{$date}}">
	        <input type="hidden" name="user_id" id="modal-falta-user-id"/>
	  </div>
	</form>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- /.modal-info-tecnico -->
<div class="modal fade" id="modal5-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">

	  <div class="modal-content">
	    <div class="modal-header">
          <h4 class="modal-title">Informacion Tecnico: <span id="mdlNombreFalta"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
          </button>

        </div>


	    	<div class="modal-body">
	            <div class="card-body">
					  <div class="form-group">
                        <label>Rut: <span id="mdlRutInfo"></span></label>
                    </br>
                    <label>Nombre: <span id="mdlNombreInfo"></span></label>
                    </br>
                    <label>Telefono: <span id="mdlFonoInfo"></span></label>
                    </br>
                    <label>Email Personal: <span id="mdlEmailnfo"></span></label>
                    </br>
                    </br>
                    <label>Direccion: <span id="mdlDireccionInfo"></span></label>
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



<!-- modal Atraso-->
<div class="modal fade" id="modal4-xl" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
    <form action="{{route('asignaciones.set_ajax_atraso')}}" method="POST">
	    {{ csrf_field() }}
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Marcar Atraso: <span id="mdlNombreAtraso"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
        </div>
	    	<div class="modal-body">
	            <div class="card-body">
                    <div class="form-group">
                        <label for="appt">Hora de Inicio:</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" min="07:00" max="19:00" required>
                    </div>
                    <div class="form-group">
                        <label for="appt">Hora LLegada:</label>
                        <input type="time" class="form-control" id="hora_llegada" name="hora_llegada" min="07:00" max="19:00" required>
                    </div>
                    <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="inputNotaAtraso" name="nota" placeholder="" ></textarea>
                    </div>
	            </div>
	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-danger" >Guardar Atraso</button>
	    </div>
	        <input type="hidden" class="form-control" name="fechaatraso" value="{{$date}}">
	        <input type="hidden" name="user_id" id="modal-atraso-user-id"/>
	  </div>
	</form>
	</div>
</div>


<!--modal asignacion masiva-->
<div class="modal fade" id="modal-xl-masiva" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-xl">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Asignar Masivos: </h4>
	      <h4 class="modal-title"><span id="modal-user-name"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<form role="form" method="POST" action="{{route('asignacion.masiva')}}" >
			 {{ csrf_field() }}
	    	<div class="modal-body">
	            <div class="card-body">
					<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
					<input type="checkbox" onchange="seleccion_masiva('proyecto')" id="Proyecto_masivo" name="seleccion_masiva[]" value="Proyectos"> Por Proyectos<br>
					</div>
					<div class="col-sm-6">

<input type="checkbox" onchange="seleccion_masiva('usuario')" id="Usuario_masivo" name="seleccion_masiva[]" value="Usuarios"> Por Usuarios<br>
</div>
</div>

                       <div id="por_proyecto" style="display: none"><label>Por Proyecto</label>
                        <select class="form-control select2" id="proyecto_masivo" name="proyecto_masivo" required>
                            @foreach($proyectos as $proyecto)
	                    	    <option value="{{$proyecto->id}}">{{$proyecto->nombre}}</option>
	                        @endforeach
                        </select></div>

                  	</div>
					<div class="form-group">

					<div id="por_usuario" style="display: none"><label>Por Usuario</label>
	                  <select class="form-control select2"  id="usuario_masivo" name="usuario_masivo" required >
	                  	@foreach($users as $usuario)
	                    	<option value="{{$usuario->id}}">{{$usuario->name." ".$usuario->apaterno." ".$usuario->amaterno}}</option>
	                    @endforeach
	                  </select>
					  <label>Proyecto</label>
					  <select class="form-control select2" id="proyecto_id_masivo" name="proyecto_id" required>
                            @foreach($proyectos as $proyecto)
	                    	    <option value="{{$proyecto->id}}">{{$proyecto->nombre}}</option>
	                        @endforeach
                        </select>


					</div>

	                </div>
					<div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text">
	                        <i class="far fa-calendar-alt"></i>
	                      </span>
	                    </div>
	                    <input type="text" class="form-control float-right" id="reservation_masivo" name="fechadatos" required>
	                  </div>
					  <div class="form-group">
                        <label>Nota</label>
                        <textarea class="form-control" rows="6" id="Nota_masivo" name="nota" placeholder="" ></textarea>
                      </div>
					  <div class="row">
	            		<div class="col-sm-6">
					  <div class="form-group">
		                    <label for="inputActividad">Nro. Actividad</label>
		                    <input type="text" class="form-control" id="inputActividad" name="actividad" required>
		                  </div>
		                  <div class="form-group">
		                    <label for="inputDireccion">Direccion</label>
		                    <input type="text" class="form-control" id="inputDireccion" name="direccion" required>
		                  </div>
						<div class="form-group">
		                  <label>Comuna</label>
		                  <select class="form-control select2"  id="inputComuna_masivo" name="comuna_id" required>
		                  	@foreach($comunas as $comuna)
		                    	<option value="{{$comuna->id}}">{{$comuna->nombre}}</option>
		                    @endforeach
		                  </select>
		                </div>
						</div>


	            		<div class="col-sm-6">
		                  <div class="form-group">
		                    <label for="inputUsuario">Usuario</label>
		                    <input type="text" class="form-control" id="inputUsuario" name="usuario" required>
		                  </div>
			                  <div class="form-group">
			                    <label for="inputDetalle">Detalle</label>
			                    <input type="text" class="form-control" id="inputDetalle" name="detalle" required>
			                  </div>

							  <div class="form-group">
		                        <label>Horas</label>
		                        <select multiple="" class="form-control" id="inputHoras" name="horas[]" required>
                                  <option id="hora7" value="7">7:00</option>
                                  <option id="hora8" value="8">8:00</option>
		                          <option id="hora9" value="9">9:00</option>
		                          <option id="hora10" value="10">10:00</option>
		                          <option id="hora11" value="11">11:00</option>
		                          <option id="hora12" value="12">12:00</option>
		                          <option id="hora13" value="13">13:00</option>
		                          <option id="hora14" value="14">14:00</option>
		                          <option id="hora15" value="15">15:00</option>
		                          <option id="hora16" value="16">16:00</option>
		                          <option id="hora17" value="17">17:00</option>
		                          <option id="hora18" value="18">18:00</option>
		                          <option id="hora19" value="19">19:00</option>
		                        </select>
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


<!-- modal Eliminacion-->
<div class="modal fade" id="modal4-xl-eliminacion" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
    <form action="{{route('asignaciones.destroy')}}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		@method('delete')
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Motivo de Eliminacion: <span id="mdlNombreAtraso"></span></h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
        </div>
	    	<div class="modal-body">
	            <div class="card-body">
                    <div id="motivo_id" ><label>Motivo</label>
                        <select class="form-control select2" id="motivo" name="motivo" required>
                            @foreach($motivos as $motivo)
							  @if($motivo->tipo == "ELIMINAR")
	                    	    <option value="{{$motivo->id}}">{{$motivo->name}}</option>
								@endif
	                        @endforeach
                        </select>
					</div>
					<div id="solicitado_id" ><label>Solicitado Por</label>
                        <select class="form-control select2" id="solicitado" name="solicitado" required>
                            @foreach($solicitados as $solicitado)

	                    	    <option value="{{$solicitado->id}}">{{$solicitado->name . ' ' . $solicitado->apaterno . ' '. $solicitado->amaterno}}</option>

	                        @endforeach
                        </select>
					</div>

					<div class="form-group">
						<label for="exampleInputFile">Subir Respaldo</label>
						<div class="input-group">
						<div class="custom-file">
							<input type="file" id="archivo" name="archivo_respaldo" accept="image/png, image/jpeg,.pdf">
						</div>

						</div>
					</div>

	            </div>
	     </div>
	    <div class="modal-footer justify-content-between">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      <button type="submit" class="btn btn-danger" >ELIMINAR</button>
	    </div>

	        <input type="hidden" name="delete_id" id="actividad_id_eliminar"/>
	  </div>
	</form>
	</div>
</div>

@stop

@section('scripts')
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript">

$(document).ready(function() {

    //Date range picker
    $('#reservation_masivo').daterangepicker();

});

function showModal_masiva() {
	    $('#modal-xl-masiva').modal('show')
	}

	function showModal(user_id,user_name,arr) {


	    $('#modal-user-name').html(user_name);
	    $('#modal-user-id').val(user_id);
	    $('#modal-user-id2').val(user_id);
	    $user = user_name.replace("/","");
	    $('#title').html("Asignar Tarea A: " + $user);
	    for (var i = 0; i<13; i++) {
			$('#hora'+(i+7)).prop("disabled",false);
	    }

		arr.forEach(function(element,i){
			if(element>-2){
				$('#hora'+(i+7)).prop("disabled",true);
			}
			i++;
		}

		);
	    $('#modal-xl').modal('show')
	}

	function seleccion_masiva($tipo)
	{
		if($tipo == 'usuario'){
			let miCheckboxU = document.getElementById('Usuario_masivo');

			if(miCheckboxU.checked) {
				document.getElementById("por_usuario").style.display = "block";
				document.getElementById("por_proyecto").style.display = "none";

				document.getElementById("Proyecto_masivo").checked = false;


    } else {
		document.getElementById("por_usuario").style.display = "none";
    }

		}
		if($tipo == 'proyecto'){

			let miCheckboxU = document.getElementById('Proyecto_masivo');

			if(miCheckboxU.checked) {
				document.getElementById("por_proyecto").style.display = "block";
				document.getElementById("por_usuario").style.display = "none";

				document.getElementById("Usuario_masivo").checked = false;


    } else {
		document.getElementById("por_proyecto").style.display = "none";
    }

}

	}

	function modificarModal() {
		 act_id = $('#actividadUploadCheck').val();
		let token = '{{csrf_token()}}';
	    let data={id:act_id,_token:token};
		clear();
		html="";
		$.ajax({
	        type: 'POST',
	        url: '{{route('asignaciones.get_ajax_modificar_actividad')}}',
	        dataType: 'json',
	        data: data,
	        success: function (data) {
				html = '<label>Seleccione Horas a Eliminar</label> '
		                +  '<select multiple="" class="form-control" id="inputHoras" name="horas[]" required> ';





				data.actividad.forEach(function(act, index2){

					let h = 0;

					$.each(act, function(index, value) {



						if(index == 'id'){
							//console.log(index + ":" +value);
							h = value;
						}

						if(index == 'hora'){

							if(value == "7"){
								html=html+`<option id="hora7" value="${h}">Desde las 7:00 Hasta las 8:00</option>`;

							}
							if(value == "8"){
								html=html+`<option id="hora8" value="${h}">Desde las 8:00 Hasta las 9:00</option>`;

							}
							if(value == "9"){
								html=html+`<option id="hora9" value="${h}">Desde las 9:00 Hasta las 10:00</option>`;

							}
							if(value == "10"){
								html=html+`<option id="hora10" value="${h}">Desde las 10:00 Hasta las 11:00</option>`;

							}
							if(value == "11"){
								html=html+`<option id="hora11" value="${h}">Desde las 11:00 Hasta las 12:00</option>`;

							}
							if(value == "12"){
								html=html+`<option id="hora12" value="${h}">Desde las 12:00 Hasta las 13:00</option>`;

							}
							if(value == "13"){
								html=html+`<option id="hora13" value="${h}">Desde las 13:00 Hasta las 14:00</option>`;

							}
							if(value == "14"){
								html=html+`<option id="hora14" value="${h}">Desde las 14:00 Hasta las 15:00</option>`;

							}
							if(value == "15"){
								html=html+`<option id="hora15" value="${h}">Desde las 15:00 Hasta las 16:00</option>`;

							}
							if(value == "16"){
								html=html+`<option id="hora16" value="${h}">Desde las 16:00 Hasta las 17:00</option>`;

							}
							if(value == "17"){
								html=html+`<option id="hora17" value="${h}">Desde las 17:00 Hasta las 18:00</option>`;

							}
							if(value == "18"){
								html=html+`<option id="hora18" value="${h}">Desde las 18:00 Hasta las 19:00</option>`;

							}
							if(value == "19"){
								html=html+`<option id="hora19" value="${h}">Desde las 19:00 Hasta las 20:00</option>`;

							}

						}



				});

				});

				html = html + '</select>';






	        	$('#bodyReferenciasModal').html(html);
				$('#actividad_id_modificacion').val(act_id);
	        	$('#modificar').modal('show')
	      },
	        error: function (request, status, error) {
	        	clear();
	        }
		})



	}

	function showFalta(user_id,user_name) {
	    $('#mdlNombreFalta').html(user_name);
	    $('#modal-falta-user-id').val(user_id);
	    $('#modal3-xl').modal('show')
        isFree(user_id);
	}

	function showAtraso(user_id,user_name) {
	    $('#mdlNombreAtraso').html(user_name);
	    $('#modal-atraso-user-id').val(user_id);
	    $('#modal4-xl').modal('show')
	}


		function showInfoTecnico(user_id,user_name,user_fono,user_rut,user_email,user_direccion,user_comuna,user_region) {
	    $('#mdlRutInfo').html(user_rut);
	    $('#mdlNombreInfo').html(user_name);
	    $('#mdlFonoInfo').html(user_fono);
	    $('#mdlEmailnfo').html(user_email);
	    let $datoD = user_direccion +"/"+ user_comuna;
	    $('#mdlDireccionInfo').html($datoD);
	    $('#modal5-xl').modal('show')
	}


	function isFree(user_id) {
	    var horas='7,8,9,10,11,12,13,14,15,16,17,18,19';
        $('#err_div').css('display','none');
	    $.ajax({
	        type: 'GET',
	        url: '/asignaciones/ajax/isFree/'+user_id+'/{{$date}}/'+horas,
	        dataType: 'json',
	        success: function (data) {
                console.log(data);
	       },
	        error: function (request, status, error) {
                $('#err_div').css('display','block');
	        }
		})
    }

	function getTarea(act_id) {
	    var token = '{{csrf_token()}}';
	    var data={id:act_id,_token:token};
		clear();
	    $.ajax({
	        type: 'POST',
	        url: '{{route('asignaciones.get_ajax_actividad')}}',
	        dataType: 'json',
	        data: data,
	        success: function (data) {



	            let date = new Date(Date.parse(data.actividad.created_at));
	            let year = date.getFullYear();
	            let dia = date.getDate();
	            let mes = date.getMonth();

	            let mes_f = mes + 1;

	            if(mes_f < 10)
	            {
	                mes_f = "0"+mes_f;
	            }
	            if(dia < 10)
	            {
	                dia = "0"+dia;
	            }


	            let hora = date.getHours();
	            let minutos = date.getMinutes();

	            if(hora < 10)
	            {
	                hora = "0"+hora;
	            }
	            if(minutos < 10)
	            {
	                minutos = "0"+minutos;
	            }
	            $('#creada').html("Actividad Creada: " +dia+ "-"+ mes_f+"-"+ year + " / " + hora +":" + minutos);

	        	$('#mdlNombre').html(data.actividad.nombre);
	        	if(data.actividad.tipo_asistencia_id!=0){
	        		$('#divIniFin').addClass("d-none");
	        	}
	        	if(data.actividad.fecha_ini==null){
	        		$('#btnIni').prop("disabled",false);
	        	}else{
	        		$('#spanIni').html(data.actividad.fecha_ini);
		        	if(data.actividad.fecha_fin==null){
		        		$('#btnFin').prop("disabled",false);
		        	}else{
		        		$('#spanFin').html(data.actividad.fecha_fin);
	        			$('#exampleInputFile').prop("disabled",false);
	        			$('#btnsubir').prop("disabled",false);
	        			$('#btndetele').prop("disabled",false);
						if(data.actividad.archivo!=null){
							$('#div-update').addClass("d-none");
							$('#div-file').removeClass("d-none");
							$('#afile').attr('href', data.actividad.archivo);
						}else{
							$('#div-file').addClass("d-none");
						}

		        	}
	        	}

	    		$('#delete_asign').val(data.actividad.id);
	    		$('#actividadIniFin').val(data.actividad.id);
                $('#actividadUploadCheck').val(data.actividad.id);
                $('#actividadDeleteCheck').val(data.actividad.id);
	        	$('#mdlCuerpo').html(data.actividad.descripcion.replace(/\n/g, "</br>")+"<br>Centro Costo: "+(data.actividad.centro_costo?.descripcion ?? ''));
	        	$('#modal2-xl').modal('show')
	       },
	        error: function (request, status, error) {
	        	clear();
	        }
		})

	}

function clear(){
	$('#mdlNombre').html("");
	$('#actividadIniFin').val("");
	$('#mdlCuerpo').html("");
	$('#divIniFin').removeClass("d-none");
	$('#btnIni').prop("disabled",true);
	$('#btnFin').prop("disabled",true);
	$('#spanIni').html("");
	$('#spanFin').html("");
	$('#exampleInputFile').prop("disabled",true);
	$('#btnsubir').prop("disabled",true);
	$('#btndetele').prop("disabled",true);
	$('#div-file').addClass("d-none");
	$('#div-update').removeClass("d-none");
	$('#afile').attr('href', "");
}

$(document).ready(function() {
	$('.select2').select2();
  bsCustomFileInput.init();

  $('#reservation').daterangepicker({
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker24Hour": true,
        locale: {
        format: 'DD/MM/YYYY HH:mm'
        }
    });

  $(function () {
    $('#dateTable1').DataTable({
        "order": [ 0, "asc" ],
        "pageLength": 25,
    });
    $('#dateTable2').DataTable({
        "order": [ 0, "asc" ],
        "pageLength": 25,
    });
  });

});

function deleteFileModal(){
	Swal.fire({
	title: 'Eliminar!',
	text: 'Seguro que quieres eliminar el Archivo?',
	icon: 'error',
	confirmButtonText: 'OK',
	showCancelButton: true,
	}).then((result) => {
	if (result.value) {
		$('#inputeliminar').val("true");
		forminifin.submit();
  		}
	});
}


function deleteModal(){

	let $actividad = $('#actividadDeleteCheck').val();

	$('#actividad_id_eliminar').val($actividad);

	$('#modal4-xl-eliminacion').modal('show');
	/*Swal.fire({
	title: 'Eliminar!',
	text: 'Seguro que quieres eliminar la Asignacion?',
	icon: 'error',
	confirmButtonText: 'OK',
	showCancelButton: true,
	}).then((result) => {
	if (result.value) {
		deleteAsignacion.submit();
  		}
	});*/
}


</script>

@stop
