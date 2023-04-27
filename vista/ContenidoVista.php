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
  padding-top: 20px;
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
                <div class="card-header pb-1 px-1">
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                        <div>
                            <h5>Contenidos</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                        <a href="?pagina=principal" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                        <a href="?pagina=Contenido" class="px-1" style="font-size:18px;">Contenido</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body px-2 py-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex">
                                <div>
                                    <?php
if (isset($response[0]["registrar"])) {
    if ($response[0]["registrar"] == 'true') {?>
                                    <button class="btn p-1 my-1 text-white" style="background:#0C72C4" id="nuevo"><i class="fas fa-plus-square mx-1"></i>Registrar
                                        Contenido</button>
                                    <?php }}?>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php

if (isset($response[0]["consultar"])) {
    if ($response[0]["consultar"] == 'true') {?>
                            <div class="card border">
                                <div class="table-responsive-xl p-2">
                                    <div class="d-flex flex-wrap justify-content-between m-1">
                                    </div>
                                    <table id="funcionpaginacion" class="table table-striped table-hover border border-secondary">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Archivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach ($r1 as $valor) {?>
                                            <tr>
                                                <td class="project-actions text-left">
                                                    <div class="d-flex">
                                                        <?php

        if (isset($response[0]["modificar"])) {
            if ($response[0]["modificar"] == 'true') {?>
                                                    <button class="btn mr-2 text-white permisoseditar" style="background:#E67E22;" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Editar"
                                                            onclick="cargar_datos(<?=$valor['id'];?>);"><i
                                                                class="fas fa-edit"></i></button>
                                                        <?php }}?>
                                                        <?php

        if (isset($response[0]["eliminar"])) {
            if ($response[0]["eliminar"] == 'true') {?>
                                                        <button type="button" class="btn mr-2 permisoseliminar" style="background:#9D2323;color:white" 
                                                            onclick="eliminar(<?=$valor['id'];?>);"><i
                                                                class="fas fa-trash"></i></button>
                                                        <?php }}?>
                                                    </div>
                                                </td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['nombre']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['descripcion']; ?></td>
                                                <td class="project-actions text-left">
                                                    <?php echo $valor['archivo_adjunto']; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Archivo</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <?php }}?>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.modal Registrar -->

        <div class="modal fade show" id="gestion-contenido">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="titulo"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="fi" method="post">
                            <input type="hidden" name="accion" id="accion" />
                            <input type="hidden" name="id" id="id" />
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="message-text" class="col-form-label" for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                    <span id="snombre"></span>
                                </div>
                                <div class="col-md-7">
                                    <label for="message-text" class="col-form-label"
                                        for="descripcion">Descripcion:</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                                    <span id="sdescripcion"></span>
                                </div>
                            </div>
                            <div class="form-group row" id="archivo-anterior"
                                style="text-align-last: center; margin: auto; margin: 5%;">
                                <a target="_blank" id="archivo_antes" name="archivo_antes">Ver Archivo Anterior</a>
                                <input type="hidden" name="nombre_antes" id="nombre_antes">
                            </div>
                            <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
                        <div class="file-upload">
                          <button class="file-upload-btn btn btn-outline-secondary ms-1" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Añadir Archivo</button>

                          <div class="image-upload-wrap">
                              <input id="archivo_adjunto" name="archivo_adjunto" class="file-upload-input" type='file' onchange="readURL(this);"/>
                              <div class="drag-text text-secondary">
                                  <h3>Arrastre y suelte un archivo o seleccione agregar archivo</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                            <img class="file-upload-image d-none" src="#" alt="your image" />
                              <div id="icono" class="">
                                
                              </div>
                              <div class="image-title-wrap">
                              <button id="eliminardoc" type="button" onclick="removeUpload()" class="remove-image btn btn-sm" style="color:#9D2323;">Eliminar <span class="image-title">Uploaded Image</span></button>
                              </div>
                          </div>
                        </div>
                            <div class="modal-footer justify-content-between">
                                <input class="btn btn-default" type="reset" value="Limpiar Campos" />
                                <button type="button" id="enviar" class="btn btn-primary">Registrar</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="elementosEncontrados">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo1"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="consulta-base">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <?php include_once 'componentes/footer.php';?>
    <script src="content/js/contenido.js"></script>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
</body>

</html>