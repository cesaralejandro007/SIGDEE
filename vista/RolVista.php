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

        <div class="card m-2 border border-secondary">
                <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                        <div>
                            <h5>Roles</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=Rol" class="px-1" style="font-size:18px;">Roles</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                            <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Registrar Rol</button>
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
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {
    if (isset($valor["nombre"])) {?>
                                            <tr>

                                                <td class="project-actions text-left" style="width:20%;">
                                                    <div class="d-flex">
                                                    <button class="btn mr-2 text-white" style="background:#E67E22;" data-toggle="modal" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i></button>
                                                                <button class="btn mr-2" style="background:#9D2323;color:white"  type="button" data-toggle="modal" data-placement="top" title="Eliminar"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i></button>
                                                                <button class="btn mr-2" style="background:#06406F;color:white"  type="button" data-toggle="modal" data-placement="top" title="Permisos"
                                                            onclick="cargar_modulos(<?=$valor['id'];?>);cargar_checkbox();cargar_usuario(<?=$valor['id'];?>);"><i
                                                                class="fa fa-lock"></i></button>
                                                    </div>
                                                </td>

                                                <td id="usuario<?php echo $valor['id']; ?>">
                                                    <?php echo $valor['nombre']; ?></td>
                                            </tr>
                                            <?php }}?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
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
                            <h3 class="modal-title">Configuración de permisos</h3>
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
                                    <h5 class="modal-title pb-2 fw-bold" id="userpermisos"></h5>
                                    <div class="col-md-12">
                                            <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Registrar</th>
                                                            <th>Modificar</th>
                                                            <th>Eliminar</th>
                                                            <th>Consultar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="">
                                                        <?php foreach ($modulopermiso as $dato) {?>
                                                        <tr>
                                                            <input type="hidden" id="idmodulo"
                                                                value="<?php echo $dato['id'] ?>">
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td class="d-flex">
                                                                <label class="mycheckbox d-flex justify-content-center align-items-center mx-1">
                                                                    <input type="checkbox" id="check1<?php echo $dato['id']; ?>" onclick="activar(<?php echo $dato['id']; ?>); gestionar_permisos(<?=$dato['id'];?>);">
                                                                    <span>
                                                                        <i class="fas fa-check on"></i>
                                                                        <i class="fas fa-times off"></i>
                                                                    </span>
                                                                </label>
                                                                <h5 class="d-flex justify-content-center align-items-center"><?php echo $dato['nombre']; ?></h5>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <?php if ($dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <label  class="mycheckbox d-flex justify-content-center align-items-center mx-1 on_off<?php echo $dato['id']; ?>">
                                                                        <input type="checkbox" name='registrar[]' id="registrar<?php echo $dato['id'];?>" onclick="gestionar_permisos(<?=$dato['id'];?>);"
                                                                            disabled>
                                                                        <span>
                                                                            <i class="fas fa-check on"></i>
                                                                            <i class="fas fa-times off"></i>
                                                                        </span>
                                                                    </label>
                                                                <?php }?>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <?php if ($dato['nombre'] !== 'Agregar Contenido' and $dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <label  class="mycheckbox d-flex justify-content-center align-items-center mx-1 on_off<?php echo $dato['id']; ?>">
                                                                        <input type="checkbox" name='modificar[]' id="modificar<?php echo $dato['id']; ?>" onclick="gestionar_permisos(<?=$dato['id'];?>);" disabled>
                                                                        <span>
                                                                            <i class="fas fa-check on"></i>
                                                                            <i class="fas fa-times off"></i>
                                                                        </span>
                                                                    </label>
                                                                <?php }?>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <?php if ($dato['nombre'] !== 'Agregar Contenido' and $dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                    <label  class="mycheckbox d-flex justify-content-center align-items-center mx-1 on_off<?php echo $dato['id']; ?>">
                                                                        <input type="checkbox" name='eliminar[]'id="eliminar<?php echo $dato['id']; ?>" onclick="gestionar_permisos(<?=$dato['id'];?>);" disabled>
                                                                        <span>
                                                                            <i class="fas fa-check on"></i>
                                                                            <i class="fas fa-times off"></i>
                                                                        </span>
                                                                    </label>
                                                                <?php }?>
                                                            </td>
                                                            <?php }?>
                                                            <?php if ($dato['nombre'] !== 'Permisos' and $dato['nombre'] !== 'Usuarios' and $dato['nombre'] !== 'Entornos del Sistema') {?>
                                                            <td>
                                                                <?php if ($dato['nombre'] !== 'Chat Virtual' and $dato['nombre'] !== 'Aspirantes') {?>
                                                                <label  class="mycheckbox d-flex justify-content-center align-items-center mx-1 on_off<?php echo $dato['id']; ?>">
                                                                    <input type="checkbox"  name='consultar[]' id="consultar<?php echo $dato['id']; ?>" onclick="gestionar_permisos(<?=$dato['id'];?>);" disabled>
                                                                    <span>
                                                                        <i class="fas fa-check on"></i>
                                                                        <i class="fas fa-times off"></i>
                                                                    </span>
                                                                </label>
                                                                <script>var bool ="true";</script>
                                                                <?php }else{?><script>var bool ="false";</script><?php }?>
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