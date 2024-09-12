<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>
<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<?php

require_once('../../modelo/ws_sistema.php');
$objp=new usuario();
$result=$objp->eliminarjurado($_POST['codigo']);

    if($result)
    {
        echo '<script>jQuery(function(){swal({
            title:"Eliminar Jurado", text:"Jurado Eliminado", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/jurado/ver_jurado.html";});});</script>';
    }
    else
    {
        echo '<script>jQuery(function(){swal({
            title:"Eliminar Jurado", text:"Error al Eliminar", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/jurado/ver_jurado.html.php";});});</script>';
    }

?>