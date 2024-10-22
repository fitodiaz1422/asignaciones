

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
            <li class="breadcrumb-item">Maestros</a></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#tab_1" role="tab"  aria-selected="true">Empresas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_2" role="tab">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_3" role="tab">Proyectos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_4" role="tab">Asistencia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_6" role="tab">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_10" role="tab">Herramientas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_7" role="tab">Afps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_8" role="tab">Salud</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_9" role="tab">Bancos</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_11" role="tab">Centro de Costo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#tab_12" role="tab">Motivos Actividad</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Empresas</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_empresa" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_empresas" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>id</th>
                                    <th>Nombre</th>
                                    <th>Logo</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($empresa->id); ?></td>
                                        <td><?php echo e($empresa->nombre); ?></td>
                                        <?php if($empresa->logo): ?>
                                            <td><a href="<?php echo e(Storage::url($empresa->logo)); ?>" target="_blank"><img src='<?php echo e(Storage::url($empresa->logo)); ?>' width="100px"/></a></td>
                                        <?php else: ?>
                                            <td></td>
                                        <?php endif; ?>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editEmpresa('<?php echo e($empresa->id); ?>','<?php echo e($empresa->nombre); ?>','<?php echo e($empresa->logo); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Clientes</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_cliente" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_clientes" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Rut</th>
                                    <th>Razon Social</th>
                                    <th>Nombre</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($cliente->id); ?></td>
                                        <td><?php echo e($cliente->rut); ?></td>
                                        <td><?php echo e($cliente->razon_social); ?></td>
                                        <td><?php echo e($cliente->nombre); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editCliente('<?php echo e($cliente->id); ?>','<?php echo e($cliente->rut); ?>','<?php echo e($cliente->razon_social); ?>','<?php echo e($cliente->nombre); ?>')"   type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Proyectos</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_proyecto" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_proyectos" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>id</th>
                                    <th>Nombre</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($proyecto->id); ?></td>
                                        <td><?php echo e($proyecto->nombre); ?></td>
                                        <td><?php echo e(($proyecto->Cliente->nombre) ?? ''); ?></td>
                                        <td><?php echo e(($proyecto->estado)); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editProyecto('<?php echo e($proyecto->id); ?>','<?php echo e($proyecto->nombre); ?>','<?php echo e(($proyecto->Cliente->id)??''); ?>','<?php echo e($proyecto->estado); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_4">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>ASISTENCIA</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_asistencia" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_asistencia" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th width="10px">Color</th>
                                    <th width="40px"></th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tipo_asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($asistencia->tipo); ?></td>
                                        <td><?php echo e($asistencia->nombre); ?></td>
                                        <td><?php echo e($asistencia->estado); ?></td>
                                        <td style="background-color:#<?php echo e(($asistencia->color)); ?>">#<?php echo e(($asistencia->color)); ?></td>
                                        <td></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editAsistencia('<?php echo e($asistencia->tipo); ?>','<?php echo e($asistencia->nombre); ?>','#<?php echo e($asistencia->color); ?>','<?php echo e($asistencia->estado); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_10">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>HERRAMIENTAS</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_herramienta" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_herramientas" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $herramienta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($herramienta->id); ?></td>
                                        <td><?php echo e($herramienta->nombre); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editHerramienta('<?php echo e($herramienta->id); ?>','<?php echo e($herramienta->nombre); ?>')"   type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_6">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>SKILLS</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_skill" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_skills" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($skill->id); ?></td>
                                        <td><?php echo e($skill->nombre); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm "  onclick="editSkill('<?php echo e($skill->id); ?>','<?php echo e($skill->nombre); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_7">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>AFPS</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_afp" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_afps" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $afps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $afp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($afp->id); ?></td>
                                        <td><?php echo e($afp->nombre); ?></td>
                                        <td><?php echo e($afp->valor); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm "onclick="editAfp('<?php echo e($afp->id); ?>','<?php echo e($afp->nombre); ?>','<?php echo e($afp->valor); ?>')"   type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_8">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Salud</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_salud" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_salud" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $previsiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prevision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($prevision->id); ?></td>
                                        <td><?php echo e($prevision->nombre); ?></td>
                                        <td><?php echo e($prevision->valor); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editSalud('<?php echo e($prevision->id); ?>','<?php echo e($prevision->nombre); ?>','<?php echo e($prevision->valor); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                 <div class="tab-pane" id="tab_11">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Centro de Costo</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_costo" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_afps" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>estado</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $costo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($costo->id); ?></td>
                                        <td><?php echo e($costo->codigo); ?></td>
                                        <td><?php echo e($costo->descripcion); ?></td>
                                        <td><?php echo e($costo->estado); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm "onclick="editCcosto('<?php echo e($costo->id); ?>','<?php echo e($costo->codigo); ?>','<?php echo e($costo->descripcion); ?>','<?php echo e($costo->estado); ?>')"   type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_12">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Motivos Actividad</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_motivo" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_motivo" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>estado</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $motivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($motivo->id); ?></td>
                                        <td><?php echo e($motivo->name); ?></td>
                                        <td><?php echo e($motivo->tipo); ?></td>
                                        <td><?php echo e($motivo->estado); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm "onclick="editMotivo('<?php echo e($motivo->id); ?>','<?php echo e($motivo->name); ?>','<?php echo e($motivo->tipo); ?>','<?php echo e($motivo->estado); ?>')"   type="button"><i class="fas fa-edit "></i></button></td>
                                    
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="tab_9">
                    <div class="row">
                        <div class="col-sm-6 col-lg-10">
                            <h1>Bancos</h1>
                        </div>
                        <div class="col-sm-3 col-lg-2">
                            <button class="btn btn-app bg-gradient-success btn-xs" data-toggle="modal" data-target="#modal_banco" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover table-sm dt-responsive nowrap compact" id="table_bancos" style="width:100%">
                            <thead  class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th width="10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bancos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td><?php echo e($banco->id); ?></td>
                                        <td><?php echo e($banco->nombre); ?></td>
                                        <td><button class="btn btn-block bg-gradient-success btn-sm " onclick="editBanco('<?php echo e($banco->id); ?>','<?php echo e($banco->nombre); ?>')"  type="button"><i class="fas fa-edit "></i></button></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Modals Empresa-->
<div class="modal fade" id="modal_empresa" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.empresa.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crea Empresa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="100" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input name="imagen"  accept="image/*" type="file" class="btn btn-block bg-gradient-success" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!-- Modals Clientes-->
<div class="modal fade" id="modal_cliente" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.cliente.store')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crea Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rut</label>
                        <input type="text" class="form-control" maxlength="30" name="rut" required>
                    </div>
                    <div class="form-group">
                        <label>Razon Social</label>
                        <input type="text" class="form-control" maxlength="200" name="razon_social" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="200" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!-- Modals Proyecto-->
  <div class="modal fade" id="modal_proyecto" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.proyecto.store')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crea Proyecto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="255" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <select class="form-control" name="cliente_id" required>
                            <option value="">-- Seleccione --</option>
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

    <!-- Modals Asistencia-->
    <div class="modal fade" id="modal_asistencia" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.asistencia.store')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crea Asistencia</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="200" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <div class="input-group my-colorpicker2">
                              <input type="text" class="form-control" name="color" required>
                              <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                              </div>
                            </div>
                            <!-- /.input group -->
                          </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

  <!-- Modals Skills-->
  <div class="modal fade" id="modal_skill" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.skill.store')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crea Skills</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="100" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

    <!-- Modals AFP-->
    <div class="modal fade" id="modal_afp" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.afp.store')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crea Afp</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="100" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" step="0.001" class="form-control" name="valor">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
      
       <!-- Modals costo-->
    <div class="modal fade" id="modal_costo" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.costo.store')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crea Costo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Codigo</label>
                            <input type="text" class="form-control" maxlength="13" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text"  class="form-control" name="descripcion">
                        </div>
                         <div class="form-group">
                            <label>estado</label>
                             <select class="form-control" name="estado"  required>
                            <option value="ACTIVO">ACTIVO</option>
                            
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            
                        </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

       <!-- Modals motivo-->
    <div class="modal fade" id="modal_motivo" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.motivo.store')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crea Motivo Actividad</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="252" name="nombre_crear_motivo" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                             <select class="form-control" name="tipo_crear_motivo"  required>
                            <option value="ELIMINAR">ELIMINAR</option>
                            
                                <option value="MODIFICAR">MODIFICAR</option>
                            
                        </select>
                        </div>
                         <div class="form-group">
                            <label>estado</label>
                             <select class="form-control" name="estado_crear_motivo"  required>
                            <option value="ACTIVO">ACTIVO</option>
                            
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            
                        </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

        <!-- Modals Prevision-->
    <div class="modal fade" id="modal_salud" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.prevision.store')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crea Salud</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="100" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" step="0.001" class="form-control" name="valor">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

        <!-- Modals Banco-->
        <div class="modal fade" id="modal_banco" >
            <div class="modal-dialog">
                <form action="<?php echo e(route('maestros.banco.store')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Crea Banco</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" maxlength="100" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

          </div>
        <!-- Modals Herramienta-->
        <div class="modal fade" id="modal_herramienta" >
            <div class="modal-dialog">
                <form action="<?php echo e(route('maestros.herramienta.store')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Crea Herramienta</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" maxlength="100" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>



<!-- Modals Empresa-->
<div class="modal fade" id="modal_edit_empresa" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.empresa.update')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edita Empresa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="100" id="empresa_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <input name="imagen"  accept="image/*" type="file" class="btn btn-block bg-gradient-success" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name='id' id="empresa_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!-- Modals Clientes-->
<div class="modal fade" id="modal_edit_cliente" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.cliente.update')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edita Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rut</label>
                        <input type="text" class="form-control" maxlength="30" id="cliente_rut" name="rut" required>
                    </div>
                    <div class="form-group">
                        <label>Razon Social</label>
                        <input type="text" class="form-control" maxlength="200" id="cliente_razon_social" name="razon_social" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="200" id="cliente_nombre" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name='id' id="cliente_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!-- Modals Proyecto-->
  <div class="modal fade" id="modal_edit_proyecto" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.proyecto.update')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edita Proyecto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="255" id="proyecto_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <select class="form-control" name="cliente_id" id="proyecto_cliente_id" required>
                            <option value="">-- Seleccione --</option>
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="estado" id="estado" required>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="DESACTIVADO">DESACTIVADO</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name='id' id="proyecto_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

    <!-- Modals Asistencia-->
    <div class="modal fade" id="modal_edit_asistencia" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.asistencia.update')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edita Asistencia</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="200" id="asistencia_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <div class="input-group my-colorpicker2">
                              <input type="text" class="form-control" name="color" id="asistencia_color" required>
                              <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"></i></span>
                              </div>
                            </div>
                            <!-- /.input group -->
                          </div>

                          <div class="form-group">
                        <label>Estado</label>
                        <select class="form-control" name="estado" id="estado_asistencia" required>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="DESACTIVADO">DESACTIVADO</option>
                        </select>
                    </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name='tipo' id="asistencia_tipo">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

  <!-- Modals Skills-->
  <div class="modal fade" id="modal_edit_skill" >
    <div class="modal-dialog">
        <form action="<?php echo e(route('maestros.skill.update')); ?>" method="post" >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edita Skills</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" maxlength="100" id="skill_nombre" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" name='id' id="skill_id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
  </div>

    <!-- Modals AFP-->
    <div class="modal fade" id="modal_edit_afp" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.afp.update')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edita Afp</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="100" id="afp_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" step="0.001" class="form-control" id="afp_valor" name="valor">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name='id' id="afp_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
      
      <!-- Modals Costo-->
    <div class="modal fade" id="modal_edit_costo" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.costo.update')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edita Costo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>codigo</label>
                            <input type="text" class="form-control" maxlength="13" id="costo_codigo" name="codigo" required>
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text"  class="form-control" id="costo_descripcion" name="descripcion">
                        </div>
                        <div class="form-group">
                            <label>estado</label>
                             <select class="form-control" name="estado" id="costo_estado" required>
                            <option value="ACTIVO">ACTIVO</option>
                            
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            
                        </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name='id' id="costo_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

       <!-- Modals Costo-->
    <div class="modal fade" id="modal_edit_motivo" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.motivo.update')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edita Motivo Actividad</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="252" id="motivo_nombre" name="motivo_nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo</label>
                             <select class="form-control" name="motivo_tipo" id="motivo_tipo" required>
                            <option value="ELIMINAR">ELIMINAR</option>
                            
                                <option value="MODIFICAR">MODIFICAR</option>
                            
                        </select>
                        </div>
                        <div class="form-group">
                            <label>estado</label>
                             <select class="form-control" name="motivo_estado" id="motivo_estado" required>
                            <option value="ACTIVO">ACTIVO</option>
                            
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            
                        </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name='motivo_id' id="motivo_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

        <!-- Modals Prevision-->
    <div class="modal fade" id="modal_edit_salud" >
        <div class="modal-dialog">
            <form action="<?php echo e(route('maestros.prevision.update')); ?>" method="post" >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edita Salud</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" maxlength="100" id="salud_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" step="0.001" class="form-control" id="salud_valor"  name="valor">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <input type="hidden" name='id' id="salud_id">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
      </div>

        <!-- Modals Banco-->
        <div class="modal fade" id="modal_edit_banco" >
            <div class="modal-dialog">
                <form action="<?php echo e(route('maestros.banco.update')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edita Banco</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" maxlength="100" id="banco_nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name='id' id="banco_id">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>

          </div>
        <!-- Modals Herramienta-->
        <div class="modal fade" id="modal_edit_herramienta" >
            <div class="modal-dialog">
                <form action="<?php echo e(route('maestros.herramienta.update')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edita Herramienta</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" maxlength="100" id="herramienta_nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input type="hidden" name='id' id="herramienta_id">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<!-- bootstrap color picker -->
<script src="<?php echo e(asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')); ?>"></script>
<script>
    $('.my-colorpicker2').colorpicker()
    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    function editEmpresa(id,nombre,logo){
        $('#empresa_id').val(id);
        $('#empresa_nombre').val(nombre);
        $('#empresa_logo').val(logo);
        $('#modal_edit_empresa').modal('show')
    }

    function editCliente(id,rut,razon_social,nombre){
        $('#cliente_id').val(id);
        $('#cliente_rut').val(rut);
        $('#cliente_razon_social').val(razon_social);
        $('#cliente_nombre').val(nombre);
        $('#modal_edit_cliente').modal('show')
    }

    function editProyecto(id,nombre,cliente_id, estado){
        $('#proyecto_id').val(id);
        $('#proyecto_nombre').val(nombre);
        $('#proyecto_cliente_id').val(cliente_id);
        $('#estado').val(estado);
        $('#modal_edit_proyecto').modal('show')
    }

    function editAsistencia(tipo,nombre,color,estado){
        $('#asistencia_tipo').val(tipo);
        $('#asistencia_nombre').val(nombre);
        $('#asistencia_color').val(color);
        $('.my-colorpicker2 .fa-square').css('color', color);
        $('#estado_asistencia').val(estado);
        $('#modal_edit_asistencia').modal('show')
    }

    function editSkill(id,nombre){
        $('#skill_id').val(id);
        $('#skill_nombre').val(nombre);
        $('#modal_edit_skill').modal('show')
    }

    function editHerramienta(id,nombre){
        $('#herramienta_id').val(id);
        $('#herramienta_nombre').val(nombre);
        $('#modal_edit_herramienta').modal('show')
    }

    function editAfp(id,nombre,valor){
        $('#afp_id').val(id);
        $('#afp_nombre').val(nombre);
        $('#afp_valor').val(valor);
        $('#modal_edit_afp').modal('show')
    }
    
     function editCcosto(id,codigo,descripcion,estado){
        $('#costo_id').val(id);
        $('#costo_codigo').val(codigo);
        $('#costo_descripcion').val(descripcion);
        $('#costo_estado').val(estado);
        $('#modal_edit_costo').modal('show')
    }
    function editMotivo(id,codigo,descripcion,estado){
        $('#motivo_id').val(id);
        $('#motivo_nombre').val(codigo);
        $('#motivo_tipo').val(descripcion);
        $('#motivo_estado').val(estado);
        $('#modal_edit_motivo').modal('show')
    }

    

    function editSalud(id,nombre,valor){
        $('#salud_id').val(id);
        $('#salud_nombre').val(nombre);
        $('#salud_valor').val(valor);
        $('#modal_edit_salud').modal('show')
    }

    function editBanco(id,nombre){
        $('#banco_id').val(id);
        $('#banco_nombre').val(nombre);
        $('#modal_edit_banco').modal('show')
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /app/resources/views/maestros/index.blade.php ENDPATH**/ ?>