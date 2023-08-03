<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" type="text/css" href="assets/css/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/home.css">

<style type="text/css">
    .content-wrapper{
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center center;
        background-blend-mode: darken;
    }
    body {overflow-x:hidden!important;}
</style>


<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include_once 'componentes/panel_nav.php';?>
    <?php include_once 'componentes/panel_sidenav.php';?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <h1 class="m-0">Página Principal</h1>
        <div class="row">
          <div class="col-md-12" style="margin-top:30px;">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  Diplomados
                </h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-info" style="background:#0D47AD !important;">
                        <h3 class="widget-user-username">Filosofia de Gestión</h3>
                        <h5 class="widget-user-desc">Cesar Vides</h5>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="content/usuarios/28055655.png" alt="User Avatar">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">12</h5>
                              <span class="description-text" style="font-size: 10px !important;">Estudiantes</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">3</h5>
                              <span class="description-text" style="font-size: 10px !important;">Contenidos</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4">
                            <div class="description-block">
                              <h5 class="description-header">2</h5>
                              <span class="description-text" style="font-size: 10px !important;">Evaluaciones</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                    </div>
                    <!-- /.widget-user -->
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info" style="background:#0D47AD !important;">
                  <div class="inner">
                    <h2>Batender</h2>
                    <p>15 Estudiantes</p>

                  </div>
                  <a href="#" class="small-box-footer">
                    Ir al diplomado <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>


            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="margin-top:30px;">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  Calendario
                </h3>  
              </div>
              <div class="card-body">
              <?php
                  $usuario  = "root";
                  $password = "";
                  $servidor = "localhost";
                  $basededatos = "bdsystem";
                  $con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
                  $db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

                  $SqlEventos   = ("SELECT ue.id as id, a.nombre as aula, un.nombre as unidad, e.nombre as nombre, e.descripcion as descripcion, ue.fecha_inicio, ue.fecha_cierre from usuario u inner join aula_estudiante ae on u.id= ae.id_estudiante inner join aula a on ae.id_aula= a.id inner join unidad un on un.id_aula= a.id inner join unidad_evaluaciones ue on ue.id_unidad = un.id inner join evaluaciones as e on e.id= ue.id_evaluacion where u.id = ".$_SESSION['usuario']['id']."");
                  $resulEventos = mysqli_query($con, $SqlEventos);
                ?>
                <div id="calendar"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



<div class="modal" id="modalUpdateEvento"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Actividad Pendiente</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  <form name="formEventoUpdate" id="formEventoUpdate" action="UpdateEvento.php" class="form-horizontal" method="POST">
    <input type="hidden" class="form-control" name="idEvento" id="idEvento">
    <div class="form-group">
      <label for="evento" class="col-sm-12 control-label">Nombre de la evaluacion</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="evento" id="evento" placeholder="Nombre del Evento" required/>
      </div>
    </div>
    <div class="form-group">
      <label for="fecha_fin" class="col-sm-12 control-label">Fecha Final</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-10">
        <a id="referencia" href="">Ir a la evaluación</a>
      </div>
    </div>
  </form>
      
    </div>
  </div>
</div>

                       
<?php include_once 'componentes/footer.php';?>
<script src="assets/js/popper.min.js"></script>
<script type="text/javascript" src="assets/js/moment.min.js"></script>  

<script type="text/javascript" src="assets/js/fullcalendar.min.js"></script>
<script src='assets/locales/es.js'></script>


        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
</body>
<script>
  $(document).ready(function() {
  $("#calendar").fullCalendar({
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay"
    },

    locale: 'es',

    defaultView: "month",
    navLinks: false, 
    editable: false,
    eventLimit: true, 
    selectable: true,
    selectHelper: false,
      
    events: [
      <?php
       while($dataEvento = mysqli_fetch_array($resulEventos)){ ?>
          {
          _id: '<?php echo $dataEvento['id']; ?>',
          title: '<?php echo $dataEvento['nombre']; ?>',
          start: '<?php echo '2023-07-25 09:00:00'; ?>',
          end:   '<?php echo $dataEvento['fecha_cierre']; ?>',  
          color: '#0D47AD'
          },
        <?php } ?>
    ],


//Modificar Evento del Calendario 
eventClick:function(event){
    var idEvento = event._id;
    $('input[name=idEvento').val(idEvento);
    $('input[name=evento').val(event.title);
    $('input[name=fecha_fin').val(event.end.format("DD-MM-YYYY"));
    document.getElementById("referencia").href =
        "?pagina=MostrarEvaluacion&id_unidad_evaluacion=" + event._id;
    $("#modalUpdateEvento").modal();
  },


  });



});

</script>
</html>