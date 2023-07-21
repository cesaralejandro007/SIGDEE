<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<body class="hold-transition sidebar-mini">
<style>
  .alerta-grande .swal2-popup {
    width: 80%;
    height: 80%;
  }
  #swal2-html-container{
    overflow-x: hidden;
  }
</style>
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="card m-2 border border-secondary">
                <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between">
                        <div>
                            <h5>Bitacora</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=Bitacora" class="px-1" style="font-size:18px;">Bitacora</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header" style="background:#AEB6BF;">
                            <h3 class="card-title font-weight-bold">Criterio de busqueda y mantenimiento de la bitacora</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus" style="color:black"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="row d-flex justify-content-center">
                                            <div class="col-md-4 px-1">
                                                <label class="col-form-label" for="nombre">Desde:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="text" id="fechad" class="form-control datetimepicker-input" data-target="#fechad" />
                                                    <div class="input-group-append" data-target="#fechad"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 px-1">
                                                <label class="col-form-label" for="nombre">Hasta:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="text" id="fechah"
                                                        class="form-control datetimepicker-input" data-target="#fechah" />
                                                    <div class="input-group-append" data-target="#fechah"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 px-1 d-flex align-items-end justify-content-end">
                                                <button class="btn btn-outline-primary mx-1" id="button-addon" type="button">Buscar</button>
                                                <button class="btn btn-outline-danger" id="Limpiar-bitacora" type="button">Limpiar</button>
                                            </div>
                                            <span class="text-danger" id="val_fecha"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- /.card-header -->
                            <div class="card border">
                                <div class="table-responsive-xl px-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Rol</th>
                                                <th>Entorno del Sistema</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {?>
                                            <tr>
                                                <td class="project-actions text-left" style="width:20%;">
                                                    <?php echo $valor['fecha']; ?></td>
                                                <td class="project-actions text-left" style="width:20%;">
                                                    <?php echo $valor['usuario']; ?></td>
                                                <td class="project-actions text-left" style="width:20%;">
                                                    <?php echo $valor['rol']; ?></td>
                                                <td class="project-actions text-left" style="width:20%;">
                                                    <?php echo $valor['entorno']; ?></td>
                                                <td class="project-actions text-left" style="width:20%;">
                                                    <?php echo $valor['accion']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Usuario</th>
                                                <th>Rol</th>
                                                <th>Entorno del Sistema</th>
                                                <th>Accion</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        </div>
        <div class="modal fade show" id="consulta-bitacora">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo">Consulta de bitacora</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" >
                        <div class="table-responsive-lg" id="info_modal">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
        </div>

        <!-- /.modal -->

        <!-- /.modal Editar -->

        <!-- /.content-wrapper -->
        <?php include_once 'componentes/footer.php';?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- Bootstrap 4 -->

    <!-- DataTables  & Plugins -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/locale/es.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="content/js/bitacora.js"></script>
    <script>
    $(function() {

        //Date and time picker
        $('#fechad').datetimepicker({
            locale: 'es',
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#fechah').datetimepicker({
            locale: 'es',
            icons: {
                time: 'far fa-clock'
            }
        });

    })
    </script>

</body>

</html>