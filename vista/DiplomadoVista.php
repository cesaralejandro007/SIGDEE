<html lang="en">
<?php include_once('componentes/head.php'); ?>
<head>

    <link href="content/css/stylesprincipal.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">
            <a class="navbar-brand" href="#inicio">Inicio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span
            class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">Reseña Historica</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Conócenos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contactos</a></li>
                    <li class="nav-item"><a class="nav-link" href="?pagina=Login">Iniciar Sesion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="masthead text-white" id="inicio">
        <div class="container text-center d-flex justify-content-end">
            <h3 class="fw-bolder caja1 col-md-8 rounded rounded-5 p-4">SISTEMA DE INFORMACIÓN PARA LA GESTIÓN DE
                DIPLOMADOS DE LA ESCUELA DE
                EMPRENDIMIENTO
                DEL PROGRAMA NACIONAL DE FORMACIÓN EN ADMINISTRACIÓN DE LA UNIVERSIDAD
                POLITÉCNICA TERRITORIAL “ANDRÉS ELOY BLANCO”,
            BARQUISIMETO – ESTADO LARA.</h3>
        </div>
        <?php if ($confirma_fecha) { ?>
            <div style="text-align: -webkit-center;">
                <button class="form-control btn btn-info" id="ver-censo" style="width: 50%">Censo Aperturado</button>
            </div>
        <?php    }?>
        
    </div>
</header>
<!-- About section-->
<section id="about">
    <div class="container">
        <h4>Breve reseña historica:</h4>
        <p class="lead" style="  font-size: 15px; text-align:justify;"> La Universidad Politécnica
            Territorial de Lara “Andrés
            Eloy
            Blanco”, conocida por
            sus siglas “UPTAEB”, es una institución pública de educación superior. Se dedica a la
            preparación de profesionales universitarios, al nivel de Técnicos Superiores, Licenciados e
            Ingenieros. Corresponde a un carácter tecnológico, pasando a convertirse en una institución
            politécnica debido al marco de la Misión Alma Mater. Su nombre oficial, “Andrés Eloy Blanco”,
            fue otorgado el 8 de diciembre de 1988, y al año siguiente, fue transformado en Instituto
            Universitario Experimental de Tecnología “Andrés Eloy Blanco” (IUETAEB), para cuatro años
            después convertirse en Universidad Politécnica Territorial “Andrés Eloy Blanco” (UPTAEB).
            Por otro lado, la Escuela de Emprendimiento fue creada en octubre del año 2021, en una alianza
            de la Universidad con la Alcaldía de Iribarren. De carácter gratuito, esta se trata de la
            primera escuela de esta índole en la ciudad de Barquisimeto, y en ella fueron atendidos
            alrededor de 200 estudiantes apenas en su primera cohorte. Actualmente, se dirigen 14 grupos de
            emprendimientos, con un aproximado de 30 estudiantes cada uno. Este ente se encarga de recibir
            propuestas para la creación de diplomados en distintas materias de emprendimiento, y tras su
            aprobación, estos se imparten a las personas que se han inscrito, quienes necesitan aprobar una
        serie de módulos para lograr la realización ocupacional en ellos.</p>
    </div>
</section>
<!-- Services section-->
<section class="bg-light" id="services">
    <div class="container px-4">
        <div class="card-group">
            <div class="col">
                <div class="card border-dark m-1 py-4">
                    <div class="card-body">
                        <h5 class="card-title">Misión:</h5>
                        <p class="card-text"> Impulsar con una formación innovadora, de calidad y alto impacto, a
                            los emprendedores y emprendedoras para que contribuyan al desarrollo productivo, social,
                            comunal y económico sustentable y sostenible, brindándole las herramientas necesarias
                            para su operatividad, bajo una concepción de trabajo colaborativo con el sello UPTAEB –
                        Hecho en Iribarren.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-dark m-1">
                    <div class="card-body">
                        <h5 class="card-title">Visión:</h5>
                        <p class="card-text"> Ser la Escuela de Formación modelo del país, con el acompañamiento a
                            los emprendedores y emprendedoras, para que lideren los cambios y la transformación de
                            su emprendimiento, en aras de garantizar mecanismos de construcción de una nueva
                            economía social como herramienta estratégica para el desarrollo endógeno. Esto se logra
                            mediante la implementación de ciertos valores en la ética de la organización: Formación
                            integral, trabajo en equipo, sentido de pertenencia, empatía y lealtad con el desarrollo
                        de la Nación.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact section-->
<section id="contact">
    <div class="container px-4">
        <div class="row gx-4 justify-content-center">
            <div class="col-lg-8">
                <h2>Contact us</h2>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero odio fugiat
                    voluptatem dolor, provident officiis, id iusto! Obcaecati incidunt, qui nihil beatae magnam et
                repudiandae ipsa exercitationem, in, quo totam.</p>
            </div>
        </div>
    </div>
</section>
<div class="modal fade show" id="censo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titulo">Censo Aperturado</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <input type="hidden" name="id" id="id"/>
          <div class="form-group row">
              <div class="col-md-6">
                 <label class="col-form-label">Fecha de Inicio:</label>
                 <p id="fecha_apertura"></p>
             </div>
             <div class="col-md-6">
                 <label class="col-form-label">Fecha de Cierre:</label>
                 <p id="fecha_cierre"></p>
             </div>
         </div>
         <div class="row">
             <div class="col-md-12">
                 <p id="descripcion"></p>
             </div>
         </div>
         <div class="modal-footer justify-content-between">
            <a href="?pagina=Postulacion"><button type="button" id="enviar" class="btn btn-primary">Censarse</button></a>
        </div>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container px-4">
        <p class="m-0 text-center text-white">Derechos reservados 2022</p>
    </div>
</footer>
<script src="plugins/all/js/all.min.js" crossorigin="anonymous"></script> 
<script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="content/js/diplomado.js"></script>
</body>

</html>