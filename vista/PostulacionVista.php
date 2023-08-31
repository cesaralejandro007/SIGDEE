<?php
use config\componentes\configSistema as configSistema;
?>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<style>
  .masthead {
  padding-top: 10rem;
  padding-bottom: calc(10rem - 4.5rem);
  background: linear-gradient(to bottom, rgba(158, 153, 151, 0.2) 0%, rgba(168, 161, 158, 0.2) 100%), url("content/imagenes/uptaeb.jpg");
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: scroll;
  background-size: cover;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed "  style="background-color: #508bfc;">
    <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="nav-link text-light" href="?pagina=<?php configSistema::_MD_();?>">Pagina Principal</a>

            </div>
        </nav>
        <section class="masthead">
            <div class="container">
                <div class="row">
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
                              <div class="row pb-2">
                                <input type="hidden" name="id" id="id">
                                <div class="col-md-6">
                                    <label>Primer nombres:</label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="form-control">
                                    <span id="spnombre"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Segundo nombres:</label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control">
                                    <span id="ssnombre"></span>
                                </div>
                              </div>
                              <div class="row pb-2">
                                <div class="col-md-6">
                                    <label>Primer apellido:</label>
                                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control">
                                    <span id="spapellido"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Segundo apellido:</label>
                                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control">
                                    <span id="ssapellido"></span>
                                </div>
                              </div>
                              <div class="row pb-2" >
                              <div class="col-md-4">
                                    <label for="genero">Género:</label>
                                    <select type="select" class="form-control" id="genero" name="genero">
                                        <option value="0">--Seleccione--</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                    <span id="sgenero"></span>
                                </div>
                                  <div class="col-md-4">
                                    <label>Correo:</label>
                                    <input type="email" name="correo" id="correo" class="form-control">
                                    <span id="scorreo"></span>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Teléfono:</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control">
                                    <span id="stelefono"></span>
                                  </div>
                              </div>
                              <div class="form-group row selectores" id="selectores">           
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Pais</label>
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

                              <div class="row pb-4">
                                <div class="col-12">
                                    <label for="message-text" class="col-form-label" for="direccion">Dirección:</label>
                                    <textarea type="text" cols="15" rows="4" name="direccion" id="direccion"
                                        class="form-control"></textarea>
                                    <span id="sdireccion"></span>
                                </div>
                            </div>
                              <hr>
                              <div>
                                <h5>Emprendimientos:</h5>
                                <?php echo $listar_emprendimientos; ?>


                                
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


                              </div>
                              <button class="btn btn-primary" onclick="previous()">Anterior</button>
                              <button type="button" id="registrar" class="btn btn-primary" style="color: white !important">Enviar</button>
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
        <footer class="py-5 bg-dark">
            <div class="container px-4">
                <p class="m-0 text-center text-white">Derechos reservados 2022</p>
            </div>
        </footer>
    </div>
    <script src="plugins/all/js/all.min.js" crossorigin="anonymous"></script> 
    <script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="content/js/postulacion.js"></script>
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
  </body>

</html>