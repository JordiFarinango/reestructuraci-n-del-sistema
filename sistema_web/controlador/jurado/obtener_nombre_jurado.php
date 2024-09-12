<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once("../../modelo/ws_sistema.php");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['error' => 'Sesión no iniciada']);
} else {
    $id_usuario = $_SESSION['id_usuario'];
    $usuario = new usuario();
    $datos_jurado = $usuario->ConsultarDato($id_usuario);
    
    if ($datos_jurado) {
        $nombreCompleto = $datos_jurado['nom_usuario'] . ' ' . $datos_jurado['ape_usuario'];
        echo json_encode(['nombre' => $nombreCompleto]);
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
}
?>
