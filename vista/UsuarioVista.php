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
            <div class="card m-2 border border-dark">
                <div class="card-header">
                    <div class="container-fluid d-flex justify-content-start">
                        <div>
                            <h5>Usuarios</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=usuario" style="font-size:18px;">Usuarios</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <button class="btn btn-sm my-1" id="nuevo">+ Registrar usuario</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card border border-secondary">
                                <div class="table-responsive p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-bordered table-hover">
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
                                                        <button class="btn btn-sm"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i>Editar</button>
                                                        <button class="btn btn-sm" type="button"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i>Eliminar</button>
                                                        <button class="btn btn-sm"
                                                            onclick="cargar_rol(<?=$valor['id'];?>); cargar_checkbox(<?php echo $valor['id']; ?>);"><i
                                                                class="fas fa-user-tag"></i>Rol</button>
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
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr style="text-align:center;">
                                                        <th>Rol</th>
                                                        <th>Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="">
                                                    <?php foreach ($cargar_roles as $dato) {?>
                                                    <tr>
                                                        <input type="hidden" id="id_rol<?php echo $dato['id']; ?>"
                                                            value="<?php echo $dato['id']; ?>">
                                                        <td>
                                                            <div class="form-check form-switch mx-3">
                                                                <input class='form-check-input' type='checkbox'
                                                                    id="check2<?php echo $dato['id']; ?>"
                                                                    onclick="activar(<?=$dato['id'];?>);">
                                                                <label
                                                                    for="check2<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td style="width:26%;">
                                                            <button class="btn btn-sm bg-primary" type="button"
                                                                id="botonguardar<?php echo $dato['id']; ?>"
                                                                onclick="gestionar_rol(<?=$dato['id'];?>);"
                                                                disabled><i class="fas fa-save"></i>Guardar</button>
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

    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="content/js/usuario.js"></script>

    <!-- Page specific script -->

    </script>
</body>

</html>