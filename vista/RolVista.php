<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <div class="card m-2 border border-dark">
                <div class="card-header">
                    <div class="container-fluid d-flex justify-content-start">
                        <div>
                            <h5>Roles</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=AreaEmprendimiento" style="font-size:18px;">Roles</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <button class="btn btn-sm my-1" id="nuevo">+ Registrar Rol</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card border border-secondary">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {
    if (isset($valor["nombre"])) {?>
                                            <tr>
                                                <?php if ($valor['nombre'] != 'Super Usuario' and $valor['nombre'] != 'Administrador') {?>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <div class="d-flex">
                                                        <button class="btn btn-sm"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i>Editar</button>
                                                        <button class="btn btn-sm" type="button"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i>Eliminar</button>
                                                        <button class="btn btn-sm" type="button"
                                                            onclick="cargar_modulos(<?=$valor['id'];?>);cargar_checkbox();cargar_usuario(<?=$valor['id'];?>);"><i
                                                                class="fa fa-lock"></i>Permisos</button>
                                                    </div>
                                                </td>
                                                <?php } else {?>
                                                <td class="project-actions text-left" style="width:30%;">
                                                    <div class="d-flex">
                                                        <button class="btn btn-sm" type="button" disabled><i
                                                                class="fas fa-edit"></i>Editar</button>
                                                        <button class="btn btn-sm" type="button" disabled><i
                                                                class="fas fa-trash"></i>Eliminar</button>
                                                        <button class="btn btn-sm" type="button" disabled><i
                                                                class="fa fa-lock"></i>Permisos</button>
                                                    </div>
                                                </td>
                                                <?php }?>
                                                <td id="usuario<?php echo $valor['id']; ?>">
                                                    <?php echo $valor['nombre']; ?></td>
                                            </tr>
                                            <?php }}?>
                                        </tbody>
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
        </div>
        <!-- /.modal Registrar -->
        <div class=" modal fade" id="gestion-rol">
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
                            <input type="hidden" name="accion" id="accion" />
                            <input type="hidden" name="id" id="id" />
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <label class="col-form-label" for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                    <span id="snombre"></span>
                                </div>
                                <div class="registrarpermiso"></div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <input class="btn btn-default" type="reset" value="Limpiar Campos" />
                                <button type="button" id="enviar" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <!-- /.modal permiso -->

        <div class="modal" id="crear-permisos">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex justify-content-center">
                            <h4 class="modal-title">Configuración de permisos</h4>
                            <h4 class="modal-title" id="userpermisos"></h4>
                        </div>
                        <butto type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="cerrarmodalpermisos()">
                            <span aria-hidden="true">&times;</span>
                        </butto>
                    </div>
                    <div class="modal-body">
                        <section class="content">
                            <div class="container-fluid">
                                <form id="f1" method="post">
                                    <input type="hidden" id="id_rol">
                                    <h1 id="nombre_rol"></h1>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                            <div class="table-responsive p-2">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr style="text-align:center;">
                                                            <th>Nombre</th>
                                                            <th>Registrar</th>
                                                            <th>Modificar</th>
                                                            <th>Eliminar</th>
                                                            <th>Consultar</th>
                                                            <th>Opcion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="">
                                                        <?php foreach ($modulopermiso as $dato) {?>
                                                        <tr>
                                                            <input type="hidden" id="idmodulo"
                                                                value="<?php echo $dato['id'] ?>">
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <div class="form-check form-switch mx-3">
                                                                    <input class='form-check-input' type='checkbox'
                                                                        id="check1<?php echo $dato['id']; ?>"
                                                                        onclick="activar(<?php echo $dato['id']; ?>); activarboton(<?php echo $dato['id']; ?>)">
                                                                    <label
                                                                        for="check1<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <div
                                                                    class='form-check form-switch d-flex justify-content-center'>
                                                                    <?php if ($dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <input class='form-check-input' type='checkbox'
                                                                        role='switch' name='registrar[]'
                                                                        id="registrar<?php echo $dato['id']; ?>"
                                                                        onclick="activarboton(<?php echo $dato['id']; ?>)"
                                                                        disabled>
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <div
                                                                    class='form-check form-switch d-flex justify-content-center'>
                                                                    <?php if ($dato['nombre'] !== 'Agregar Contenido' and $dato['nombre'] !== 'Agregar Evaluacion' and $dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <input class='form-check-input' type='checkbox'
                                                                        role='switch' name='modificar[]'
                                                                        id="modificar<?php echo $dato['id']; ?>"
                                                                        onclick="activarboton(<?php echo $dato['id']; ?>)"
                                                                        disabled>
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <div
                                                                    class='form-check form-switch d-flex justify-content-center'>
                                                                    <?php if ($dato['nombre'] !== 'Agregar Contenido' and $dato['nombre'] !== 'Agregar Evaluacion' and $dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <input class='form-check-input' type='checkbox'
                                                                        role='switch' name='eliminar[]'
                                                                        id="eliminar<?php echo $dato['id']; ?>"
                                                                        onclick="activarboton(<?php echo $dato['id']; ?>)"
                                                                        disabled>
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <div
                                                                    class='form-check form-switch d-flex justify-content-center'>
                                                                    <?php if ($dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                        <script>var bool ="true";</script>
                                                                    <input class='form-check-input' type='checkbox'
                                                                        role='switch' name='consultar[]'
                                                                        id="consultar<?php echo $dato['id']; ?>"
                                                                        onclick="activarboton(<?php echo $dato['id']; ?>)"
                                                                        disabled>
                                                                    <?php }else{?><script>var bool ="false";</script><?php }?>
                                                                </div>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td style="width:15%;">
                                                                <button class="btn btn-sm bg-primary" type="button"
                                                                    id="botonguardar<?php echo $dato['id']; ?>"
                                                                    onclick="gestionar_permisos(<?=$dato['id'];?>);"
                                                                    disabled><i class="fas fa-save"></i>Guardar</button>
                                                            </td>
                                                            <?php }?>
                                                        </tr>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                                </div>
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
        <!-- /.content-wrapper -->
        <?php include_once 'componentes/footer.php';?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Validaciones -->
    <!-- DataTables  & Plugins -->
    <script src="content/js/rol.js"></script>


</body>

</html>