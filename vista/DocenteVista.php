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
                            <h5>Docentes</h5>
                        </div>
                        <div class="">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=Docente" class="px-1" style="font-size:18px;">Docente</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <div>
                                    <?php
                if (isset($response[0]["registrar"])) {
                    if ($response[0]["registrar"] == 'true') {?>
                                    <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Registrar Docente</button>
                                    <?php }}?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php
                if (isset($response[0]["consultar"])) {
                    if ($response[0]["consultar"] == 'true') {?>
                            <div class="card border">
                                <div class="table-responsive-xl px-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
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
                                                        <button class="btn mr-2 text-white" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i></button>
                                                        <?php }}?>
                                                        <?php
                        if (isset($response[0]["eliminar"])) {
                                if ($response[0]["eliminar"] == 'true') {?>
                                                        <button class="btn mr-2" style="background:#9D2323;color:white"  type="button" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Eliminar"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i></button>
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
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Cedula</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Telefono</th>
                                                <th>Correo</th>
                                                <th>Direccion</th>
                                            </tr>
                                        </tfoot>
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
        <div class="modal fade show" id="gestion-docente">
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
                                <input class="btn btn-default" type="reset" onclick="limpiar()"
                                    value="Limpiar Campos" />
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

        <!-- /.modal Editar -->

        
        <!-- /.content-wrapper -->

        
        
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <?php include_once 'componentes/footer.php';?>
    <script src="content/js/docente.js"></script>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- Bootstrap 4 -->

    <!-- DataTables  & Plugins -->

</body>

</html>