<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <style>
            .masthead {
            padding-top: 3%;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            background-size: cover;
            }
            fieldset {
            background-color: #eeeeee;
            }

            legend {
            background-color:#0C72C4;
            color: white;
            padding: 5px 10px;
            }
            .highcharts-figure,
            .highcharts-data-table table {
                min-width: 320px;
                max-width: 800px;
                margin: 1em auto;
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #ebebeb;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }

            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }

            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }

            .highcharts-data-table td,
            .highcharts-data-table th,
            .highcharts-data-table caption {
                padding: 0.5em;
            }

            .highcharts-data-table thead tr,
            .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }

            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }

            input[type="number"] {
                min-width: 50px;
            }

        </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
                <section class="masthead">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <div class="container-fluid d-flex justify-content-start">
                                            <div>
                                                <h5>Reporte de Estudiantes Por Ubicación</h5>
                                            </div>
                                        </div><!-- /.container-fluid -->
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="bs-stepper">
                                            <div class="bs-stepper-header" role="tablist">
                                                <!-- your steps here -->
                                                <div class="step" data-target="#logins-part">
                                                  <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
                                                    <span class="bs-stepper-circle">1</span>
                                                    <span class="bs-stepper-label">Identificación</span>
                                                  </button>
                                                </div>
                                                <div class="line"></div>
                                                <div class="step" data-target="#information-part">
                                                  <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
                                                    <span class="bs-stepper-circle">2</span>
                                                    <span class="bs-stepper-label">Datos personales</span>
                                                  </button>
                                                </div>
                                            </div>
                                            <div class="bs-stepper-content">
                                                <form method="post" action="" id="f"> 
                                                    <input type="hidden" name="accion" id="accion">
                                                    <div id="logins-part" class="content active" role="tabpanel" aria-labelledby="logins-part-trigger" style="padding: 3%;">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>País</label>
                                                                    <select class="form-control select2bs4" id="pais" name="pais"
                                                                    style="width: 100%;">
                                                                        <option disabled selected value="0">Seleccione</option>
                                                                    </select>
                                                                    <span id="spais"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Estado</label>
                                                                    <select class="form-control select2bs4" id="estado" name="estado"
                                                                    style="width: 100%;">
                                                                        <option disabled selected value="0">Seleccione</option>
                                                                    </select>
                                                                    <span id="sestado"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a class="btn btn-primary" onclick="next()" style="color: white !important">Siguiente</a>
                                                    </div>
                                                    <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger" style="padding: 3%;">
                                                        <div class="row pb-2">
                                                            <input type="hidden" name="id" id="id">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Área de Emprendimiento</label>
                                                                    <select class="form-control select2bs4" id="area" name="area"
                                                                        style="width: 100%;">
                                                                        <option disabled selected value="0">Seleccione</option>
                                                                    </select>
                                                                    <span id="sarea"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Emprendimiento</label>
                                                                    <select class="form-control select2bs4" id="emprendimiento" name="emprendimiento"
                                                                        style="width: 100%;">
                                                                        <option disabled selected value="0">Seleccione</option>
                                                                    </select>
                                                                    <span id="semprendimiento"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Curso</label>
                                                                    <select class="form-control select2bs4" id="aula" name="aula"
                                                                        style="width: 100%;">
                                                                        <option disabled selected value="0">Seleccione</option>
                                                                    </select>
                                                                    <span id="saula"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" onclick="previous()">Anterior</button>
                                                        <button type="button" id="registrar" class="btn btn-primary" style="color: white !important">Enviar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <figure class="highcharts-figure">
                                                <div id="container"></div>
                                                <p class="highcharts-description">
                                                </p>
                                            </figure> 
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </section>  
        </div>
        <?php include_once 'componentes/footer.php';?>

    </body>
    <script src="plugins/all/js/all.min.js" crossorigin="anonymous"></script> 
    <script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
    <script src="content/js/highcharts.js"></script>
    <script src="content/js/exporting.js"></script>
    <script src="content/js/export-data.js"></script>
    <script src="content/js/accessibility.js"></script>
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="content/js/reportedireccion.js"></script>
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
    </html>
