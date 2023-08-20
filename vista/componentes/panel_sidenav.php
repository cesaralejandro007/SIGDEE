<?php
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\PermisosModelo as Permiso;
use modelo\AulaModelo as Aula;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\EmprendimientoModelo as Emprendimiento;
use config\componentes\configSistema as configSistema;

$aula = new Aula;
$auladocente = new AulaDocente;
$aulaestudiante = new AulaEstudiante;
$permiso = new Permiso;
$area_emprendimiento = new AreaEmprendimiento;
$emprendimiento = new Emprendimiento;
$docente_areas = $auladocente->docente_areas($_SESSION['usuario']['cedula']);
$listar_aulaestudiante = $aulaestudiante->estudiante_areas($_SESSION['usuario']['cedula']);
$listar_docente_estudiante = $aulaestudiante->listardocente($_SESSION['usuario']['id']);
$docente_estudiante_aula = json_encode( $listar_docente_estudiante);
$listar_aula = $aula->listar();

$response1 = $permiso->mostrarentronos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"]);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link p-0 m-1">
    <img src="content/imagenes/logo.png" alt="AdminLTE Logo" style="display: flex;
    width: 100%;">
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-2 p-0 d-flex justify-content-center">
      <div class="info">
        <p class="text-light fw-bold pr-1 "><?php echo $_SESSION['usuario']['tipo_usuario']?></p>
      </div>
    </div>
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-4">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item menu-open">
          <a href="?pagina=<?php configSistema::_M01_();?>" class="nav-link active" style="background:#0C72C4">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Inicio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="?pagina=Aula" class="nav-link">
            <i class="fa fa-solid fa-school nav-icon"></i>
            <p>Diplomados/Cursos <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($_SESSION['usuario']['tipo_usuario'] == 'Super Usuario' || $_SESSION['usuario']['tipo_usuario'] == 'Administrador') 
            { 
              foreach ($area_emprendimiento->listar() as $area) 
              { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p><?php echo $area['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php 
                            $emprendimientos = $emprendimiento->listarEmprendimientos($area['id']);
                            foreach($emprendimientos as $key_emprendimiento){ ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p><?php echo $key_emprendimiento['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php
                                        $listar_aulas = $aula->listarAulasMenu($area['id'], $key_emprendimiento['id']);
                                        foreach($listar_aulas as $key_aulas){ ?>
                                            <li class="nav-item">
                                            <a href="?pagina=<?php configSistema::_MAULAS_($key_aulas['id']);?>" class="nav-link">
                                                    <i class="far fa-circle nav-icon" style="color: #343a40 !important;"></i>
                                                    <p><?php echo $key_aulas['nombre']; ?></p>
                                                </a>
                                            </li>
                                        <?php } ?>        
                                    </ul>
                                </li>
                        <?php } ?>        
                    </ul>
                </li>
                <?php  }
            } else  if ($_SESSION['usuario']['tipo_usuario'] == 'Docente' && $docente_areas) {
              foreach ($docente_areas as $area) 
              { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p><?php echo $area['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php 
                            $emprendimientos = $auladocente->docente_emprendimientos($_SESSION['usuario']['cedula'], $area['id']);
                            foreach($emprendimientos as $key_emprendimiento){ ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p><?php echo $key_emprendimiento['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php
                                        $listar_aulas = $auladocente->listar_modulos($_SESSION['usuario']['cedula'], $area['id'], $key_emprendimiento['id']);
                                        foreach($listar_aulas as $key_aulas){ ?>
                                            <li class="nav-item">
                                              <a href="?pagina=<?php configSistema::_MAULAS_($key_aulas['id']);?>" class="nav-link">
                                                <i class="far fa-circle nav-icon" style="color: #343a40 !important;"></i>
                                                <p><?php echo $key_aulas['nombre']; ?></p>
                                              </a>
                                            </li>
                                        <?php } ?>        
                                    </ul>
                                </li>
                        <?php } ?>        
                    </ul>
                </li>
                <?php  }
            } else if ($_SESSION['usuario']['tipo_usuario'] == 'Estudiante' && $listar_aulaestudiante) {
              foreach ($listar_aulaestudiante as $area) 
              { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p><?php echo $area['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php 
                            $emprendimientos = $aulaestudiante->estudiante_emprendimientos($_SESSION['usuario']['cedula'], $area['id']);
                            foreach($emprendimientos as $key_emprendimiento){ ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-ellipsis-h"></i>
                                        <p><?php echo $key_emprendimiento['nombre']; ?> <i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php
                                        $listar_aulas = $aulaestudiante->listar_modulos($_SESSION['usuario']['cedula'], $area['id'], $key_emprendimiento['id']);
                                        foreach($listar_aulas as $key_aulas){ ?>
                                            <li class="nav-item">
                                              <a href="?pagina=<?php configSistema::_MAULAS_($key_aulas['id']);?>" class="nav-link">
                                                <i class="far fa-circle nav-icon" style="color: #343a40 !important;"></i>
                                                <p><?php echo $key_aulas['nombre']; ?></p>
                                              </a>
                                            </li>
                                        <?php } ?>        
                                    </ul>
                                </li>
                        <?php } ?>        
                    </ul>
                </li>
                <?php  }
            } else {?>
              <li></li>
              <?php
            }?>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Registro
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Aula') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M03_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aulas</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Aspirantes') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M04_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Aspirantes</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Censo') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M05_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Censos</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Contenidos') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M06_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contenidos</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Evaluaciones') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M07_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Evaluaciones</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Estudiantes') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M08_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Estudiante</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Docentes') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M09_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Docente</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Area de Emprendimiento') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M10_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Area de Emprendimiento</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Emprendimiento') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M11_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Emprendimiento</p>
                </a>
              </li>
            <?php }
            $confirm = 0;
            for ($i = 0; $i < count($response1); $i++) {
              if ($response1[$i]['nombreentorno'] == 'Modulo') {
                $confirm = true;
              }
            }
            if ($confirm) {?>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M12_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modulo</p>
                </a>
              </li>
            <?php }?>
          </ul>
        </li>

        <?php if ($_SESSION['usuario']['tipo_usuario'] == 'Super Usuario') {?>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M13_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reportes Estadisticos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M14_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporte de Estudiantes Por Emprendimiento</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M21_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporte de Estudiantes Por Ubicación</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shield-alt"></i>
              <p>
                Seguridad
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M15_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M16_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permisos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M17_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bitacora</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M18_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Respaldo BD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?pagina=<?php configSistema::_M19_();?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Entornos del Sistema</p>
                </a>
              </li>
            </ul>
          </li>
        <?php }?>
        <?php 
        $confirm = 0;
        for ($i = 0; $i < count($response1); $i++) {
          if ($response1[$i]['nombreentorno'] == 'Chat Virtual') {
            $confirm = true;
          }
        }
        if ($confirm) {?>
          <li class="nav-item">
            <a href="?pagina=<?php configSistema::_M02_();?>" class="nav-link">
              <i class="nav-icon fas fa-comments"></i>
              <p>Chat Virtual</p>
            </a>
          </li>
        <?php }?>  

      </li>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>