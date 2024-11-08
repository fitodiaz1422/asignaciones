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
            <li class="breadcrumb-item active">Notificaciones</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
        		<div class="col-xs-8 col-sm-6 col-lg-8">
                    <h1>Notificaciones</h1>
                </div>
                <div class="col-xs-4 col-sm-6 col-md-4">
                    <a href="javascript:setUnreadNotifications();" class="btn btn-block btn-lg btn-info  waves-effect">Marcar Como Leidas</a>
              </div>
            </div>
        </div>
        <div class="card-body">
          <table class="table" id="dateTable1" style="width:100%">
              <thead>
                <tr>
                    <th></th>

                </tr>
              </thead>
              <tbody>
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
    function setUnreadNotifications() {
          var token = '{{csrf_token()}}';
          var data={_token:token};
          $.ajax({
              type: 'POST',
              url: "/SetUnreadNotifications",
              dataType: 'json',
              data: data,
              success: function (data) {
                  location.reload();
              }
          });
      };

  $(document).ready(function() {
      $('#dateTable1').DataTable({
          processing: true,
          serverSide: true,
          searching: false,
          ordering: false,
          pageLength: 25,
          lengthChange: false,
          deferRender: true,
          responsive:true,
          minifiedAjax:true,
          ajax: "{{route('notifications.ajax.list')}}",
          columns: [
              { data: 'action' , name: 'action'},

          ]
      });

  } );
</script>
@endsection
