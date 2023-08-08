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
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                    <input type="hidden" name="cedula_usuario" id="cedula_usuario" value="<?php echo $_SESSION['usuario']['cedula'] ?>" />
                        <div>
                            <h5>Respaldo de la Base de datos</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=Respaldobd" class="px-1" style="font-size:18px;">Respaldo BD</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                    <div class="row">
                        <div class="col-12">
                            
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="row d-flex justify-content-center">
                                                <button class="btn btn-outline-primary mx-1" id="verificar_password" type="button">Respaldar bases de datos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <!-- /.card-body -->
                    
                    <!-- /.col -->
                
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
</div>
        <?php include_once 'componentes/footer.php';?>

        <script src="content/js/respaldobd.js"></script>

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


</body>

</html>