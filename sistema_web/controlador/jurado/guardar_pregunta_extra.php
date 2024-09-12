<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once("../../modelo/ws_sistema.php");

$idCandidata = $_POST['idCandidata'];
$notaPreguntaExtra = $_POST['notaPreguntaExtra'];
$idUsuario = $_SESSION['id_usuario']; 

$calificacion = new calificacion();
$result = $calificacion->guardarPreguntaExtra($idUsuario, $idCandidata, $notaPreguntaExtra);

if ($result) {
    echo "Calificación guardada exitosamente.";
} else {
    echo "Error al guardar la calificación.";
}
?>
