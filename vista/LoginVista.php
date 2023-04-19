<html lang="en">
  <?php include_once 'componentes/head.php';?>
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
    <body class="hold-transition sidebar-mini">
      <div class="wrapper">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"
          id="mainNav">
          <div class="container px-4">
            <a class="nav-link text-light" href="?pagina=Diplomado">Pagina
              Principal</a>

          </div>
        </nav>
        <section class="masthead vh-100">
          <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center
            h-100">
            <div class="card col-10 col-md-7 col-lg-5 col-xl-4">
                <div class="card-header text-center">
                          <h2 class="m-0 font-weight-bold" style="font-family:Arial, Helvetica, sans-serif">SIGDEE</h2>
                      </div>
                <div class="card-body px-4 ">
                  <div id="mensajedecorreo">
                  </div>
                  <div class="d-flex justify-content-center">
                    <img
                      src="assets/font/login-icon.svg"
                      alt="login-icon"
                      style="height: 6rem"
                      />
                  </div>
                  <div class="text-center fs-5">Iniciar Sesión</div>
                  <div class="input-group mt-4">
                    <div class="input-group-text bg-light">
                      <i class="fas fa-user-tag"></i>
                    </div>
                        <select class="custom-select" id="tipodeusuario">
                        <option value="0" disabled selected>--Seleccione rol--</option>
                        <?php foreach ($r2 as $key=> $value) {?>
                            <option value="<?=$value['nombre'];?>"> <?php echo
                                $value['nombre']; ?>
                            </option>
                            <?php }?>
                        </select>
                        </div>
                        <div class="input-group mt-1">
                          <div class="input-group-text bg-light">
                            <i class="fas fa-user"></i>
                          </div>
                          <input id="floatingInput"
                            class="form-control bg-light"
                            type="text"
                            placeholder="Usuario"
                            />
                        </div>
                        <div class="input-group mt-1">
                          <div class="input-group-text bg-light">
                            <i class="fas fa-key"></i>
                          </div>
                          <input id="floatingPassword"
                            class="form-control bg-light"
                            type="password"
                            placeholder="Clave"
                            />
                          <div class="input-group-append">
                            <button id="show_password" class="btn border
                              border-left-0" type="button"
                              onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:21px"></i>
                          </div>
                        </div>
                        <button class="btn btn-primary text-white w-100 mt-4
                          fw-semibold shadow-sm" id="entrar" type="submit">Entrar</button>
                        <div class="d-flex justify-content-center"><button
                            class="btn btn-bs text-primary"
                            id="recuperarcontrasena">Recuperar contraseña</button></div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="gestion-recuperar" tabindex="-1"
                  aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Preguntas
                          de seguridad</h1>
                        <button type="button" class="btn-close"
                          data-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="input-group mb-3">
                          <span class="input-group-text"
                            id="inputGroup-sizing-default">Usuario:</span>
                          <input type="text" class="form-control"
                            aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default"
                            id="usuarior">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text"
                            id="inputGroup-sizing-default">Nombre:</span>
                          <input type="text" class="form-control"
                            aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default"
                            id="nombrer">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text"
                            id="inputGroup-sizing-default">Apellido:</span>
                          <input type="text" class="form-control"
                            aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default"
                            id="apellidor">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text"
                            id="inputGroup-sizing-default">Correo:</span>
                          <input type="text" class="form-control"
                            aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default"
                            id="correor">
                        </div>
                        <div class="input-group mb-3">
                          <span class="input-group-text"
                            id="inputGroup-sizing-default">Telefono:</span>
                          <input type="text" class="form-control"
                            aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default"
                            id="telefonor">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                          id="recuperarc">Recuperar</button>
                      </div>
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
            <script src="content/js/login.js"></script>
          </body>

        </html>