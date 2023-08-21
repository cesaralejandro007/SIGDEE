<?php
use config\componentes\configSistema as configSistema;
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->

        <!-- /.modal Registrar -->
        <div class="content-wrapper">
            <div class="card m-2 border border-dark">
                <div class="card-header">
                    <div class="container-fluid d-flex justify-content-between flex-wrap">
                        <div>
                            <h5>Evaluación</h5>
                        </div>
                        <div class="d-flex flex-wrap">
                            <a href="?pagina=<?php configSistema::_M01_();?>" class="text-secondary px-1" style="font-size:18px;">Inicio</a>
                            <a href="javascript:history.back()" class="text-secondary px-1" style="font-size:18px;">Unidad</a>
                            <a href="#" class="px-1" style="font-size:18px;">Evaluación</a>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- Main content -->
                <div class="card-body">
                    <div class="row">
                        <!-- INICIO EVALUACION -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-text-width"></i><?php echo $mostrar_unidad[0]['nombre']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <blockquote>
                                        <p><?php echo $mostrar_unidad[0]['descripcion']; ?></p>
                                        <p><strong>Fecha de apertura: </strong><?=date('d-m-Y h:i:s', strtotime($mostrar_unidad[0]['inicio'])); ?> <br></p>
                                        <p><strong>Fecha de cierre:</strong> <?=date('d-m-Y h:i:s', strtotime($mostrar_unidad[0]['cierre'])); ?></p>
                                        <?php echo $examen; ?>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <!-- FIN EVALUACION -->
                        <?php 
                         if($status ==  2){ ?>
                        <!-- INICIO ENTREGA -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-text-width"></i>Entrega de Evaluación</h3>
                                    <?php echo $mostrar_estudiante_evaluacion!=null ? 
                                    '<button type="button" class="float-right btn btn-secondary btn-sm" onclick="cargar_datos('.$id.');">Modificar</button><button type="button" class="d-none float-right btn btn-secondary btn-sm" onclick="entregar()">Entregar</button>' :
                                    '<button type="button" class="float-right btn btn-secondary btn-sm" onclick="entregar()">Entregar</button><button type="button" class="d-none float-right btn btn-secondary btn-sm" onclick="cargar_datos('.$id.');">Modificar</button>' ?>
                                </div>
                                <div class="card-body clearfix">
                                    <blockquote class="quote-secondary">
                                        <p><?php echo $nombre_evaluacion_entregada; ?></p>
                                        <p><strong>Fecha de entrega: </strong><?php echo $fecha_entrega; ?> <br></p>
                                        <p><strong>Descripción:</strong> <?php echo $descripcion_evaluacion; ?></p>
                                        <p><strong>Calificación:</strong> <?php $nota = $calificacion != null ? $calificacion : 'No han calificado la evaluación'; echo $nota; ?></p>
                                        <?php echo $archivo_evaluacion; ?>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <!-- FIN ENTREGA -->
                        <?php } 
                        if($status ==  0){ ?>
                        <!-- INICIO RETROALIMENTACION-->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-text-width"></i>Entregas</h3>
                                </div>
                                <div class="card-body">
                                   <div class="card border border-secondary">
                                      <div class="table-responsive-xl p-2">
                                        <div class="d-flex flex-wrap justify-content-between m-1">
                                        </div>
                                        <table id="funcionpaginacion" class="table table-bordered table-hover">
                                          <thead>
                                            <tr>
                                              <th>Opciones</th>
                                              <th>Cedula</th>
                                              <th>Estudiante</th>                      
                                              <th>Descripción de entrega</th>                      
                                              <th>Fecha de entrega</th>                      
                                              <th>Archivo adjunto</th>                      
                                              <th>Calificación</th>                      
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php foreach ($entregas as $valor) {
                                            $nota = ($valor['calificacion']==0) ? '<p style="color:red;">Sin Calificar</p>' : $valor['calificacion'];  ?>
                                              <tr>
                                                <td class="project-actions text-left" style="width:10%;">
                                                  <div class="d-flex">
                                                    <button class="btn btn-sm" onclick="revisar_calificacion(<?=$valor['id_evaluacion'];?>)"><i class="fas fa-edit"></i>Revisar</button>
                                                  </div>
                                                </td>
                                                <td><?php echo $valor['cedula'];?></td>
                                                <td><?php echo $valor['nombre_estudiante']; ?></td>
                                                <td><?php echo $valor['descripcion_evaluacion'];?></td>
                                                <td><?php echo date('d-m-Y h:i:s', strtotime($valor['fecha']));?></td>                       
                                                <td><?php echo '<a target="_blank" href="'.$url_base.'/content/entregas/'.$mostrar_unidad[0]['id'].'/'.$valor['archivo'].'"> Visualizar <i class="fas fa-eye"></i></a>'; ?></td>                       
                                                <td><?php echo $nota;?></td>                       
                                              </tr>
                                            <?php } ?>
                                          </tbody>
                                        </table>
                                      </div>
                                          <!-- /.card-body -->
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <!-- FIN RETROALIMENTACION-->
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--MODAL ENTREGA EVALUACION-->
    <div class="modal fade show" id="gestion-entrega">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="fi" method="post" enctype='multipart/form-data'>  
                        <input type="hidden" name="accion" id="accion"/>
                        <input type="hidden" name="id" id="id"/>
                        <input type="hidden" value="<?=$_SESSION['usuario']['id']?>" name="id_estudiante" id="id_estudiante"/>
                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
                            </div>
                            <span id="sdescripcion"></span>
                        </div>
                        <div class="form-group row" id="archivo-anterior"  style="text-align-last: center; margin: auto; margin: 5%;">                             
                                <a  target="_blank" id="archivo_antes" name="archivo_antes">Ver Archivo Anterior</a>  
                        </div>
                        <div class="form-group row">
                            <label for="archivo_adjunto" class="col-sm-3 col-form-label">Archivo Nuevo</label>
                            <div class="col-sm-9">                                
                                <input type="file" class="form-control" id="archivo_adjunto" name="archivo_adjunto">
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <input class="btn btn-default" type="reset" value="Limpiar Campos"/>
                            <button type="button" onclick="enviar()" class="btn btn-primary">Entregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--FIN MODAL ENTREGA EVALUACION-->

    <!--MODAL ENTREGA EVALUACION-->
    <div class="modal fade show" id="gestion-calificar">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="estudiante"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="fi" method="post" enctype='multipart/form-data'>  
                        <input type="hidden" name="id" id="id"/>
                        <div class="form-group row">
                            <label for="calificacion" class="col-sm-3 col-form-label">Calificación</label>
                            <div class="col-sm-9">
                                <input type="number" max="20" min="0" name="calificacion" id="calificacion"/>
                            </div>
                            <span id="scalificacion"></span>
                        </div>
                        
                        <div class="modal-footer justify-content-between">
                            <input class="btn btn-default" type="reset" value="Limpiar Campos"/>
                            <button type="button" onclick="calificar()" class="btn btn-primary">Calificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--FIN MODAL ENTREGA EVALUACION-->
<?php include_once 'componentes/footer.php';?>
<script src="content/js/mostrarEvaluacion.js"></script>

</script>
</body>

</html>