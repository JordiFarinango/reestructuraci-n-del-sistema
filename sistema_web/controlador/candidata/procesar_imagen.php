<?php
if(isset($_FILES['imagen_candidata'])) {
    $directorio_destino = '../../assets/fotos_candidatas';

    $archivo_destino = $directorio_destino . basename($_FILES['imagen_candidata']['name']);

    if(move_uploaded_file($_FILES['imagen_candidata']['tmp_name'], $archivo_destino)) {
        echo "La imagen se ha subido correctamente.";
    } else {
        echo "Hubo un error al subir la imagen.";
    }
} else {
    echo "No se ha seleccionado ninguna imagen.";
}
?>
