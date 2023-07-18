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
        <div class="row">
          <h1 class="m-0">Página Principal</h1>
          <div class="col-md-8" style="margin-top:30px;">
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
                  $basededatos = "practicas";
                  $con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
                  $db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

                  $SqlEventos   = ("SELECT * FROM eventoscalendar");
                  $resulEventos = mysqli_query($con, $SqlEventos);
                ?>
                <div id="calendar"></div>
              </div>
            </div>
          </div>

          <div class="col-md-4" style="margin-top:30px;">
            <!-- Line chart -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  Aulas
                </h3>
              </div>
              <div class="card-body">
                <div id="line-chart" style="height: 300px;"></div>
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
      <label for="fecha_inicio" class="col-sm-12 control-label">Fecha Inicio</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio">
      </div>
    </div>
    <div class="form-group">
      <label for="fecha_fin" class="col-sm-12 control-label">Fecha Final</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="Fecha Final">
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

<script type="text/javascript">
$(document).ready(function() {
  $("#calendar").fullCalendar({
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay"
    },

    locale: 'es',

    defaultView: "month",
    navLinks: true, 
    editable: false,
    eventLimit: true, 
    selectable: true,
    selectHelper: false,

//Nuevo Evento
  select: function(start, end){
      $("#exampleModal").modal();
      $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY'));
       
      var valorFechaFin = end.format("DD-MM-YYYY");
      var F_final = moment(valorFechaFin, "DD-MM-YYYY").subtract(1, 'days').format('DD-MM-YYYY'); //Le resto 1 dia
      $('input[name=fecha_fin').val(F_final);  

    },
      
    events: [
      <?php
       while($dataEvento = mysqli_fetch_array($resulEventos)){ ?>
          {
          _id: '<?php echo $dataEvento['id']; ?>',
          title: '<?php echo $dataEvento['evento']; ?>',
          start: '<?php echo $dataEvento['fecha_inicio']; ?>',
          end:   '<?php echo $dataEvento['fecha_fin']; ?>',
          color: '<?php echo $dataEvento['color_evento']; ?>'
          },
        <?php } ?>
    ],


//Eliminar Evento
eventRender: function(event, element) {
    element
      .find(".fc-content")
      .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");
    
    //Eliminar evento
    element.find(".closeon").on("click", function() {

    });
  },



//Modificar Evento del Calendario 
eventClick:function(event){
    var idEvento = event._id;
    $('input[name=idEvento').val(idEvento);
    $('input[name=evento').val(event.title);
    $('input[name=fecha_inicio').val(event.start.format('DD-MM-YYYY'));
    $('input[name=fecha_fin').val(event.end.format("DD-MM-YYYY"));

    $("#modalUpdateEvento").modal();
  },


  });



});

</script>
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
</body>

</html>