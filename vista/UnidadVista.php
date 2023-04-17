<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->

        <!-- /.modal Registrar -->
        <div class="content-wrapper">
        <div class="card m-2 border border-secondary">
                <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between">
                        <div>
                            <h5>Unidad</h5>
                        </div>
                        <div class="">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="javascript:history.back()" class="text-secondary px-1" style="font-size:18px;">Aula</a>
                        <a href="#" class="px-1" style="font-size:18px;">Unidad</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <!-- /.row -->
                    <!-- END ALERTS AND CALLOUTS -->
                    <div class="row">
                        <div class="col-12">
                            <!-- Custom Tabs -->
                            <div class="card">
                                <div class="card-header d-flex p-0">
                                    <h3 class="card-title p-3"><?php echo $mostrar_unidad[0]['nombre']; ?></h3>
                                    <ul class="nav nav-pills ml-auto p-2">
                                        <li class="nav-item dropdown"></li>
                                        <?php
if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                            Unidad <span class="caret"></span>
                                        </a>
                                        <?php }}?>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#unidades" data-toggle="tab">Ver</a>

                                            <?php
if (isset($response[0]["modificar"])) {
    if ($response[0]["modificar"] == 'true') {?>
                                            <a class="dropdown-item" href="#editar" data-toggle="tab">Editar</a>
                                            <?php }}?>
                                            <?php
if (isset($response[0]["eliminar"])) {
    if ($response[0]["eliminar"] == 'true') {?>
                                            <button class="dropdown-item"
                                                onclick="eliminar(<?=$mostrar_unidad[0]['id'];?>);">Eliminar</button>
                                            <?php }}?>
                                        </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <?php
if (isset($response3[0]["consultar"])) {
    if ($response3[0]["consultar"] == 'true') {?>
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                                Contenidos <span class="caret"></span>
                                            </a>
                                            <?php }}?>

                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#contenidos" data-toggle="tab">Ver</a>
                                                <?php
if (isset($response3[0]["registrar"])) {
    if ($response3[0]["registrar"] == 'true') {?>
                                                <a class="dropdown-item"
                                                    onclick="contenidos(<?=$id_unidad?>);">Agregar</a>
                                            </div>
                                            <?php }}?>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <?php
if (isset($response2[0]["consultar"])) {
    if ($response2[0]["consultar"] == 'true') {?>
                                            <a  class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                                                Evaluaciones <span class="caret"></span>
                                            </a>
                                            <?php }}?>
                                            <div class="dropdown-menu">
                                                <a id="Veractive" class="dropdown-item" href="#evaluaciones" data-toggle="tab">Ver</a>
                                                <?php
if (isset($response2[0]["registrar"])) {
    if ($response2[0]["registrar"] == 'true') {?>
                                                <a id="Evaluacionesactive" class="dropdown-item" href="#agregar-evaluacion"
                                                    data-toggle="tab">Agregar</a>
                                                <?php }}?>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!--Mostrar Unidad-->
                                        <?php
