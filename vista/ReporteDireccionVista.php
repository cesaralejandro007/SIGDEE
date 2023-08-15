<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>

        <style type="text/css">
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
            <div class="card m-2 border border-dark">
                <div class="card-header">
                    <div class="container-fluid d-flex justify-content-start">
                        <div>
                            <h5>Reporte de Estudiantes Por Ubicación</h5>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group row selectores" id="selectores">
                            <fieldset>
                                <div class="row">
                                    <legend>Ubicación</legend>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>País</label>
                                            <select class="form-control select2bs4" id="pais" name="pais"
                                            style="width: 100%;">
                                                <option disabled selected value="0">Seleccione</option>
                                            </select>
                                            <span id="spais"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select class="form-control select2bs4" id="estado" name="estado"
                                            style="width: 100%;">
                                                <option disabled selected value="0">Seleccione</option>
                                            </select>
                                            <span id="sestado"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Ciudad</label>
                                            <select class="form-control select2bs4" id="ciudad" name="ciudad"
                                            style="width: 100%;">
                                                <option disabled selected value="0">Seleccione</option>
                                            </select>
                                            <span id="sciudad"></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mt-4">
                                <div class="row">
                                    <legend>Curso</legend>
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
                            </fieldset>
                        </div>
                        <div>
                           <figure class="highcharts-figure">
                                <div id="container"></div>
                                <p class="highcharts-description">
                                    
                                </p>
                            </figure> 
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
        <?php include_once 'componentes/footer.php';?>
        </div>
    </body>
    <script src="content/js/highcharts.js"></script>
    <script src="content/js/exporting.js"></script>
    <script src="content/js/export-data.js"></script>
    <script src="content/js/accessibility.js"></script>
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
