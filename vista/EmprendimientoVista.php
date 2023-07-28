<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
                            <h5>Emprendimiento</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div>
                                <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                            </div>
                            <div>
                                <a href="?pagina=Emprendimiento" class="px-1" style="font-size:18px;">Emprendimiento</a>
                            </div>
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
                                <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Registrar Emprendimiento</button>
                                    <?php }}?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php
if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
                            <div class="card border">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Area de Emprendimiento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($r1 as $valor) {?>
                                            <tr>
                                                <td class="project-actions text-left">
                                                    <div class="d-flex">
                                                        <?php
if (isset($response[0]["modificar"])) {
        if ($response[0]["modificar"] == 'true') {?>
                                                        <button class="btn mr-2 text-white" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);" name="editar"><i
                                                                class="fas fa-edit"></i></button>
                                                        <?php }}?>
                                                        <?php
if (isset($response[0]["eliminar"])) {
        if ($response[0]["eliminar"] == 'true') {?>
                                                        <button class="btn mr-2" style="background:#9D2323;color:white"  type="button" id="eliminardato"data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Eliminar"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash "></i></button>
                                                        <?php }}?>
                                                        <button class="btn mr-2 text-white" style="background:#196F3D;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Modulo"
                                                            onclick="asignarmodulo(<?=$valor['id'];?>); cargar_checkboxme(<?php echo $valor['id']; ?>);"
                                                            name="editar"><i class="fas fa-plus"></i></button>
                                                            <label class="mycheckbox d-flex justify-content-center align-items-center mx-1">
                                                                    <input  type='checkbox' id="desh<?=$valor['id'];?>" onclick="activarod(<?=$valor['id'];?>);">
                                                                    <span>
                                                                        <i class="fas fa-check on"></i>
                                                                        <i class="fas fa-times off"></i>
                                                                    </span>
                                                                </label>
                                                        <h5 id="labelad<?=$valor['id'];?>" class="d-flex justify-content-center align-items-center">Desactivado</h5>
                                                    </div>
                                                </td>
                                                <td id="nomemprendimiento<?php echo $valor['id']; ?>">
                                                    <?php echo $valor['nombre']; ?></td>
                                                <td><?php echo $valor['area']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Area de Emprendimiento</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <?php }else{
                                echo '<div class="alert alert-danger" role="alert">No tiene permisos para consultar este modulo.</div>';
                            }}?>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                <!-- /.content -->
            </div>
            <!-- /.modal Registrar -->
            <div class="modal fade" id="gestionar-tip_emprendimiento">
                <div class="modal-dialog modal-md">
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
                                    <div class="col-md-5">
                                        <label class="col-form-label" for="nombre">Nombre:</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control">
                                        <span id="snombre"></span>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="col-form-label" for="area">Área de Emprendimiento:</label>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="area">Opciones</label>
                                            <select class="form-control form-select" id="area" name="area">
                                                <option value="0">--Seleccione--</option>
                                                <?php foreach ($r2 as $key => $value) {?>
                                                <option value="<?=$value['id'];?>"> <?php echo $value['nombre']; ?>
                                                </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <span id="sarea"></span>
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

            <div class="modal" id="asignarmodulo">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h3 class="modal-title">Agregar Modulos:</h3>

                            <butto type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="cerrarmodalme()">
                                <span aria-hidden="true">&times;</span>
                            </butto>
                        </div>
                        <div class="modal-body">
                            <section class="content">
                                <input type="hidden" id="id_emprendimiento">
                                <div class="container-fluid">
                                    <form id="f3" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <h5 class="modal-title fw-bold pb-2" id="cargaremprendimiento"></h5>
                                                    <table class="table table-striped">
                                                        <thead class="thead-dark">
                                                            <tr style="text-align:center;">
                                                                <th>Modulo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="">
                                                            <?php foreach ($r3 as $key => $dato) {?>
                                                            <tr>
                                                                <input type="hidden"
                                                                    id="idmodulo<?php echo $dato['id']; ?>"
                                                                    value="<?php echo $dato['id']; ?>">
                                                                <td class="d-flex">
                                                                <label class="mycheckbox d-flex justify-content-center align-items-center mx-1">
                                                                    <input type="checkbox"id="check2<?php echo $dato['id']; ?>" id="botonasignar<?php echo $dato['id']; ?>" onclick="gestionar_em(<?=$dato['id'];?>);">
                                                                    <span>
                                                                    <i class="fas fa-check on"></i>
                                                                    <i class="fas fa-times off"></i>
                                                                    </span>
                                                                </label>
                                                                <h5 class="d-flex justify-content-center align-items-center"><?php echo $dato['nombre']; ?></h5>
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

            </div>

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

    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="content/js/Emprendimiento.js"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
    </script>

    <!-- Page specific script -->
</body>

</html>