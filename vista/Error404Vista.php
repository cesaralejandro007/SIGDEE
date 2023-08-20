<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<style type="text/css">
    .content-wrapper{
        background-image: url(content/imagenes/error_404.jpg);
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center center;
        background-blend-mode: darken;
    }
    body {overflow-x:hidden!important;}
</style>


<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            
        </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <?php include_once 'componentes/footer.php';?>
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
</body>

</html>