<?php
use config\componentes\configSistema as configSistema;
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        <div class="card m-2 border border-secondary">
                <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                        <div>
                            <h5>Aulas</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=<?php configSistema::_M01_();?>" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="#" class="px-1" style="font-size:18px;">Aula</a>
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
                                    <h3 class="card-title p-3"><?php echo $datos[0]['nombre']; ?></h3>
                                    <ul class="nav nav-pills ml-auto p-2">
                                        <li class="nav-item"><a class="nav-link active mx-1" href="#unidades"
                                                data-toggle="tab">Unidades</a></li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#participantes"
                                                data-toggle="tab">Participantes</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                                                style="cursor: pointer">
                                                Foro <span class="caret"></span>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" id="comentarforo" href="#comentarios"
                                                    data-toggle="tab">Publicaciones</a>
                                                <a class="dropdown-item" id="publicarforo"
                                                    href="#comentarios">Publicar</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="unidades">
                                            <div class="d-flex">
                                                <?php if (isset($unidadpermisos[0]["registrar"])) {
    if ($unidadpermisos[0]["registrar"] == 'true') {?>
                                                <button class="btn btn-primary m-1" id="nuevo">Crear Unidad</button>
                                                <?php }}?>
                                            </div>
                                            <div style="margin-top:4%;">
                                                <?php if (isset($unidadpermisos[0]["consultar"])) {
                                                if ($unidadpermisos[0]["consultar"] == 'true') {?>
                                                <?php foreach ($listar_unidad as $unidad) {?>
                                                                                                    <div class="callout callout-info d-flex d-flex justify-content-between">
                                                        <a class="text-dark" style="width: 100%; height: 100%; text-decoration: none;" href="?pagina=<?php configSistema::_MUNIDAD_($unidad['id']);?>">
                                                            <div>
                                                                <h5><?php echo $unidad['unidad']; ?></h5>

                                                                <p><?php echo $unidad['descripcion'] ?>.</p>
                                                            </div>
                                                            <div>
                                                                <ul class="nav nav-pills ml-auto ">
                                                                    <li class="nav-item dropdown">
                                                                        <a class="nav-link"  style="width: 100%; height: 100%; text-decoration: none;" data-toggle="dropdown"
                                                                            style="cursor: pointer">
                                                                            <i class="fas fa-ellipsis-h"></i></i><span
                                                                                class="caret"></span>
                                                                        </a>
                                                                        <div class="dropdown-menu">
                                                                            <div class="d-flex flex-column">
                                                                                <?php
                                                                if (isset($unidadpermisos[0]["modificar"])) {
                                                                    if ($unidadpermisos[0]["modificar"] == 'true') {?>
                                                                                <a class="d-flex btn btn-sm" style="text-decoration: none;" onclick="cargar_datos_Unidad(<?=$unidad['id'];?>);">Editar</a>
                                                                                <?php }}
                                                                if (isset($unidadpermisos[0]["eliminar"])) {
                                                                    if ($unidadpermisos[0]["eliminar"] == 'true') {?>
                                                                                <a class="d-flex btn btn-sm" style="text-decoration: none;"
                                                                                    type="button"
                                                                                    onclick="eliminarUnidad(<?=$unidad['id'];?>);">Eliminar</a>
                                                                        <?php }}?>      
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php }?>
                                                    <?php }else{
                                                        echo '<div class="alert alert-danger" role="alert">No tiene permisos para consultar este modulo.</div>';
                                                    }}?>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane table-responsive" id="participantes">
                                            <div class="card-body p-0">
                                              <table id="funcionpaginacion" class="table table-striped projects">
                                                  <thead>
                                                      <tr>
                                                          <th style="width: 20%">
                                                              Foto de perfil
                                                          </th>
                                                          <th style="width: 35%">
                                                              Cedula
                                                          </th>
                                                          <th style="width: 40%">
                                                              Nombre y Apellido
                                                          </th>
                                                          <th style="width: 5%" class="text-center">
                                                              Rol
                                                          </th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                     <?php foreach ($docentes as $docente) {
                                                        $directory="content/usuarios/";
                                                        $dirint = dir($directory);
                                                        $bandera = false;
                                                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                                                        {

                                                            if($archivo == $docente['cedula'].".png"){
                                                                $imagen = $archivo;
                                                                $bandera = true;
                                                            }
                                                            else
                                                             $imagen = "img5.png";
                                                        }
                                                        $dirint->close();?>
                                                      <tr>
                                                          <td>
                                                              <ul class="list-inline">
                                                                  <li class="list-inline-item">
                                                                      <img width="90" class="img-fluid rounded-circle border border-dark" src="content/usuarios/<?php echo $imagen ?>">
                                                                  </li>
                                                              </ul>
                                                          </td>
                                                          <td>
                                                              <?php echo $docente['cedula']; $imagen = "";?>
                                                          </td>
                                                          <td>
                                                              <a>
                                                                  <?php echo $docente['nombre'] .' '.$docente['apellido']; ?>
                                                              </a>
                                                          </td>
                                                          <td class="project-state">
                                                              <label>Docente</label>
                                                          </td>
                                                      </tr>
                                                    <?php } ?>
                                                      <?php foreach ($estudiantes as $estudiante) {
                                                        $directory="content/usuarios/";
                                                        $dirint = dir($directory);
                                                        $bandera = false;
                                                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                                                        {

                                                            if($archivo == $estudiante['cedula'].".png"){
                                                                $imagen = $archivo;
                                                                $bandera = true;
                                                            }
                                                            else
                                                             $imagen = "img5.png";
                                                        }
                                                        $dirint->close();?>
                                                      <tr>
                                                          <td>
                                                              <ul class="list-inline">
                                                                  <li class="list-inline-item">
                                                                      <img width="90" class="img-fluid rounded-circle border border-dark" src="content/usuarios/<?php echo $imagen ?>">
                                                                  </li>
                                                              </ul>
                                                          </td>
                                                          <td>
                                                              <?php echo $estudiante['cedula']; $imagen = "";?>
                                                          </td>
                                                          <td>
                                                              <a>
                                                                  <?php echo $estudiante['nombre'] .' '.$estudiante['apellido']; ?>
                                                              </a>
                                                          </td>
                                                          <td class="project-state">
                                                              <label>Estudiante</label>
                                                          </td>
                                                      </tr>
                                                    <?php } ?>
                                                    </tbody>
                                              </table>
                                            </div>
                                        </div>
                                        <div class="modal fade show" id="gestion-unidad">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="titulo"></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" id="fi" method="post">
                                                            <input type="hidden" name="accion" id="accion" />
                                                            <input type="hidden" name="id" id="id" />
                                                            <input type="hidden" name="aula_id" id="aula_id"
                                                                value="<?=$datos[0]['id'];?>" />
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <label for="message-text" class="col-form-label"
                                                                        for="nombre">Nombre:</label>
                                                                    <input type="text" name="nombre" id="nombre"
                                                                        class="form-control">
                                                                    <span id="snombre"></span>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="message-text" class="col-form-label"
                                                                        for="descripcion">Descripcion:</label>
                                                                    <textarea type="text" cols="10" rows="2"
                                                                        name="descripcion" id="descripcion"
                                                                        class="form-control"></textarea>
                                                                    <span id="sdescripcion"></span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <input class="btn btn-default" type="reset"
                                                                    onclick="limpiar1()" value="Limpiar Campos" />
                                                                <button type="button" id="enviar"
                                                                    class="btn btn-primary">Registrar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="modal fade show" id="gestion-foro">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="tituloprincipal"></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="accion" id="accion" />
                                                        <input type="hidden" name="id" id="id" />
                                                        <input type="hidden" name="cedula_usuario" id="cedula_usuario"
                                                            value="<?php echo $_SESSION['usuario']["cedula"]?>" />
                                                        <div class="form-group row">
                                                            <label for="titulo"
                                                                class="col-sm-2 col-form-label">Titulo</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control"
                                                                    id="titulopublic">
                                                                <span id="stitulopublic"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="mensaje"
                                                                class="col-sm-2 col-form-label">Mensaje</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" id="mensaje"></textarea>
                                                                <span id="smensaje"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-10">
                                                                <input type="hidden" class="form-control"
                                                                    value="<?=$datos[0]['id']?>" id="id_aula">
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" id="enviarforo"
                                                                class="btn btn-primary"></button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="comentarios">
                                            <div class="post clearfix">

                                                <?php
