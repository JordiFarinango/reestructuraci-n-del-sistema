<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>
<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<?php
require_once('../../modelo/ws_sistema.php');

if (isset($_FILES['imagen_candidata'])) {
    $directorio_destino = '../../assets/fotos_candidatas/';
    $nombre_archivo = $_FILES['imagen_candidata']['name'];
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if (move_uploaded_file($_FILES['imagen_candidata']['tmp_name'], $ruta_archivo)) {
        $objp = new candidatas();
        $result = $objp->insertarcandidata(
            $_POST['txt_nombre'],
            $_POST['txt_apellido'],
            $_POST['txt_cedula'],
            $_POST['txt_correo'],
            $_POST['txt_telefono'],
            $_POST['txt_direccion'],
            $_POST['txt_representa'],
            $nombre_archivo
        );

        if ($result) {
            echo '<script>jQuery(function(){swal({
                title:"Guardar Candidata", text:"Nueva Candidata Registrada", type:"success", confirmButtonText:"Aceptar"
            }, function(){location.href="../../vista/candidata/nuevacandidata.html";});});</script>';
        } else {
            echo '<script>jQuery(function(){swal({
                title:"Guardar Candidata", text:"Error al Guardar", type:"error", confirmButtonText:"Aceptar"
            }, function(){location.href="../../vista/candidata/nuevacandidata.html";});});</script>';
        }
    } else {
        echo '<script>jQuery(function(){swal({
            title:"Guardar Candidata", text:"Error al subir la imagen", type:"error", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/candidata/nuevacandidata.html";});});</script>';
    }
} else {
    echo '<script>jQuery(function(){swal({
        title:"Guardar Candidata", text:"No se recibió la imagen", type:"error", confirmButtonText:"Aceptar"
    }, function(){location.href="../../vista/candidata/nuevacandidata.html";});});</script>';
}
?>
