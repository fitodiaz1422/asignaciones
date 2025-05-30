@extends('layout')

@section('title', 'Exportación de Contabilidad')

@section('contenido')

    <section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-12">
	            <ol class="breadcrumb">
	              <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
	              <li class="breadcrumb-item active">Exportación Contabilidad</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Exportar datos contables a Excel</h3>
                        </div>

                        <form method="POST" action="{{ url('contabilidad/exporta') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha (Año y mes)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="month" class="form-control" name="fecha" value="{{ date('Y-m') }}" required>
                                            </div>
                                            <small class="text-muted">Seleccione el año y mes para la exportación</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipos de datos a exportar</label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="bonos" name="tipos[bonos]" value="1" checked>
                                                <label for="bonos" class="custom-control-label">Bonos</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="depositos" name="tipos[depositos]" value="1" checked>
                                                <label for="depositos" class="custom-control-label">Depósitos</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-excel"></i> Exportar a Excel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Información del proceso</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Descripción del proceso:</strong></p>
                            <ul>
                                <li>Esta herramienta genera un archivo Excel con la información contable del período seleccionado.</li>
                                <li>Se incluirán los siguientes datos en el reporte:</li>
                                <ul>
                                    <li>Rut del beneficiario</li>
                                    <li>Nombre completo del beneficiario</li>
                                    <li>Monto total</li>
                                    <li>Datos bancarios (banco, tipo de cuenta, número de cuenta)</li>
                                    <li>Información adicional para el pago</li>
                                </ul>
                                <li>El formato del archivo es compatible con la mayoría de los sistemas bancarios para facilitar la carga masiva de pagos.</li>
                            </ul>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Importante:</strong> Al generar el reporte, asegúrese de haber seleccionado correctamente el período y los tipos de datos requeridos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Asegurarse de que al menos un tipo de dato esté seleccionado
        $('form').on('submit', function(e) {
            if (!$('#bonos').is(':checked') && !$('#depositos').is(':checked')) {
                e.preventDefault();
                toastr.error('Por favor, seleccione al menos un tipo de dato para exportar (Bonos o Depósitos)');
                return false;
            }
        });

        // Formatear los nombres en texto personalizado (primera letra de cada palabra en mayúscula)
        function formatearTextoPersonal(texto) {
            return texto.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
        }
    });
</script>
@endsection
