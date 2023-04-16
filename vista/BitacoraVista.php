<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">

<body class="hold-transition sidebar-mini">
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
                        <div class="">
                        <a href="?pagina=principal" style="font-size:18px;">Inicio</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
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

    <script src="content/js/bitacora.js"></script>
</body>

</html>