<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php

require_once('../../modelo/ws_sistema.php');
$objp=new candidatas();
$result=$objp->eliminar($_POST['codigo']);

    if($result)
    {
        echo '<script>jQuery(function(){swal({
            title:"Eliminar Candidata", text:"Registro Eliminado", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/candidata/ver_candidata.html";});});</script>';
    }
    else
    {
        echo '<script>jQuery(function(){swal({
            title:"Eliminar Persona", text:"Error al Eliminar", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/candidata/ver_candidata.html";});});</script>';
    }

?>