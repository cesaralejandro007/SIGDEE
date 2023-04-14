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
                            <h5>Estudiantes</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=Estudiante" style="font-size:18px;">Estudiantes</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <div>
                                    <?php
if (isset($response[0]["registrar"])) {
    if ($response[0]["registrar"] == 'true') {?>
                                    <button class="btn btn-sm my-1" id="nuevo">+ Registrar
                                        Estudiante</button>
                                    <?php }}?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php
if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
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
                                                <th>Telefono</th>
                                                <th>Correo</th>
                                                <th>Direccion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {?>
                                            <tr>
                                                <td class="project-actions text-left">
                                                    <div class="d-flex">
                                                        <?php
if (isset($response[0]["modificar"])) {
        if ($response[0]["modificar"] == 'true') {?>
                                                        <button class="btn btn-sm"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i>Editar</button>
                                                        <?php }}?>
                                                        <?php
if (isset($response[0]["eliminar"])) {
        if ($response[0]["eliminar"] == 'true') {?>
                                                        <button class="btn btn-sm" type="button"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i>Eliminar</button>
                                                        <?php }}?>
                                                    </div>
                                                </td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['cedula']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['nombre']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['apellido']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['telefono']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['correo']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['direccion']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <?php }}?>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.modal Registrar -->

        <div class="modal fade show" id="gestion-estudiante">
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

    <?php include_once 'componentes/footer.php';?>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="content/js/estudiante.js"></script>

    <!-- Page specific script -->

    </script>
</body>

</html>