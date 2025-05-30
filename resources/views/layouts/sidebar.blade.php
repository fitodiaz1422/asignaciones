  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/logo-min.png')}}" class="img-circle elevation-2" alt="Logo de empresa">
        </div>
        <div class="info">
          <a href="#" class="d-block">FCOM LTDA.</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ route ('home')}}" class="nav-link {{ activeMenu('/') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-home"></i>
                  <p>INICIO</p>
                </a>
              </li>
            @if (auth()->user()->hasRoles('asignaciones.index'))
                <li class="nav-item">
                  <a href="{{ route ('asignaciones.index')}}" class="nav-link {{ activeMenu('asignaciones*') }}">
                    <i class="nav-icon fas fa-business-time"></i>
                    <p>ASIGNACIONES</p>
                  </a>
                </li>
            @endif
            @if (auth()->user()->hasRoles('depositos.index'))
                <li class="nav-item">
                  <a href="{{ route ('depositos.index')}}" class="nav-link {{ activeMenu('depositos*') }}">
                    <i class="nav-icon fas fa-comments-dollar"></i>
                    <p>DEPOSITOS</p>
                  </a>
                </li>
            @endif
            @if (auth()->user()->hasRoles('rendiciones.index'))
                <li class="nav-item">
                  <a href="{{ route ('rendiciones.index')}}" class="nav-link {{ activeMenu('rendiciones*') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <p>RENDICIONES</p>
                  </a>
                </li>
            @endif
            @if (auth()->user()->hasRoles('valida.index'))
                <li class="nav-item">
                  <a href="{{ route ('valida.index')}}" class="nav-link {{ activeMenu('valida*') }}">
                    <i class="fas fa-search-dollar"></i>
                    <p>VALIDAR RENDICIONES</p>
                  </a>
                </li>
            @endif
            @if (auth()->user()->hasRoles('asistencia.index'))
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-universal-access"></i>
                  <p>
                    ASISTENCIA
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route ('asistencia.index')}}" class="nav-link {{ activeMenu('asistencia/asistencia*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>ASISTENCIA</p>
                    </a>
                  </li>
                  @if (auth()->user()->hasRoles('cartaamonestacion.index'))
                <li class="nav-item">
                    <a href="{{ route ('carta_amonestacion.index')}}" class="nav-link {{ activeMenu('asistencia/carta_amonestacion*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>CARTA DE AMONESTACIONES</p>
                    </a>
                  </li>
                  @endif
                  @if (auth()->user()->hasRoles('bono.index'))
                <li class="nav-item">
                    <a href="{{ route ('bono.index')}}" class="nav-link {{ activeMenu('asistencia/bono*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>ADMINISTRACION DE BONOS</p>
                    </a>
                  </li>
                  @endif

</ul>
            @endif
            @if (auth()->user()->hasRoles('cotizaciones.index'))
                <li class="nav-item">
                  <a href="{{ route ('cotizaciones.index')}}" class="nav-link {{ activeMenu('cotizaciones*') }}">
                    <i class="nav-icon fas fa-money-bill-alt"></i>
                    <p>COTIZACIONES</p>
                  </a>
                </li>
            @endif
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-money-bill"></i>
                  <p>
                    CONTABILIDAD
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->hasRoles('contabilidad.exporta'))
                        <li class="nav-item">
                            <a href="{{ route ('contabilidad.exporta')}}" class="nav-link {{ activeMenu('contabilidad/exporta*') }}">
                                <i class="fas fa-ellipsis-h nav-icon"></i>
                                <p>EXPORTACIONES</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    REPORTES
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->hasRoles('reportes.asistencia'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.asistencia')}}" class="nav-link {{ activeMenu('reportes/asistencia*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>ASISTENCIA</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRoles('reportes.atraso'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.atraso')}}" class="nav-link {{ activeMenu('reportes/atraso*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>ATRASO</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRoles('reportes.usuarios'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.usuarios')}}" class="nav-link {{ activeMenu('reportes/usuarios*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>USUARIOS</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRoles('reportes.depositos_proyectos'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.depositos_proyectos')}}" class="nav-link {{ activeMenu('reportes/depositos_proyectos*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>DEPOSITOS PROYECTOS</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRoles('reportes.proyecto_tecnicos'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.proyecto_tecnicos')}}" class="nav-link {{ activeMenu('reportes/proyecto_tecnicos*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>PROYECTOS TECNICOS</p>
                      </a>
                    </li>
                    @endif
                     @if (auth()->user()->hasRoles('reportes.control_coordinacion'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.control_coordinacion')}}" class="nav-link {{ activeMenu('reportes/control_coordinacion*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>CONTROL COORDINACION</p>
                      </a>
                    </li>
                    @endif
                    @if (auth()->user()->hasRoles('reportes.centro_costo'))
                    <li class="nav-item">
                      <a href="{{ route ('reportes.centro_costo')}}" class="nav-link {{ activeMenu('reportes/centro_costo*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>GASTOS POR CENTRO DE COSTO</p>
                      </a>
                    </li>
                    @endif
                </ul>
              </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  CONFIGURACIONES
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if (auth()->user()->hasRoles('users.index'))
                  <li class="nav-item">
                    <a href="{{ route ('users.index')}}" class="nav-link {{ activeMenu('users*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>USUARIOS</p>
                    </a>
                  </li>
                @endif
                @if (auth()->user()->hasRoles('cargos.index'))
                  <li class="nav-item">
                    <a href="{{ route ('cargos.index')}}" class="nav-link {{ activeMenu('cargos*') }}">
                        <i class="fas fa-ellipsis-h nav-icon"></i>
                        <p>CARGOS</p>
                    </a>
                  </li>
                @endif
                @if (auth()->user()->hasRoles('maestros.index'))
                <li class="nav-item">
                  <a href="{{ route ('maestros.index')}}" class="nav-link {{ activeMenu('maestros*') }}">
                    <i class="fas fa-ellipsis-h nav-icon"></i>
                    <p>MAESTROS</p>
                  </a>
                </li>
              @endif
              </ul>
            </li>



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>



    <!-- /.sidebar -->
  </aside>
