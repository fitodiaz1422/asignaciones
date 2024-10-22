  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>

    </ul>


<ul class="navbar-nav ml-auto">
       <!-- Notifications Dropdown Menu -->
       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge count_notifications"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <span class="dropdown-item dropdown-header"><span class="count_notifications"></span> Notificaciones</span>
          <div id="notifiDetails"></div>
          <div class='dropdown-divider'></div>
          <div class="row clearfix">
                &nbsp;&nbsp;&nbsp;
              <div class="col-xs-6" style="width:130px">
                  <a href="<?php echo e(route('notifications.index')); ?>" class="dropdown-item dropdown-footer">Ver todas</a>
                </div>
                <div class="col-xs-6">
                  <a href='javascript:setUnreadNotifications();' class='bg-lightblue  dropdown-item dropdown-footer'>Marcar como leidas</a>
              </div>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="<?php echo e(Storage::url(auth()->user()->imagen)); ?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?php echo e(auth()->user()->name." ".auth()->user()->apaterno); ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="<?php echo e(Storage::url(auth()->user()->imagen)); ?>" class="img-circle elevation-2" alt="User Image">

            <p>
              <?php echo e(auth()->user()->name." ".auth()->user()->apaterno); ?>

              <small>Fecha de Ingreso <?php echo e(DBtoFecha(auth()->user()->fechaIngreso,"/",true)); ?></small>
            </p>
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="<?php echo e(route('users.perfil')); ?>" class="btn btn-default btn-flat">Perfil</a>
            <a onclick="logout.submit();" href="#" class="btn btn-default btn-flat float-right"><?php echo e(__('Logout')); ?></a>
          </li>
        </ul>
      </li>

    </ul>
    <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout">
    <?php echo e(csrf_field()); ?>

    </form>
  </nav>
  <!-- /.navbar -->
<?php /**PATH /app/resources/views/layouts/nav.blade.php ENDPATH**/ ?>