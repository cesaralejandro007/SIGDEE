<?php
use config\componentes\configSistema as configSistema;
?>
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
        <a href="?pagina=<?php configSistema::_M22_();?>" class="nav-link">
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
                <a class="dropdown-item text-center small text-gray-500" href="?pagina=<?php configSistema::_M20_();?>">Todas las
                    notificaciones</a>
            </div>
        </li>
        <center>
        <li class="nav-item dropdown no-arrow">
        <?php if($_SESSION['usuario']["ultimo_acceso"]!=""){?>
            <a class="nav-link dropdown-toggle p-0" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <div class="d-flex justify-content-end" style="font-size: 12px">
                    <?php echo "Ultimo acceso: ". date("d/m/Y H:i:s", strtotime($_SESSION['usuario']["ultimo_acceso"])); ?>
            </div>
                <spam class="" style="font-size: 12px">
                    <?php echo $_SESSION['usuario']["nombre"] . " " . $_SESSION['usuario']["apellido"]  ?>
                </spam>
            </a>
          
            <?php } else{?>
            <a class="nav-link dropdown-toggle " id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">

                <spam class="">
                    <?php echo $_SESSION['usuario']["nombre"] . " " . $_SESSION['usuario']["apellido"]  ?>
                </spam>
            </a>
            <?php } ?>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in p-0" aria-labelledby="userDropdown">
                <div class="card-header m-1 p-1 d-flex justify-content-center">
                    <div  style="top: 0;left: 0;width: 220px; height: 120px;background:#063587"></div>

                    <?php 
                        $directory="content/usuarios/";
                        $dirint = dir($directory);
                        $bandera = false;
                        while (($archivo = $dirint->read()) !== false && $bandera == false)
                        {

                            if($archivo == $_SESSION['usuario']["cedula"].".png"){
                                $imagen1 = $archivo;
                                $bandera = true;
                            }
                            else
                             $imagen1 = "img5.png";
                        }
                        $dirint->close(); 
                    ?>
                    <img class="imagen2"
                        style="position: absolute; top: 42px; width: 120px; height: 130px; border-radius: 50%; border: 5px solid #fff; background-color: #fff;"
                        src="content/usuarios/<?php echo $imagen1;?>">
                </div>
                <div class="d-flex justify-content-center" style="margin-top:40px; margin-bottom:0px">
                    <p class="m-0">
                        <?php echo $_SESSION['usuario']["nombre"] . " " . $_SESSION['usuario']["apellido"] ?>
                    </p>
                </div>
                <hr class="m-1">
                <div class="m-0 d-flex justify-content-between">
                    <div>
                        <a class="btn btn-sm rounded-0" style="background:#0C72C4; color:white;font-size:13px; margin:2px;" href="?pagina=<?php configSistema::_MPERF_();?>"><i class="fas fa-user"></i> Perfil</a>
                    </div>
                    <a href="?pagina=<?php configSistema::_ML_();?>" class="btn btn-sm  rounded-0" style="font-size:13px; background:#9D2323; color:white; margin:2px;"><i class="fas fa-power-off"></i> Salir</a>
                </div>
            </div>
        </li>
        </center>
    </ul>
    <script>

            document.getElementById("boton_copiar").onclick = function() {
                // Seleccionar el texto dentro del input
                var inputElement = document.getElementById("clave_privada");
                inputElement.select();
                inputElement.setSelectionRange(0, 99999); // Para dispositivos móviles

                // Copiar el texto al portapapeles
                document.execCommand('copy');

                var toastMixin = Swal.mixin({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                // Deseleccionar el input
                inputElement.blur();
                toastMixin.fire({
                    title: "Clave privada copiada al portapapeles",
                    icon: "success",
                });
            };

            document.getElementById("boton_copiar1").onclick = function() {
                // Seleccionar el texto dentro del input
                var inputElement = document.getElementById("clave_publica");
                inputElement.select();
                inputElement.setSelectionRange(0, 99999); // Para dispositivos móviles

                // Copiar el texto al portapapeles
                document.execCommand('copy');

                // Deseleccionar el input
                inputElement.blur();
                var toastMixin = Swal.mixin({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                toastMixin.fire({
                    title: "Clave publica copiada al portapapeles",
                    icon: "success",
                });
            };

    </script>
</nav>