<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="nav-link text-light" href="?pagina=Diplomado">Pagina Principal</a>

            </div>
        </nav>
        <section class="vh-100" style="background-color: #508bfc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                  <div class="col-md-12">
                    <div class="card card-default">
                      <div class="card-header">
                        <h3 class="card-title">Proceso de Postulación</h3>
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
                              <div class="form-group col-md-6">
                                <label for="scedula">Cedula</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Indique su cedula. Ejemplo V-1234567">
                                <span id="scedula"></span>
                              </div>
                              <a class="btn btn-primary" onclick="next()" style="color: white !important">Siguiente</a>
                            </div>
                            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger" style="padding: 3%;">
                              <div class="row">
                                <input type="hidden" name="id" id="id">
                                <div class="col-md-6">
                                    <label>Nombres</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                    <span id="snombre"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Apellido</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control">
                                    <span id="sapellido"></span>
                                </div>
                              </div>
                              <div class="row pb-4" >
                                  <div class="col-4">
                                    <label>Correo</label>
                                    <input type="email" name="correo" id="correo" class="form-control">
                                    <span id="scorreo"></span>
                                  </div>
                                  <div class="col-4">
                                    <label>Telefono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                    <span id="scorreo"></span>
                                  </div>
                                  <div class="col-4">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control">
                                    <span id="scorreo"></span>
                                  </div>
                              </div>
                              <hr>
                              <div>
                                <h5>Emprendimientos</h5>
                                <?php echo $listar_emprendimientos; ?>
                              </div>
                              <button class="btn btn-primary" onclick="previous()">Anterior</button>
                              <a type="button" id="registrar" class="btn btn-primary" style="color: white !important">Enviar</a>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        Una vez que sea enviada esta información, se verificaran los datos y se le estará notificando los resultados por correo.
                      </div>
                    </div>
                    <!-- /.card -->
                  </div>
                </div>
            </div>
        </section>
    </div>
    <script src="plugins/all/js/all.min.js" crossorigin="anonymous"></script> 
    <script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="content/js/postulacion.js"></script>
</body>

</html>