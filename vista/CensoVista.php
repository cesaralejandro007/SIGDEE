
<?php
use config\componentes\configSistema as configSistema;
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

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
                            <h5>Censo de Emprendimientos</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=<?php configSistema::_M01_();?>" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=<?php configSistema::_M05_();?>" class="px-1" style="font-size:18px;">Censo</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <?php

if (isset($response[0]["registrar"])) {
    if ($response[0]["registrar"] == 'true') {?>
                                <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Aperturar censo</button>
                                <?php }}?>
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
                                                <th>Fecha de Apertura</th>
                                                <th>Fecha de Cierre</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {
        if (isset($valor["descripcion"])) {?>
                                            <tr>
                                                <td class="project-actions text-left">
                                                    <div class="d-flex">
                                                        <?php

            if (isset($response[0]["modificar"])) {
                if ($response[0]["modificar"] == 'true') {?>
                                                        <button class="btn mr-2 text-white" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);" name="editar"
                                                            data-target="#editar-censo"><i class="fas fa-edit"></i>
                                                            </button>
                                                        <?php }}?>

                                                        <?php
if (isset($response[0]["eliminar"])) {
                if ($response[0]["eliminar"] == 'true') {?>
                                                        <button class="btn mr-2" style="background:#9D2323;color:white"  type="button" id="eliminardato"data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Eliminar"
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i></button>
                                                        <?php }}?>
                                                    </div>
                                                </td>
                                                <td><?php echo date('d-m-Y h:i:s', strtotime($valor['fecha_apertura'])); ?>
                                                </td>
                                                <td><?php echo date('d-m-Y h:i:s', strtotime($valor['fecha_cierre'])); ?>
                                                </td>
                                                <td><?php echo $valor['descripcion']; ?></td>
                                            </tr>
                                            <?php }}?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Fecha de Apertura</th>
                                                <th>Fecha de Cierre</th>
                                                <th>Descripción</th>
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
            <div class="modal fade show" id="gestion-censo">
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
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="nombre">Fecha de Apertura:</label>
                                        <div class="input-group date" data-target-input="nearest">
                                            <input type="text" id="fecha_apertura" class="form-control datetimepicker-input" data-target="#fecha_apertura" />
                                            <div class="input-group-append" data-target="#fecha_apertura"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <span id="sfecha_apertura"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="nombre">Fecha de Cierre:</label>
                                        <div class="input-group date" data-target-input="nearest">
                                            <input type="text" id="fecha_cierre"
                                                class="form-control datetimepicker-input" data-target="#fecha_cierre" />
                                            <div class="input-group-append" data-target="#fecha_cierre"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        <span id="sfecha_cierre"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label class="col-form-label" for="nombre">Descripción:</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                                        <span id="sdescripcion"></span>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <input class="btn btn-default" type="reset" onclick="limpiar()"
                                        value="Limpiar Campos" />
                                    <button type="button" id="enviar" class="btn btn-primary"></button>
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


    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/locale/es.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="content/js/censo.js"></script>
    <script>
    $(function() {

        //Date and time picker
        $('#fecha_cierre').datetimepicker({
            locale: 'es',
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#fecha_apertura').datetimepicker({
            locale: 'es',
            icons: {
                time: 'far fa-clock'
            }
        });

    })
    </script>
    <!-- Page specific script -->

</body>

</html>