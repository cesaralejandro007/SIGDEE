<?php
use config\componentes\configSistema as configSistema;
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include_once 'componentes/panel_nav.php';?>
    <!-- Main Sidebar Container -->
    <?php include_once 'componentes/panel_sidenav.php';?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="card m-2 border border-dark">

        <div class="card-header">
          <div class="container-fluid d-flex justify-content-between flex-wrap">
            <div>
              <h5>Aulas</h5>
            </div>
            <div class="d-flex flex-wrap">
            <a href="?pagina=<?php configSistema::_M01_();?>" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
            <a href="?pagina=<?php configSistema::_M03_();?>" class="px-1" style="font-size:18px;">Aula</a>
            </div>
          </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <div class="card-body px-2 py-1">
          <div class="col-12">
            <div class="d-flex">
              <ul class="nav nav-pills ">
                <li class="nav-item">
                  <a class="nav-link m-1" href="#aulas" id="lista" data-toggle="tab">Aula</a>
                </li>
                <li class="nav-item">
                  <?php

                  if (isset($response[0]["registrar"])) {
                    if ($response[0]["registrar"] == 'true') {?>
                      <a class="nav-link m-1" href="#gestion-aula" id="nuevo" data-toggle="tab">+
                      Registrar Aula</a>
                      <?php 
                    }
                  }
                  ?>
                </li>
                <li class="nav-item d-none">
                  <a class="nav-link " href="#gestion-aula" id="modificar" data-toggle="tab">Registrar
                  Aula</a>
                </li>
              </ul>
            </div>
            <div class="tab-content">
              <?php
              if (isset($response[0]["consultar"])) {
                if ($response[0]["consultar"] == 'true') {?>
                  <div class="tab-pane active" id="aulas">
                    <div class="card border">
                      <div class="table-responsive p-2">
                        <div class="d-flex flex-wrap justify-content-between m-1">
                        </div>
                        <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                          <thead>
                            <tr>
                              <th>Opciones</th>
                              <th>Área</th>
                              <th>Emprendimiento</th>
                              <th>Modulo</th>
                              <th>Aula</th>
                              <th>Docente</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php
                           foreach ($r1 as $valor) {
                             if (isset($valor[1])) {?>
                               <tr>   
                                <td class="project-actions text-left" style="width:25%;">
                                  <div class="d-flex">
                                    <?php
                                    if (isset($response[0]["modificar"])) {
                                      if ($response[0]["modificar"] == 'true') {?>
                                        <button class="btn mr-2 text-white" style="background:#E67E22;color:white" data-toggle="modal"data-toggle="tooltip" data-placement="top" title="Editar"
                                        onclick="edita_aula(<?=$valor[4];?>, <?=$valor[8];?>);" name="editar"
                                        id="editar" data-target="#editar-area"><i
                                        class="fas fa-edit"></i></button>
                                      <?php }}?>
                                      <?php
                                      if (isset($response[0]["eliminar"])) {
                                        if ($response[0]["eliminar"] == 'true') {?>

                                          <label class="mycheckbox d-flex justify-content-center align-items-center mx-1">
                                            <input type="checkbox" id="desh<?=$valor[4];?>" onclick="activarod(<?=$valor[4];?>);">
                                            <span>
                                              <i class="fas fa-check on"></i>
                                              <i class="fas fa-times off"></i>
                                            </span>
                                          </label>
                                          <h5 id="labelad<?=$valor[4];?>" class="d-flex justify-content-center align-items-center">Desactivado</h5>
                                        <?php }}?>
                                      </div>
                                    </td>

                                    <td class="project-actions text-left">
                                      <?php echo $valor[1]; ?></td>


                                      <td class="project-actions text-left">
                                        <?php echo $valor[3]; ?></td>

                                        <td class="project-actions text-left">
                                          <?php echo $valor[7]; ?></td>


                                          <td class="project-actions text-left">
                                            <?php echo $valor[5]; ?></td>

                                            <td class="project-actions text-left">
                                              <?php echo $valor[9]; ?></td>

                                            </tr>



                                          <?php }}?>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th>Opciones</th>
                                            <th>Área</th>
                                            <th>Emprendimiento</th>
                                            <th>Modulo</th>
                                            <th>Aula</th>
                                            <th>Docente</th>
                                          </tr>
                                        </tfoot>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              <?php }else{
                                echo '<div class="alert alert-danger" role="alert">No tiene permisos para consultar este modulo.</div>';
                            }}?>
                              <div class="tab-pane" id="gestion-aula" style="padding-top: 3%;">
                                <form action="" id="fi" method="post">
                                  <input type="hidden" name="accion" id="accion" value="registrar" />
                                  <input type="hidden" name="id" id="id" />
                                  <input type="hidden" name="id_aula_docente" id="id_aula_docente" />
                                  <div class="form-group row selectores" id="selectores">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Área de Emprendimiento</label>
                                        <select class="form-control select2bs4" id="area" name="area"
                                        style="width: 100%;">
                                        <option disabled selected value="0">Seleccione</option>
                                      </select>
                                      <span id="sarea"></span>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Emprendimiento</label>
                                      <select class="form-control select2bs4" id="tipo" name="tipo"
                                      style="width: 100%;">
                                      <option disabled selected value="0">Seleccione</option>
                                    </select>
                                    <span id="semprendimiento"></span>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Módulo</label>
                                    <select class="form-control select2bs4" id="modulo" name="modulo"
                                    style="width: 100%;">
                                    <option disabled selected value="0">Seleccione</option>
                                  </select>
                                  <span id="smodulo"></span>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-6">
                                <label for="message-text" class="col-form-label"
                                for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control">
                                <span id="snombre"></span>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Docente</label>
                                  <select class="form-control select2bs4" id="docente1" name="docente"
                                  style="width: 100%;">
                                  <option disabled selected value="0">Seleccione</option>

                                </select>
                                <span id="sdocente1"></span>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group">
                            <select class="duallistbox" multiple="multiple" id="estudiantes"
                            name="estudiantes">

                          </select>
                          <span id="sestudiantes"></span>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <input class="btn btn-default" type="reset" value="Limpiar Campos" />
                          <button type="button" id="enviar" class="btn btn-primary">Registrar</button>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include_once 'componentes/footer.php';?>
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
      <script src="plugins/select2/js/select2.full.min.js"></script>
      <script src="content/js/aula.js"></script>
      <!-- Page specific script -->
      <script>
        $(function() {
        //Initialize Select2 Elements
          $('.select2').select2()

        //Initialize Select2 Elements
          $('.select2bs4').select2({
            theme: 'bootstrap4'
          })
        });
      </script>
    </body>

    </html>