if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
                                        <div class="tab-pane active" id="unidades">
                                            <div class="card-body">
                                                <blockquote>
                                                    <p><?php echo $mostrar_unidad[0]['descripcion'] ?></p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <?php }}?>
                                        <!--/Mostrar Unidad-->
                                        <!--Editar Unidad-->
                                        <div class="tab-pane" id="editar">
                                            <form class="form-horizontal">
                                                <input type="hidden" name="id" id="id" value="<?=$id_unidad?>">
                                                <input type="hidden" name="aula1" id="aula1"
                                                    value="<?=$mostrar_unidad[0]['id_aula']?>">
                                                <div class="form-group row">
                                                    <label for="inputName"
                                                        class="col-sm-2 col-form-label">Nombre</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nombre"
                                                            name="nombre" value="<?=$mostrar_unidad[0]['nombre']?>">
                                                    </div>
                                                    <span id="snombre"></span>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputExperience"
                                                        class="col-sm-2 col-form-label">Descripción</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="descripcion" id="descripcion"
                                                            value="<?=$mostrar_unidad[0]['descripcion'];?>"><?php echo $mostrar_unidad[0]['descripcion']; ?></textarea>
                                                    </div>
                                                    <span id="sdescripcion"></span>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="button" id="enviar"
                                                        class="btn btn-primary">Modificar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--/Editar Unidad-->
                                        <!--Mostrar Contenidos-->
                                        <div class="tab-pane" id="contenidos">
                                            <h3>Contenidos</h3>
                                            <div class="card-body">
                                                <?php if ($listar_contenidos) {foreach ($listar_contenidos as $contenido) {?>
                                                <div class="card card-light">
                                                    <blockquote>
                                                        <h4><?php echo $contenido['nombre'] ?></h4>
                                                        <p><?php echo $contenido['descripcion'] ?></p>
                                                        <a href="">Documento Ajunto <i
                                                                class="fas fa-cloud-download-alt"></i></a>
                                                    </blockquote>
                                                </div>
                                                <?php }}?>
                                            </div>
                                        </div>
                                        <!--/Mostrar Contenidos-->
                                        <!--Mostrar evaluaciones-->
                                        <div class="tab-pane" id="evaluaciones">
                                            <h3>Evaluaciones</h3>
                                            <div class="card-body">
                                                <?php foreach ($listar_evaluaciones as $evaluacion) {?>
                                                    <h4><?php echo $evaluacion['nombre'] ?></h4>
                                                    <div class="card card-light border border-dark">
                                                        <blockquote>
                                                        <div class="position-relative">
                                                            <div class="position-absolute top-0 end-0">
                                                            <ul class="nav nav-pills ml-auto">
                                                                <li class="nav-item dropdown">
                                                                    <a class="nav-link" data-toggle="dropdown"
                                                                        style="cursor: pointer">
                                                                        <i class="fas fa-ellipsis-h"></i></i><span
                                                                            class="caret"></span>
                                                                    </a>
                                                                    <div class="dropdown-menu">
                                                                        <div class="d-flex flex-column">
                                                                            <a class="d-flex btn btn-sm"
                                                                                href=" #comentarios" type="button"
                                                                                onclick="cargar_datosEvaluacion(<?=$evaluacion['unidad_evaluacion'];?>);">Editar</a>
                                                                            <a class="d-flex btn btn-sm"
                                                                                href="#comentarios" type="button"
                                                                                onclick="eliminar_evaluacion(<?=$evaluacion['unidad_evaluacion'];?>);">Eliminar</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                            
                                                                
                                                            

                                                        <p>Fecha de apertura:
                                                            <?=date('d-m-Y h:i:s', strtotime($evaluacion['inicio']));?>
                                                            <br>
                                                        </p>
                                                        <p>Fecha de cierre:
                                                            <?=date('d-m-Y h:i:s', strtotime($evaluacion['cierre']));?>
                                                        </p>
                                                        <a href="">Documento Ajunto <i
                                                                class="fas fa-cloud-download-alt"></i></a>
                                                    </blockquote>
                                                    <div class="card-footer border border-secondary">
                                                        <a
                                                            href="?pagina=MostrarEvaluacion&id_unidad_evaluacion=<?=$evaluacion['unidad_evaluacion'];?>">

                                                            <button type="button" id="entregar" href="#"
                                                                class="btn btn-primary float-right">Ver</button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <!--/Mostrar evaluaciones-->
                                        <!--Agregar Evaluación-->
                                        <div class="tab-pane" id="agregar-evaluacion">
                                            <form class="form-horizontal">
                                                <input type="hidden" name="accion_evaluacion" id="accion_evaluacion" value="guardar_evaluacion">
                                                <input type="hidden" name="id_evaluacion" id="id_evaluacion"
                                                    value="<?=$mostrar_unidad[0]['id_aula']?>">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Nombre</label>
                                                        <div class="input-group" id="buscar">
                                                            <input type="text" class="form-control"
                                                                 id="nombre_evaluacion" />
                                                            <div class="input-group-append" >
                                                                <div class="input-group-text"><i
                                                                        class="fa fa-search"></i></div>
                                                            </div>
                                                        </div>
                                                        <span id="snombre"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>Fecha de apertura:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" id="fecha_apertura"
                                                                class="form-control datetimepicker-input"
                                                                data-target="#fecha_apertura" />
                                                            <div class="input-group-append"
                                                                data-target="#fecha_apertura"
                                                                data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                        <span id="sfecha_apertura"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Fecha de cierre:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" id="fecha_cierre"
                                                                class="form-control datetimepicker-input"
                                                                data-target="#fecha_cierre" />
                                                            <div class="input-group-append" data-target="#fecha_cierre"
                                                                data-toggle="datetimepicker">
                                                                <div class="input-group-text"><i
                                                                        class="fa fa-calendar"></i></div>
                                                            </div>
                                                        </div>
                                                        <span id="sfecha_cierre"></span>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="button" id="guardar-evaluacion"
                                                        class="btn btn-primary">Agregar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!--/Agregar Evaluación-->
                                    </div><!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal para agregar contenidos a la unidad seleccionada-->
    <div class="modal fade show" id="gestion_contenidos">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo-gestion"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="fi" method="post">
                        <input type="hidden" name="accion-gestion" id="accion-gestion" />
                        <input type="hidden" name="id_unidad" id="id_unidad" value="<?=$id_unidad?>" />
                        <div class=" row">
                            <div class="form-group">
                                <select class="contenidos" multiple="multiple" id="valores-contenidos"
                                    name="valores-contenidos">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <input class="btn btn-default" type="reset" value="Limpiar Campos" />
                            <button type="button" id="guardar-contenidos" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para agregar evaluaciones a la unidad seleccionada-->
    <div class="modal fade show" id="gestion_evaluaciones">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo-gestion">Evaluaciones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="funcionpaginacion" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $m_e;?>
                              
                        </tbody>
                    </table>
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
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/moment/locale/es.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


    <script src="content/js/unidad.js"></script>
    <!-- Page specific script -->
    <script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
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
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })
    </script>
</body>

</html>