<style>
.table-responsive::-webkit-scrollbar {
  width: 12px;               /* width of the entire scrollbar */
}
.table-responsive-xl::-webkit-scrollbar {
  width: 12px;               /* width of the entire scrollbar */
}
body::-webkit-scrollbar-track {
  background: #FBFCFC;        /* color of the tracking area */
}
.table-responsive::-webkit-scrollbar-thumb {
  background-color: #909497;    /* color of the scroll thumb */
  border-radius: 20px;       /* roundness of the scroll thumb */
  border: 3px solid #FBFCFC;  /* creates padding around scroll thumb */
}
.table-responsive-xl::-webkit-scrollbar-thumb {
  background-color: #909497;    /* color of the scroll thumb */
  border-radius: 20px;       /* roundness of the scroll thumb */
  border: 3px solid #FBFCFC;  /* creates padding around scroll thumb */
}
</style>
<nav class="main-header navbar navbar-expand navbar-white" style="background:#0D47AD; color:white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Navbar Search -->
        <li class="nav-item dropdown no-arrow">
        <a href="?pagina=Ayuda" class="nav-link">
        <i class="fas fa-question-circle text-white" style="font-size:18; margin-top:3px"></i>
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
                    <div  style="top: 0;left: 0;width: 250px; height: 120px;background:#063587"></div>

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
                        style="position: absolute; top: 42px; width: 120px; height: 120px; border-radius: 50%; border: 5px solid #fff; background-color: #fff;"
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
                        <a class="btn m-1" style="background:#0C72C4; color:white;font-size:13px" href="?pagina=Perfil">Perfil</a>
                    </div>
                    <a href="?pagina=Login" class="btn m-1" style="font-size:13px; background:#9D2323; color:white">Salir</a>
                </div>
            </div>
        </li>
    </ul>
</nav>