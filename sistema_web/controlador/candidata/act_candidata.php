<link href="../../libs/sweetalert2-8.2.5/sweetalert.css" rel="stylesheet">
<script src="../../libs/jquery.min.js"></script>
<script src="../../libs/sweetalert2-8.2.5/sweetalert.min.js"></script>
<?php
require_once('../../modelo/ws_sistema.php');

$id_candidata = $_POST['id_candidata'];
$nombre = $_POST['txt_nombre'];
$apellido = $_POST['txt_apellido'];
$cedula = $_POST['txt_cedula'];
$correo = $_POST['txt_correo'];
$telefono = $_POST['txt_telefono'];
$direccion = $_POST['txt_direccion'];
$representa = $_POST['txt_representa'];
$imagen_actual = $_POST['imagen_actual'];

if(isset($_FILES['imagen_candidata']) && $_FILES['imagen_candidata']['size'] > 0) {
    $directorio_destino = '../../assets/fotos_candidatas/';
    $nombre_archivo = $_FILES['imagen_candidata']['name'];
    $ruta_archivo = $directorio_destino . $nombre_archivo;

    if(move_uploaded_file($_FILES['imagen_candidata']['tmp_name'], $ruta_archivo)) {
        $imagen = $nombre_archivo;
    } else {
        echo '<script>jQuery(function(){swal({
            title:"Actualizar Candidata", text:"Error al subir la imagen", type:"error", confirmButtonText:"Aceptar"
        }, function(){location.href="../../vista/candidata/mod_candidata.php?valor='.$id_candidata.'";});});</script>';
        exit();
    }
} else {
    $imagen = $imagen_actual;
}

$objp = new candidatas();
$result = $objp->actualizarcandidata($id_candidata, $nombre, $apellido, $cedula, $correo, $telefono, $direccion, $representa, $imagen);

if($result) {
    echo '<script>jQuery(function(){swal({
        title:"Actualizar Candidata", text:"Candidata actualizada correctamente", type:"success", confirmButtonText:"Aceptar"
    }, function(){location.href="../../vista/candidata/ver_candidata.html";});});</script>';
} else {
    echo '<script>jQuery(function(){swal({
        title:"Actualizar Candidata", text:"Error al actualizar la candidata", type:"error", confirmButtonText:"Aceptar"
    }, function(){location.href="../../vista/candidata/mod_candidata.php?valor='.$id_candidata.'";});});</script>';
}
?>
    