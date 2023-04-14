<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="card m-2 border border-dark">
                <div class="card-header">
                    <div class="container-fluid d-flex justify-content-start">
                        <div>
                            <h5>Bitacora</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=Docente" style="font-size:18px;">Bitacora</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <!-- /.card-header -->
                            <div class="card border border-secondary">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-bordered table-hover">
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