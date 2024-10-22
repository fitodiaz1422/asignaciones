

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<link href="<?php echo e(asset('plugins/multi-select/css/multi-select.css')); ?>" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Usuario</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <form action="<?php echo e(route('users.destroy',$user->id)); ?>" method="POST" id="frmDestroy">
    <?php echo csrf_field(); ?>
    <?php echo method_field('delete'); ?>
  </form>


    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 col-lg-10">
                    <h1><?php echo e($user->name." ".$user->apaterno); ?></h1>
                    </div>

                    <div class="col-sm-3 col-lg-2">
                        <button class="btn btn-app bg-gradient-danger btn-xs" type="button" onclick="frmDestroy.submit()"><i class="fas fa-trash "></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="a-validar-home" aria-selected="true">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-documentos-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="documentos" aria-selected="false">Documentos Legales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_3" role="tab" aria-controls="password-profile" aria-selected="false">Contraseña</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form action="<?php echo e(route('users.update',$user->id)); ?>" method="POST" id="formStore" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>

                            <div class="row">
            <div class="col-md-2">
                    <div class="form-group">
                <label for="">Crear Usuario Cliente</label>
                   <input type="checkbox" id="user_cliente" name="user_cliente" onclick="usuarioCliente()" <?php if($users_clientes_count > 0): ?> checked <?php endif; ?>>
                   </div>
                    </div>
                </div>
                <hr>
                <div class="row" id="div_user" <?php if($users_clientes_count > 0): ?> <?php else: ?> style="display:none" <?php endif; ?>>
               
                    <div class="col-md-12">
                        <h3>Usuario Cliente</h3>
                    </div>
                    <div class="col-md-2">
                    <div class="form-group">
                   
                        <label>Seleccionar Cliente</label>
                        <select multiple="multiple" id="cliente_user" name="cliente_user[]">
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  
						      <option value="<?php echo e($cliente->id); ?>" <?php echo e($users_clientes->firstWhere('clientes_id',$cliente->id) ? 'selected' :''); ?> ><?php echo e($cliente->razon_social); ?></option>
    
					      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					    </select>
                        
                    </div>
                    </div>
                  
                </div>
                <hr>

                            <div class="row">
                                <div class="col-md-10">
                                    <h3>Fotografia</h3>
                                    <input name="imagen"  accept="image/*" id="file-input1" type="file" class="fileh" onchange="readURL(this,'#foto1');" style="display: none"/>
                                    <a id="afoto1" href="#"><img id="foto1" width="100px" src="<?php echo e(Storage::url($user->imagen)); ?>"></a>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-app bg-gradient-success btn-xs" type="sumbit"><i class="fas fa-save"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Datos</h3>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    <label>Correo</label>
                                    <p><?php echo e(($user->email)); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    <label>Rut</label>
                                    <input type="text" class="form-control" maxlength="30" name="rut" id="rut" onblur="validaRut(this.value);"  required value="<?php echo e(($user->rut)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" maxlength="255" name="name" required  value="<?php echo e(($user->name)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control" maxlength="255" name="apaterno" required value="<?php echo e(($user->apaterno)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control" maxlength="255" name="amaterno"  value="<?php echo e(($user->amaterno)); ?>">
                                </div>
                                </div>


                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha Nacimiento</label>
                                    <input type="date" class="form-control"  name="fechaNacimiento" value="<?php echo e(($user->fechaNacimiento)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control" name="sexo" required>
                                        <option value="M" <?php if($user->sexo=='M'): ?> selected <?php endif; ?> >MASCULINO</option>
                                        <option value="F" <?php if($user->sexo=='F'): ?> selected <?php endif; ?> >FEMENINO</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Estado Civil</label>
                                    <input type="text" class="form-control" maxlength="50"  name="estado_civil" value="<?php echo e(($user->estado_civil)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nacionalidad</label>
                                    <input type="text" class="form-control" maxlength="100"  name="nacionalidad" value="<?php echo e(($user->nacionalidad)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Comuna</label>
                                    <select class="form-control" name="comuna_id" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $comunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comuna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($comuna->id); ?>" <?php if($user->comuna_id==$comuna->id): ?> selected <?php endif; ?> ><?php echo e($comuna->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <input type="text" class="form-control" maxlength="200" name="direccion" value="<?php echo e(($user->direccion)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fono</label>
                                    <input type="text" class="form-control" maxlength="30" name="fono" value="<?php echo e(($user->fono)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Email Personal</label>
                                    <input type="email" class="form-control" maxlength="255" name="emailPersonal" value="<?php echo e(($user->emailPersonal)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Banco</label>
                                    <select class="form-control" name="banco_id">
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($banco->id); ?>" <?php if($user->banco_id==$banco->id): ?> selected <?php endif; ?> ><?php echo e($banco->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo de Cuenta</label>
                                    <select class="form-control" name="tipo_cuenta_id" >
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $tipocuentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipocuenta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipocuenta->id); ?>" <?php if($user->tipo_cuenta_id==$tipocuenta->id): ?> selected <?php endif; ?> ><?php echo e($tipocuenta->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cuenta Bancaria</label>
                                    <input type="text" class="form-control"  maxlength="100" name="nro_cuenta" value="<?php echo e(($user->nro_cuenta)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Contacto emergencia</label>
                                    <input type="text" class="form-control" maxlength="255" name="contacto_nombre" value="<?php echo e(($user->contacto_nombre)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fono Contacto emergencia</label>
                                    <input type="text" class="form-control" maxlength="30" name="contacto_fono" value="<?php echo e(($user->contacto_fono)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Titulo Profesional</label>
                                    <input type="text" class="form-control" maxlength="100" name="titulo_profesional" value="<?php echo e(($user->titulo_profesional)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Institucion de Estudio</label>
                                    <input type="text" class="form-control" maxlength="100" name="institucion_estudio" value="<?php echo e(($user->institucion_estudio)); ?>">
                                </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Datos Laborales</h3>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Empresa</label>
                                        <select class="form-control" name="empresa_id" required>
                                            <option value="">-- Seleccione --</option>
                                            <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($empresa->id); ?>" <?php if($user->empresa_id==$empresa->id): ?> selected <?php endif; ?> ><?php echo e($empresa->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Proyecto</label>
                                        <select class="form-control" name="proyecto_id" >
                                            <option value="">-- Seleccione --</option>
                                            <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($proyecto->id); ?>" <?php if($user->proyecto_id==$proyecto->id): ?> selected <?php endif; ?> ><?php echo e($proyecto->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cargo</label>
                                        <input type="text" class="form-control" maxlength="50" name="funcion" value="<?php echo e(($user->funcion)); ?>">
                                    </div>
                                    </div>

                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha Ingreso</label>
                                    <input type="date" class="form-control" maxlength="10" name="fechaIngreso" value="<?php echo e(($user->fechaIngreso)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="estado_contrato" required>
                                        <option value="1" <?php if($user->estado_contrato=='1'): ?> selected <?php endif; ?> >ACTIVO</option>
                                        <option value="0" <?php if($user->estado_contrato=='0'): ?> selected <?php endif; ?> >NO ACTIVO</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tipo de Contrato</label>
                                    <select class="form-control" name="tipo_contrato_id" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $tipocontratos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipocontrato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipocontrato->id); ?>" <?php if($user->tipo_contrato_id==$tipocontrato->id): ?> selected <?php endif; ?> ><?php echo e($tipocontrato->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sueldo</label>
                                    <input type="number" class="form-control" min="0"  name="sueldo_establecido" value="<?php echo e(($user->sueldo_establecido)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sueldo Base</label>
                                    <input type="number" class="form-control" min="0"  name="sueldo_base" value="<?php echo e(($user->sueldo_base)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Horas Semanales</label>
                                    <input type="number" class="form-control" min="0" name="horas_semanales" value="<?php echo e(($user->horas_semanales)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Colacion</label>
                                    <input type="number" class="form-control" min="0" name="colacion" value="<?php echo e($user->colacion); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Dias Vacaciones</label>
                                    <input type="number" class="form-control" min="0" name="dias_vacaciones" value="<?php echo e($user->dias_vacaciones); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Gratificacion</label>
                                    <input type="text" class="form-control" maxlength="50" name="gratificacion" value="<?php echo e(($user->gratificacion)); ?>">
                                </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Datos Previsionales</h3>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>AFP</label>
                                    <select class="form-control" name="afp_id" >
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $afps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $afp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($afp->id); ?>" <?php if($user->afp_id==$afp->id): ?> selected <?php endif; ?> ><?php echo e($afp->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cotizacion Especial</label>
                                    <input type="text" class="form-control" maxlength="50" name="cotizacion_especial" value="<?php echo e(($user->cotizacion_especial)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tramo Asignado</label>
                                    <input type="text" class="form-control" maxlength="50" name="tramo_asignacion" value="<?php echo e(($user->tramo_asignacion)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jubilado</label>
                                    <select class="form-control" name="jubilado" >
                                        <option value="0" <?php if($user->jubilado=='0'): ?> selected <?php endif; ?> >NO</option>
                                        <option value="1" <?php if($user->jubilado=='1'): ?> selected <?php endif; ?> >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cargas</label>
                                    <input type="number" class="form-control" min="0"  name="cargas" value="<?php echo e(($user->cargas)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seguro Cesantia</label>
                                    <select class="form-control" name="seguro_cesantia" >
                                        <option value="0" <?php if($user->seguro_cesantia=='0'): ?> selected <?php endif; ?> >NO</option>
                                        <option value="1" <?php if($user->seguro_cesantia=='1'): ?> selected <?php endif; ?> >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Seguro Accidentes</label>
                                    <select class="form-control" name="seguro_accidentes"  >
                                        <option value="0" <?php if($user->seguro_accidentes=='0'): ?> selected <?php endif; ?> >NO</option>
                                        <option value="1" <?php if($user->seguro_accidentes=='1'): ?> selected <?php endif; ?> >SI</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Salud</label>
                                    <select class="form-control" name="prevision_id" >
                                        <option value="">-- Seleccione --</option>
                                        <?php $__currentLoopData = $previsiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prevision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($prevision->id); ?>" <?php if($user->prevision_id==$prevision->id): ?> selected <?php endif; ?> ><?php echo e($prevision->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Pactado Isapre</label>
                                    <input type="text" class="form-control"  maxlength="10" name="tipo_pacto_isapre" value="<?php echo e(($user->tipo_pacto_isapre)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Monto Pactado</label>
                                    <input type="number" class="form-control"  min="0" step="0.001" name="monto_pactado" value="<?php echo e(($user->monto_pactado)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Moneda GES</label>
                                    <input type="text" class="form-control"  maxlength="50" name="moneda_ges" value="<?php echo e(($user->moneda_ges)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Monto GES</label>
                                    <input type="number" class="form-control"  min="0" name="monto_ges" value="<?php echo e(($user->monto_ges)); ?>">
                                </div>
                                </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label>Trabajador Joven</label>
                                    <select class="form-control" name="trabajador_joven" >
                                        <option value="0" <?php if($user->trabajador_joven=='0'): ?> selected <?php endif; ?> >NO</option>
                                        <option value="1" <?php if($user->trabajador_joven=='1'): ?> selected <?php endif; ?> >SI</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Habilidades</h3>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" id="select_skills" name="skills[]" multiple="multiple">
                                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($skill->id); ?>" <?php echo e($user->skills->pluck('id')->contains($skill->id) ? 'selected' :''); ?>><?php echo e($skill->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Herramientas</h3>
                                </div>
                                <div class="col-md-12">
                                    <select class="form-control" id="select_herramientas" name="herramientas[]" multiple="multiple">
                                        <?php $__currentLoopData = $herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $herramienta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($herramienta->id); ?>" <?php echo e($user->herramientas->pluck('id')->contains($herramienta->id) ? 'selected' :''); ?>><?php echo e($herramienta->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Permisos</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Grupo</label>
                                            <select class="form-control" name="cargo_id" onchange="getRolesGroup(this.value)">
                                            <option value="">-- Seleccione --</option>
                                            <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cargo->id); ?>" <?php if($user->cargo_id==$cargo->id): ?> selected <?php endif; ?> ><?php echo e($cargo->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php ($anterior=""); ?>
                                <?php ($count=0); ?>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($role->global_group==$anterior): ?>
                                        <li><input type="checkbox" id="<?php echo e($role->id); ?>" name="roles[]" value="<?php echo e($role->id); ?>"  <?php echo e($user->roles->pluck('id')->contains($role->id) ? 'checked' :''); ?> >
                                        <label for="<?php echo e($role->id); ?>"><?php echo e($role->description); ?></label></li>
                                    <?php else: ?>
                                        <?php if($anterior!=""): ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($count==4): ?>
                                            <div class="clearfix"></div>
                                            <?php ($count=0); ?>
                                        <?php endif; ?>
                                        <div class="col-md-3">
                                            <p><strong><?php echo e($role->global_group); ?></strong></p>
                                            <ul class="list-unstyled">
                                                <li><input type="checkbox" id="<?php echo e($role->id); ?>" name="roles[]" value="<?php echo e($role->id); ?>" <?php echo e($user->roles->pluck('id')->contains($role->id) ? 'checked' :''); ?> >
                                                <label for="<?php echo e($role->id); ?>"><?php echo e($role->description); ?></label></li>
                                        <?php ($anterior=$role->global_group); ?>
                                        <?php ($count++); ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>


                            </div>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h3>Notificaciones</h3>
                                </div>
                                <?php ($anterior=""); ?>
                                <?php ($count=0); ?>
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($notification->global_group==$anterior): ?>
                                        <li><input type="checkbox" id="not-<?php echo e($notification->id); ?>" name="notifications[]" value="<?php echo e($notification->id); ?>"  <?php echo e($user->notifyroles->pluck('id')->contains($notification->id) ? 'checked' :''); ?> >
                                        <label for="not-<?php echo e($notification->id); ?>"><?php echo e($notification->description); ?></label></li>
                                    <?php else: ?>
                                        <?php if($anterior!=""): ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($count==4): ?>
                                            <div class="clearfix"></div>
                                            <?php ($count=0); ?>
                                        <?php endif; ?>
                                        <div class="col-md-3">
                                            <p><strong><?php echo e($notification->global_group); ?></strong></p>
                                            <ul class="list-unstyled">
                                                <li><input type="checkbox" id="not-<?php echo e($notification->id); ?>" name="notifications[]" value="<?php echo e($notification->id); ?>" <?php echo e($user->notifyroles->pluck('id')->contains($notification->id) ? 'checked' :''); ?> >
                                                <label for="not-<?php echo e($notification->id); ?>"><?php echo e($notification->description); ?></label></li>
                                        <?php ($anterior=$notification->global_group); ?>
                                        <?php ($count++); ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        adasd
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <form action="<?php echo e(route('users.updatepassword',$user->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <div class="row clearfix">
                                <div class="col-sm-10">
                                    <h3>Cambiar Contraseña</h3>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-app bg-gradient-success btn-xs" type="sumbit"><i class="fas fa-save"></i></button>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" maxlength="255" name="password" required value="<?php echo e((old('password'))); ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Repetir Password</label>
                                        <input type="password" class="form-control" maxlength="255" name="reppassword" required >
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('plugins/select2/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/multi-select/js/jquery.multi-select.js')); ?>"></script>
<script type="text/javascript">
	function getRolesGroup(value){
		if(value==0){
			var input = $( "#formStore input:checkbox" ).prop('checked',false);
		}else{
             $.ajax({
                type: 'GET',
                url: "/cargos/ajax/get/"+value,
                dataType: 'json',
                success: function (data) {
                var input = $( "#formStore input:checkbox" ).prop('checked',false);
                    $.each(data.roles, function(index, element) {
             		 $( "#"+element.id ).prop('checked',true);
                    });
                    $.each(data.notifyroles, function(index, element) {
             		 $( "#not-"+element.id ).prop('checked',true);
                    });
                }
            });
		}
    }



    function validaRut(val){
        if(val.trim()==""||val=='<?php echo e($user->rut); ?>'){
            return;
        }
        url= '<?php echo e(route('users.ajax.valida_rut',':q')); ?>';
        url= url.replace(':q', val);
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (data) {
            },
            error: function (request, status, error) {
                errorDialog(request.responseJSON.message);
                $('#rut').val('<?php echo e($user->rut); ?>');
                $('#rut').focus();
            },
        })
    }

    function readURL(input,img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(img).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

function errorDialog(text){
	Swal.fire({
	title: 'Error!',
	text: text,
	icon: 'error',
    });
}

function usuarioCliente(){
    checkBox = document.getElementById('user_cliente');

    if(checkBox.checked) {
        
        $('#div_user').show();
   
}
else{
    $('#div_user').hide();
}
}

    $(document).ready(function() {
        $('#select_skills').select2();
        $('#select_herramientas').select2();
        $('#cliente_user').multiSelect();
        $('#afoto1').click(function(){
            $('#file-input1').click();
        });
    });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/users/edit.blade.php ENDPATH**/ ?>