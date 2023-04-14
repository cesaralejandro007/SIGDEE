<?php 

    use component\initComponents as initComponents;
    use component\header as header;
    use modelo\Permisos as permiso;
    session_start();
if (!isset($_SESSION['usuario'])) {
    die("<script>window.location='?url=principal'</script>");
}


  $components = new initComponents();
  $header = new header();

    if (file_exists("vista/principalVista.php")){
        require_once("vista/principalVista.php");
    }else{
        die("<script>window.location='?url=principal'</script>");
  }

 ?>