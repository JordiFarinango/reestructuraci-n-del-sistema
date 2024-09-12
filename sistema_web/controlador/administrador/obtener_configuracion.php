<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once('../../modelo/ws_sistema.php');

$config = new configuraciones();
$nombre = 'pregunta_extra';
$valor = $config->obtenerConfiguracion($nombre);

if ($valor !== null) {
    echo json_encode(['success' => true, 'valor' => $valor]);
} else {
    echo json_encode(['success' => false, 'message' => 'Configuración no encontrada']);
}
?>
