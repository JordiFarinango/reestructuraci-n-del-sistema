<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>
<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<?php
require_once('../../modelo/ws_sistema.php');
$objp=new usuario();
$result=$objp->insertarnotario(
    $_POST['txt_nombre'],
    $_POST['txt_apellido'],
    $_POST['txt_cedula'],
    $_POST['txt_correo'],
    $_POST['txt_direccion'],
    $_POST['txt_telefono'],
    $_POST['txt_ocupacion'],
    $_POST['txt_usuario'],
    $_POST['txt_clave'],
    $_POST['rol_id_re']);

    if($result)
    {
        echo '<script>jQuery(function(){swal({
            title:"Guardar Jurado", text:"Nuevo Jurado Guardado", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/administrador/administrador.php";});});</script>';
    }
    else
    {
        echo '<script>jQuery(function(){swal({
            title:"Guardar Jurado", text:"Error al Guardar", type:"success", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/administrador/administrador.php";});});</script>';
    }


?>