if (isset($x)) {
    if ($x == 'falso') {
        echo 'No hay publicaciones disponibles...';
    }} else {
    foreach ($publicaciones as $datos) {?>
                                                <div class="user-block">
                                                <?php 
                        $directory="content/usuarios/";
                        $dirint = dir($directory);
                        $bandera = false;
                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                        {

                            if($archivo == $datos['cedula'].".png"){
                                $imagen = $archivo;
                                $bandera = true;
                            }
                            else
                             $imagen = "img5.png";
                        }
                        $dirint->close(); 
                    ?>                                                

                                                    <img class="img-circle img-bordered-sm"
                                                        src="content/usuarios/<?php echo $imagen;?>" alt="User">
                                                    <span class="username">
                                                        <a
                                                            href="#"><?php echo $datos['nombre'] . ' ' . $datos['apellido']; ?></a>
                                                        <div class="float-right btn-tool">

                                                            <ul class="nav nav-pills ml-auto">
                                                                <?php if ($datos['cedula'] == $_SESSION['usuario']["cedula"]) {?>

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
                                                                                onclick="cargar_datos(<?=$datos['id'];?>);">Editar</a>
                                                                            <a class="d-flex btn btn-sm"
                                                                                href="#comentarios" type="button"
                                                                                onclick="eliminar(<?=$datos['id'];?>);">Eliminar</a>
                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <?php }?>
                                                            </ul>

                                                        </div>
                                                    </span>
                                                    <span class="description"
                                                        id="fecha1"><?php echo $datos['fecha']; ?></span>
                                                </div>
                                                <!-- /.user-block -->
                                                <h4><?php echo $datos['titulo']; ?></h4>
                                                <p><?php echo $datos['mensaje']; ?></p>

                                                <div class="accordion accordion-flush mx-3 my-2 border border-primary rounded"
                                                    id="accordionFlushExample<?php echo $datos['id']; ?>">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                            <button class="accordion-button collapsed" type="button"
                                                                id="cantidad<?php echo $datos['id']; ?>"
                                                                onclick="cargarcomentarios(<?=$datos['id'];?>);"
                                                                data-toggle="collapse"
                                                                data-target="#flush-collapseOne<?php echo $datos['id']; ?>"
                                                                aria-expanded="false"
                                                                aria-controls="flush-collapseOne<?php echo $datos['id']; ?>">
                                                                <i class=" far fa-comments mr-1"></i>
                                                                comentarios
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapseOne<?php echo $datos['id']; ?>"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="flush-headingOne"
                                                            data-parent="#accordionFlushExample<?php echo $datos['id']; ?>">
                                                            <div class="accordion-body"
                                                                id="resulcoment<?php echo $datos['id']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form class=" form-horizontal">
                                                    <input type="hidden" name="accion"
                                                        id="accion-<?php echo $datos['id']; ?>" value="comentar" />
                                                    <input type="hidden" class="idc" name="idc" id="idc"
                                                        value="<?php echo $datos['id']; ?>" />
                                                    <input type="hidden" name="cedula_usuarioc" id="cedula_usuarioc"
                                                        value="<?php echo $_SESSION['usuario']["cedula"] ?>" />
                                                    <div class="input-group input-group-sm mb-0 mx-1">
                                                        <input class="form-control form-control-sm"
                                                            id="comentario-<?php echo $datos['id']; ?>"
                                                            placeholder="Responder">
                                                        <div class="input-group-append">
                                                            <button type="button"
                                                                onclick="comentar(<?=$datos['id'];?>);"
                                                                id="enviarcomentario-<?php echo $datos['id']; ?>"
                                                                class="btn btn-primary">Responder</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <hr style="color: #1B2631;" />
                                                <?php }}?>
                                            </div>
                                        </div>

                                        <div class="modal fade show" id="gestion-comentario">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="tituloprincipalc"></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="accion" id="accioncomentario" />
                                                        <input type="hidden" name="iddecomentario"
                                                            id="iddecomentario1" />
                                                        <div class="form-group row">
                                                            <label for="mensaje"
                                                                class="col-sm-2 col-form-label">Mensaje</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control"
                                                                    id="resultadocomentario"></textarea>
                                                                <span id="smensaje1"></span>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" id="enviarcomentario1"
                                                                class="btn btn-primary"></button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- ./card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.row -->
            </div>
        </div>
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
    <script src="content/js/mostrarAula.js"></script>
    <script src="content/js/publicaciones.js"></script>
    <script src="content/js/comentarios.js"></script>
    <script src="content/js/participantes.js"></script>

</body>

</html>