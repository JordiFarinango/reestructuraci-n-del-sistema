<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>

<?php
require_once('../../modelo/ws_sistema.php');
$objp=new usuario();
$result=$objp->actualizarnotario(
    $_POST['txt_nombre'],
    $_POST['txt_apellido'],
    $_POST['txt_cedula'],
    $_POST['txt_correo'],
    $_POST['txt_direccion'],
    $_POST['txt_telefono'],
    $_POST['txt_ocupacion'],
    $_POST['txt_usuario'],
    $_POST['txt_clave'],
    $_POST['txt_idnotarios'],);

    if($result)
    {
        echo '<script>jQuery(function(){swal({
            title:"Actualizar Notario", text:"Notario Actualizado", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/notario/ver_notario.html";});});</script>';
    }
    else
    {
        echo '<script>jQuery(function(){swal({
            title:"Actualizar Notario", text:"Error al Actualizar", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/notario/ver_notario.html";});});</script>';
    }









?>