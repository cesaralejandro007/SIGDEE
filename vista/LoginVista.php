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
                              onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:18px"></i>
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


<div id="gestion-recuperar" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">Recuperación de contraseña</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" enctype="multipart/form-data" action="" name="" id="cambioForm">
				<div class="modal-body">
					<div class="panel-body">

						<h5 class="modal-title text-center" style="margin-bottom: 8px;">Datos del usuario</h5>

						<input type="number" class="form-control input-number" placeholder="Ingrese su cédula" id="cedulaEmergente" name="cedulaEmergente" />
						<div id="textoCedula" style='color:red; text-align:center;'></div>

						<br>
                        <div id='info' style='display:none'>
						<h5 class="modal-title text-center" style="margin-bottom: 8px;">Preguntas de seguridad</h5>

						<input type="text" class="form-control validar-letras validar-simbolos" id="mascota" name="mascota" placeholder="Nombre de su primera mascota" style="margin-bottom: 4px;">
						<div id="textoMascota" style='color:red'></div>
						<br>

						<div class="">
							<input class="form-control select" style="margin-bottom: 4px;" placeholder="Escriba su animal favorito" id="animFav" name="animFav">

						</div>
						<div id="textoAnimFav" style='color:red'></div>
						<br>

						<div>
							<input class="form-control validar-letras validar-simbolos" id="colorFav" placeholder='Escriba su color favorito' name="colorFav">

						</div>
						<div id="textoColorFav" style='color:red'></div>

						</br>

						<h5 class="modal-title text-center" style="margin-bottom: 8px;">Nueva contraseña</h5>


						<input type="password" class="form-control espacios" name="passwordEmergente" id="passwordEmergente" placeholder="Contraseña" style="margin-bottom: 4px;">
						<div id="textoClave1" style='color:red'></div>
						<input type="password" class="form-control espacios" name="passwordEmergente2" id="passwordEmergente2" placeholder="Confirmar contraseña">


						<div id="textoClave2" style='color:red'></div>

					</div>
				</div>
				<div class="modal-footer">
					<input type="button" value="Consultar" class="btn btn-primary " id="modificarContrasenia" />
				</div>
			</form>
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