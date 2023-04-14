<html lang="en">
<?php include_once 'componentes/head.php';?>

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
                            <h5>Perfil</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=Perfil" style="font-size:18px;">Perfil</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="card mb-3 " style="max-width: 950px;">
                                <div class="d-flex">
                                    <div class="row g-0">
                                    <?php 
                        $directory="content/usuarios/";
                        $dirint = dir($directory);
                        $bandera = false;
                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                        {

                            if($archivo == $_SESSION['usuario']['cedula'].".png"){
                                $imagen1 = $archivo;
                                $bandera = true;
                            }
                            else
                             $imagen1 = "img5.png";
                        }
                        $dirint->close(); 
                    ?>
                                        <div class="col-md-4 d-flex aling">
                                            <img src= "content/usuarios/<?php echo $imagen1; ?>" class="img-fluid rounded-start"
                                                alt="">
                                        </div>

                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <table class="table table-striped  table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Datos Personales:</th>
                                                            <th scope="col">
                                                                <a class="btn btn-sm btn-dark text-light"
                                                                    onclick="cargar_datos(<?=$infoU[0]['id']?>)" 
                                                                    style="cursor: pointer">
                                                                    <i class="fas fa-user-edit"></i> Editar perfil
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                         foreach ($infoU as $valor) {?>
                                                        <tr>
                                                            <td>Cedula:</td>
                                                            <td><?php echo $valor['cedula'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nombre:</td>
                                                            <td><?php echo $valor['nombre'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apellido:</td>
                                                            <td><?php echo $valor['apellido'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Telefono</td>
                                                            <td><?php echo $valor['telefono'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Correo:</td>
                                                            <td><?php echo $valor['correo'] ?></td>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.modal Registrar -->
        <div class="modal fade show" id="gestion-modulo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo">Modificar datos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="f">
                        <input type="hidden" name="cedula_usuario" id="cedula_usuario"
                        value="<?php echo $_SESSION['usuario']['cedula'] ?>" />
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="id">
                                <div class="input-group">
                                    <span class="input-group-text">Correo:</span>
                                    <input type="text" class="form-control" id="correo">
                                </div>
                                <span id="scorreo"></span>
                                <div class="input-group mt-2">
                                    <span class="input-group-text">Telefono:</span>
                                    <input type="text" class="form-control" id="telefono">
                                </div>
                                <span id="stelefono"></span>
                                <div class="input-group mt-2">
                                <span class="input-group-text">Nueva Clave:</span>
                                    <input id="floatingPassword" placeholder="Clave:" type="Password"
                                        Class="form-control">
                                    <div class="input-group-append">
                                        <button id="show_password" class="btn btn-primary" type="button"
                                            onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span>
                                        </button>
                                    </div>
                                </div>
                                <span id="sclave"></span>
                                <div class="input-group mt-2">
                                    <span class="input-group-text">Nueva foto:</span>
                                    <input type="file" class="form-control" id="archivo_adjunto" name="archivo_adjunto">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <input class="btn btn-default" type="reset" onclick="limpiar()"
                                    value="Limpiar Campos" />
                                <button type="button" class="btn btn-primary" id="modificarp">Modificar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>


          <?php include_once('componentes/footer.php'); ?>

            <script src="content/js/perfil.js"></script>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- Bootstrap 4 -->




    <!-- Page specific script -->
</body>

</html>