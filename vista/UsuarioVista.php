<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>

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
                        <div>
                            <h5>Usuarios</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                         <a href="?pagina=Usuario" class="px-1" style="font-size:18px;">Usuarios</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                            <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Registrar usuario</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card border">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Cedula</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Correo</th>
                                                <th>direccion</th>
                                                <th>Telefono</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
        foreach ($r1 as $valor) {?>
                                            <tr>
                                            <input type="hidden" name="idusuario" id="idusuario-<?php echo $valor['id']; ?>" value="<?=$valor['cedula'];?>"/>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <div class="d-flex">
                                                    <button class="btn mr-2 text-white" style="background:#E67E22;" data-toggle="modal" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i></button>
                                                                <button class="btn mr-2" style="background:#9D2323;color:white"  type="button" data-toggle="modal" data-placement="top" title="Eliminar"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i></button>
                                                                <button class="btn mr-2" style="background:#06406F;color:white"  type="button" data-toggle="modal" data-placement="top" title="Rol"
                                                            onclick="cargar_rol(<?=$valor['id'];?>); cargar_checkbox(<?php echo $valor['id']; ?>);"><i
                                                                class="fas fa-user-tag"></i></button>
                                                    </div>
                                                </td>
                                                <td id="cedulausuario<?php echo $valor['id']; ?>" class=" project-actions
                                                    text-left" style="width:30%;">
                                                    <?php echo $valor['cedula']; ?></td>
                                                <td id="nombreusuario<?php echo $valor['id']; ?>" class=" project-actions
                                                    text-left" style="width:30%;">
                                                    <?php echo $valor['nombre']; ?></td>
                                                <td id="apellidousuario<?php echo $valor['id']; ?>" class="
                                                    project-actions text-left" style="width:30%;">
                                                    <?php echo $valor['apellido']; ?></td>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <?php echo $valor['correo']; ?></td>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <?php echo $valor['direccion']; ?></td>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <?php echo $valor['telefono']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Cedula</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Correo</th>
                                                <th>direccion</th>
                                                <th>Telefono</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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
        </div>
        <!-- /.modal Registrar -->

        <div class="modal fade show" id="gestion-usuario">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="fi" method="post">
                            <input type="hidden" name="accion" id="accion" />
                            <input type="hidden" name="id" id="id" />
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="message-text" class="col-form-label" for="cedula">Cedula:</label>
                                    <input type="text" name="cedula" id="cedula" class="form-control">
                                    <span id="scedula"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="message-text" class="col-form-label" for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                    <span id="snombre"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="message-text" class="col-form-label" for="apellido">Apellido:</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control">
                                    <span id="sapellido"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="message-text" class="col-form-label" for="telefono">Telefono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                    <span id="stelefono"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="message-text" class="col-form-label" for="correo">Correo:</label>
                                    <input type="text" name="correo" id="correo" class="form-control">
                                    <span id="scorreo"></span>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-md-12">
                                    <label for="message-text" class="col-form-label" for="direccion">Direccion:</label>
                                    <textarea type="text" cols="15" rows="4" name="direccion" id="direccion"
                                        class="form-control"></textarea>
                                    <span id="sdireccion"></span>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <input class="btn btn-default" type="reset" value="Limpiar Campos" />
                                <button type="button" id="enviar" class="btn btn-primary">Registrar</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="crear-rol">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Configuración de roles:</h4>

                    <butto type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="cerrarmodalrol()">
                        <span aria-hidden="true">&times;</span>
                    </butto>
                </div>
                <div class="modal-body">
                    <h6 class="modal-title" id="usuariocargar"></h6>
                    <section class="content">
                        <input type="hidden" id="id_usuario">
                        <div class="container-fluid">
                            <form id="f2" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Rol</th>
                                                        <th>Opción</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="">
                                                    <?php foreach ($cargar_roles as $dato) {?>
                                                    <tr>
                                                        <input type="hidden" id="id_rol<?php echo $dato['id']; ?>"
                                                            value="<?php echo $dato['id']; ?>">
                                                        <td>
                                                        <h5><?php echo $dato['nombre']; ?></h5>
                                                        </td>
                                                        <td>
                                                        <label class="mycheckbox d-flex align-items-center">
                                                            <input type="checkbox"id="check2<?php echo $dato['id']; ?>"
                                                                    onclick="gestionar_rol(<?=$dato['id'];?>);">
                                                            <span>
                                                            <i class="fas fa-check on"></i>
                                                            <i class="fas fa-times off"></i>
                                                            </span>
                                                        </label>
                                                        </td>
                                                        <?php }?>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <input class="btn btn-default " type="reset" value="Limpiar Campos" />
                                </div>
                            </form>

                        </div>
                    </section>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
                                                        
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
    <script src="content/js/usuario.js"></script>

    <!-- Page specific script -->

    </script>
</body>

</html>