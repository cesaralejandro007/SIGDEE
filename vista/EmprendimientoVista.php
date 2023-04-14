<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<body class="hold-transition sidebar-mini layout-fixed">
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
                            <h5>Emprendimiento</h5>
                        </div>
                        <div class="px-5">
                            <a href="#" style="font-size:18px;">Inicio</a> >
                            <a href="?pagina=Emprendimiento" style="font-size:18px;">Emprendimiento</a>
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
                                    <button class="btn btn-sm my-1" id="nuevo">+ Registrar Emprendimiento</button>
                                    <?php }}?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php
if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
                            <div class="card border border-secondary">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-bordered table-hover">
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
                                                        <button class="btn btn-sm"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);" name="editar"><i
                                                                class="fas fa-edit"></i>Editar</button>
                                                        <?php }}?>
                                                        <?php
if (isset($response[0]["eliminar"])) {
        if ($response[0]["eliminar"] == 'true') {?>
                                                        <button class="btn btn-sm" type="button" id="eliminardato"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash "></i>Eliminar</button>
                                                        <?php }}?>
                                                        <button class="btn btn-sm"
                                                            onclick="asignarmodulo(<?=$valor['id'];?>); cargar_checkboxme(<?php echo $valor['id']; ?>);"
                                                            name="editar"><i class="fas fa-plus"></i>Modulo</button>
                                                        <div class="form-check form-switch mx-3">
                                                            <input class='form-check-input' type='checkbox'
                                                                id="desh<?=$valor['id'];?>"
                                                                onclick="activarod(<?=$valor['id'];?>);">
                                                            <label id="labelad<?=$valor['id'];?>">Desactivado
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="nomemprendimiento<?php echo $valor['id']; ?>">
                                                    <?php echo $valor['nombre']; ?></td>
                                                <td><?php echo $valor['area']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <?php }}?>
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

                            <h4 class="modal-title">Agregar Modulos:</h4>

                            <butto type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="cerrarmodalme()">
                                <span aria-hidden="true">&times;</span>
                            </butto>
                        </div>
                        <div class="modal-body">
                            <h6 class="modal-title" id="cargaremprendimiento"></h6>
                            <section class="content">
                                <input type="hidden" id="id_emprendimiento">
                                <div class="container-fluid">
                                    <form id="f3" method="post">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr style="text-align:center;">
                                                                <th>Modulo</th>
                                                                <th>Opciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="">
                                                            <?php foreach ($r3 as $key => $dato) {?>
                                                            <tr>
                                                                <input type="hidden"
                                                                    id="idmodulo<?php echo $dato['id']; ?>"
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
                                                                        id="botonasignar<?php echo $dato['id']; ?>"
                                                                        onclick="gestionar_em(<?=$dato['id'];?>);"
                                                                        disabled><i
                                                                            class="fas fa-save"></i>Guardar</button>
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