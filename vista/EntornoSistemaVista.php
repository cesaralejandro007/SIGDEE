<!DOCTYPE html>
<html lang="es">
<?php include_once('componentes/head.php'); ?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include_once('componentes/panel_nav.php'); ?>
    <!-- Main Sidebar Container -->
    <?php include_once('componentes/panel_sidenav.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      
        <div class="card m-2 border border-secondary">
        <div class="card-header pb-1 px-1">
          <div class="container-fluid d-flex justify-content-between">
            <div>
              <h5>Modulos del Sistema</h5>
            </div>
            <div class="">
            <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
            <a href="?pagina=EntornoSistema" class="px-1" style="font-size:18px;">Entornos de Sistema</a>
            </div>
          </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <div class="card-body px-2 py-1">
          <div class="row">
            <div class="col-12">
              <div class="d-flex">
                <!-- <button class="btn btn-primary m-1" id="nuevo">+ Registrar Modulo</button> -->
              </div>
              <!-- /.card-header -->
              <div class="card border">
                <div class="table-responsive-xl p-2">
                  <div class="d-flex flex-wrap justify-content-between m-1">
                  </div>
                  <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                    <thead>
                      <tr>
                        <th>Nombre</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach ($r1 as $valor) {
                        if (isset($valor["nombre"])) { ?>
                          <tr>
                            <td><?php echo $valor['nombre']; ?></td>                            
                          </tr>
                        <?php }} ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th>Nombre</th>                        
                      </tr>
                    </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        <!-- /.content -->
      </div>
        <!-- /.content -->
      </div>
      <!-- /.modal Registrar -->
      <div class="modal fade" id="gestionar-modulos">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="titulo"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="post" id="f">
              <input type="hidden" name="accion" id="accion"/>
              <input type="hidden" name="id" id="id"/>
                <div class="form-group row">
                  <div class="col-md-8">
                   <label class="col-form-label" for="nombre">Nombre:</label>
                   <input type="text" name="nombre" id="nombre" class="form-control">
                   <span id="snombre"></span>
                 </div>
               </div>
               <div class="modal-footer justify-content-between">
                <input class="btn btn-default" type="reset" value="Limpiar Campos"/>
                <button type="button" id="enviar" class="btn btn-primary"></button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->
  </div>
  </div>
  
  <!-- /.content-wrapper -->
  <?php include_once('componentes/footer.php'); ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <script src="content/js/EntornoSistema.js"></script>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Validaciones -->
<!-- DataTables  & Plugins -->

<!-- Page specific script -->
</body>
</html>
