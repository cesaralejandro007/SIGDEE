<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Navbar Search -->
        <li class="nav-item dropdown no-arrow">
        <a href="?pagina=Ayuda" class="nav-link">
        <i class="fas fa-question-circle text-primary" style="font-size:20px"></i>
        </a>
        </li>
        <li onclick="notificacionclick();" class="nav-item dropdown no-arrow">
            <a class="nav-link" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span id="contador" class="badge badge-danger badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div  class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notificaciones:
                </h6>
                <div id="notificaciones1"></div>  
                <a class="dropdown-item text-center small text-gray-500" href="?pagina=Notificaciones">Todas las
                    notificaciones</a>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <spam class="">
                    <?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido'] ?>
                </spam>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-0" aria-labelledby="userDropdown">
                <div class="card-header m-0 p-0 d-flex justify-content-center">
                    <div  style="top: 0;left: 0;width: 250px; height: 150px;background:#337ab7"></div>

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
                    <img class="imagen2"
                        style="position: absolute; top: 95px; width: 120px; height: 105px; border-radius: 50%; border: 5px solid #fff; background-color: #fff;"
                        src="content/usuarios/<?php echo $imagen1;?>">
                </div>
                <div class="d-flex justify-content-center" style="margin-top:40px; margin-bottom:0px">
                    <p class="m-0">
                        <?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido'] ?>
                    </p>
                </div>
                <hr class="m-1">
                <div class="m-0 d-flex justify-content-between">
                    <div>
                        <a class="btn btn-primary m-2" href="?pagina=Perfil" style="font-size:13px">Perfil</a>
                    </div>
                    <a href="?pagina=Login" class="btn btn-danger m-2" style="font-size:13px">Salir</a>
                </div>
            </div>
        </li>
    </ul>
</nav>