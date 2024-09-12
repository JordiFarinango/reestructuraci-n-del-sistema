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
    $datos_notario = $usuario->ConsultarDatoNotario($id_usuario);
    
    if ($datos_notario) {
        $nombreCompleto = $datos_notario['nom_usuario'] . ' ' . $datos_notario['ape_usuario'];
        echo json_encode(['nombre' => $nombreCompleto]);
    } else {
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
}
?>
