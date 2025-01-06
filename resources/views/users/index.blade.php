@extends('layout')

@section('css')
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
            <li class="breadcrumb-item active">Usuarios</li>
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
                    <h1>Usuarios</h1>
                </div>
                <div class="col-sm-3 col-lg-2">
                    <a href="{{route('users.create')}}" class="btn btn-app bg-gradient-success btn-xs"> <br><i class="fas fa-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="dateTable1" style="width:100%;cursor:pointer">
              <thead  class="thead-dark">
                  <tr>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Email</th>
                      <th>Grupo</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($users as $user)
                        <tr {{generateLink('users.show','users.show',$user->id)}} >
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->apaterno.' '.$user->amaterno}}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ ($user->Cargo)?$user->Cargo->nombre:"Sin Grupo" }}</td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
    </div>
</section>

@endsection

@section('scripts')
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
    } );
</script>

@endsection
