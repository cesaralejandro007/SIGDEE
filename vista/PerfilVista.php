<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<style>

.file-upload {

  margin: 0 auto;
  padding: 20px;
}

.file-upload-btn {
    padding: 5px;
    width: 98%;
}

.file-upload-btn:hover {
  transition: all .2s ease;
  cursor: pointer;
}


.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 1px dashed #566573;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  border: 2px dashed #566573;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  padding: 30px 0;
}

.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}


.remove-image:active {
  border: 0;
  transition: all .2s ease;
}
</style>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="card m-2 border border-secondary">
            <section style="background-color: #eee;">
            <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                        <div>
                            <h5>Perfil</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                            <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                            <a href="?pagina=Perfil" class="px-1" style="font-size:18px;">Perfil</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
        <div class="card-header pb-1 px-1">
            <div class="container-fluid">
                <div>
                    <h6 class="p-0 m-2">Foto de perfil</h6>
                </div>
            </div><!-- /.container-fluid -->
        </div>
          <div class="card-body text-center">
          <?php 
                        $directory="content/usuarios/";
                        $dirint = dir($directory);
                        $bandera = false;
                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                        {

                            if($archivo == $_SESSION['usuario']['cedula'].".png"){
                                $imagen1 = $archivo;
                                $bandera = true;
                            }
                            else
                             $imagen1 = "img5.png";
                        }
                        $dirint->close(); 
                    ?>
        <img src= "content/usuarios/<?php echo $imagen1; ?>"  alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px; height:150px;">
            <h5 class="my-3"><?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido'] ?></h5>
            <div class="d-flex justify-content-center mb-2">
            <button class="btn btn-outline-primary m-1 px-2" style="padding:3px"
                    data-toggle="modal" data-target="#foto-perfil"
                    style="cursor: pointer">
                    <i class="fas fa-user-edit"></i> Editar Foto
                </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
        <div class="card-header pb-1 px-1">
            <div class="container-fluid d-flex justify-content-between flex-wrap">
                <div>
                    <h6 class="p-0 m-1">Datos personales</h6>
                </div>
                <div>
                  <button class="btn btn-outline-primary m-1 px-2"  style="padding:3px"
                      onclick="cargar_datos(<?=$infoU[0]['id']?>)" 
                      style="cursor: pointer">
                      <i class="fas fa-user-edit"></i> Editar información
                  </button>
                  <button class="btn btn-outline-primary m-1 px-2"  style="padding:3px"  id="cambiar_clave"
                      style="cursor: pointer">
                      <i class="fas fa-key"></i> Cambiar seguridad
                  </button>
                </div>
            </div><!-- /.container-fluid -->
        </div>
          <div class="card-body">
            <div class="row">
            <?php
            foreach ($infoU as $valor) {?>               
              <div class="col-sm-3">
                <p class="mb-0">Cedula:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['cedula'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Primer nombre:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['primer_nombre'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Segundo nombre:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['segundo_nombre'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Primer apellido</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['primer_apellido'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Segundo apellido</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['segundo_apellido'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Genero</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['genero'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Telefono:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['telefono'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Correo:</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $valor['correo'] ?></p>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
    </div>
  </div>
</section>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.modal Registrar -->
        <div class="modal fade show" id="gestion-modulo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo">Modificar datos de perfil</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="f">
                            <div class="modal-body">
                                <input type="hidden" class="form-control" id="id">
                                <div class="input-group">
                                    <span class="input-group-text">Correo:</span>
                                    <input type="text" class="form-control" id="correo">
                                </div>
                                <span id="scorreo"></span>
                                <div class="input-group mt-2">
                                    <span class="input-group-text">Telefono:</span>
                                    <input type="text" class="form-control" id="telefono">
                                </div>
                                <div class="input-group mt-2 d-none">
                                    <span class="input-group-text">Usuario:</span>
                                    <input type="text" class="form-control" id="user">
                                </div>
                                <span id="stelefono"></span>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <input class="btn btn-default" type="reset" onclick="limpiar()"
                                    value="Limpiar Campos" />
                                <button type="button" class="btn btn-primary" id="modificarp">Modificar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <div class="modal fade show" id="cambiar_clave">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo">Varificación de clave</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" id="f">
                            <div class="modal-body">
                            <div class="input-group mt-1">
                          <div class="input-group-text bg-light">
                            <i class="fas fa-key"></i>
                          </div>
                          <input id="Password_actual"
                            class="form-control bg-light"
                            type="password"
                            placeholder="Ingrese su clave actual"
                            />
                          <div class="input-group-append">
                            <button id="show_password" class="btn border
                              border-left-0" type="button"
                              onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:18px"></i>
                          </div>
                        </div>
                            </div>
                            <div class="modal-footer justify-content-end">
                                <button type="button" class="btn btn-primary" id="verificar">Siguiente</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <div class="modal fade show" id="foto-perfil">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo">Modificar foto de perfil</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <form action="" method="post" id="f1">
                        <input type="hidden" name="cedula_usuario" id="cedula_usuario_foto"
                        value="<?php echo $_SESSION['usuario']['cedula'] ?>" />
                            <div class="modal-body">
                            <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                        <div class="file-upload">
                        <button class="file-upload-btn btn btn-outline-secondary ms-1" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Añadir imagen</button>

                        <div class="image-upload-wrap">
                            <input id="archivo_adjunto" name="archivo_adjunto" class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
                            <div class="drag-text text-secondary">
                            <h3>Arrastre y suelte un archivo o seleccione agregar imagen</h3>
                            </div>
                        </div>
                        <div class="file-upload-content">
                            <img class="file-upload-image" src="#" alt="your image" />
                            <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image btn btn-sm" style="color:#9D2323;">Eliminar <span class="image-title">Uploaded Image</span></button>
                            </div>
                        </div>
                        </div>
                            <div class="modal-footer justify-content-end">
                                <button type="button" class="btn btn-primary" id="modificarf">Modificar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </div>
</div>
          <?php include_once('componentes/footer.php'); ?>
            <script src="content/js/perfil.js"></script>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- Bootstrap 4 -->




    <!-- Page specific script -->
</body>

</html>