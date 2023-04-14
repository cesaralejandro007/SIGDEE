<!DOCTYPE html>
<html lang="en">
<?php include_once 'componentes/head.php';?>
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once 'componentes/panel_nav.php';?>
        <!-- Main Sidebar Container -->
        <?php include_once 'componentes/panel_sidenav.php';?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <main class="content m">
                <div class="container p-0">
            
                    
                    <div class="card m-2">
                        <div class="row g-0">
                            <div class="col-12 col-lg-12 col-xl-12">
                                <div class="py-2 px-4 border-bottom">
                                    <div class="d-flex align-items-center py-1 justify-content-between">
                                        <h1 class="h3 mb-3">Chat Virtual</h1>
                                        <div>
                                            <button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
                                        </div>
                                    </div>
                                </div>
                                
                                <a id="final_chat" href="#final"></a>
                                <div id="new_scroll" style="overflow-y: scroll;height:400px;scroll-behavior: smooth;">
                                    <ul id="containerMessages" class="chat-messages p-4">
                                    <?php foreach ($r1 as $valor) {?>
                                        <?php if($valor["cedula"]==$_SESSION["usuario"]["cedula"]){?>
                                            <div id="mensaje<?php echo $valor['id'] ?>" class="d-flex justify-content-end">
                                                <li class="meMessage small p-2 me-1 mb-1 text-white rounded-3 bg-secondary">
                                                    <p class="d-flex small">Fecha: <?php echo $valor['fecha']; ?></p>
                                                    <label>Yo: </label> <?php echo $valor['mensajes']; ?>
                                                </li>
                                                <div class="d-flex align-items-center">
                                                <a href="#" onclick="eliminar(<?=$valor['id'];?>);"><i class="fas fa-trash-alt text-danger" style="font-size: 14px;"></i></a>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($valor["cedula"]!=$_SESSION["usuario"]["cedula"]){?>
                                            <div id="mensaje<?php echo $valor['id'] ?>" class="d-flex justify-content-start">
                                                <li class="yourMessage small p-2 me-2 mb-1 text-white rounded-3 bg-primary">
                                                    <p class="d-flex small">Fecha:<?php echo $valor['fecha']; ?></p>
                                                    <label><?php echo $valor['nombre']." ". $valor['apellido']; ?> </label> <?php echo $valor['mensajes']; ?>
                                                </li>
                                            </div>
                                        <?php }?>
                                    <?php }?>
                                    </ul>
                                    
                                    <div id="final"></div>
                                </div>
            
                                <div class="flex-grow-0 py-3 px-4 border-top">
                                        <form id="formChat" class="input-group">
                                        
                                            <input id="message" type="text" class="form-control" placeholder="Escribe un mensaje">
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <?php include_once 'componentes/footer.php';?>
        <script>
            (function () {
                document.getElementById("final_chat").click();
            })();
        </script>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            </aside>
    </div>

</body>

</html>