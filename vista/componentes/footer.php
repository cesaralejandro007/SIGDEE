<footer class="py-4 mt-auto">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2019</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>

<script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
<script src="plugins/popper/popper.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/datatables/datatables.min.js"></script>
<script src="plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>   
<script src="plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
<script src="plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.js"></script>

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="content/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="content/js/scripts.js"></script>

<script src="content/js/sweetalert2.all.min.js"></script>

<script src="content/js/adminlte.js"></script>
<input type="hidden" name="name" id="name" value="<?php echo $_SESSION['usuario']['nombre']." ".$_SESSION['usuario']['apellido'] ?>" />
<?php
$confirm = 0;
for ($i = 0; $i < count($response1); $i++) {
    if ($response1[$i]['nombreentorno'] == 'Chat Virtual') {
        $confirm = true;
    }
}
if ($confirm) {?>

<script type="text/javascript">
	var url = "127.0.0.1:12345";
</script>
<script type="text/javascript" src="content/js/charts.js"></script>
<script src="content/js/chat.js"></script>
<script type="text/javascript" src="content/js/contenidosocket.js"></script>
<?php }?>

<script>
$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on("popstate", function() {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});
</script>