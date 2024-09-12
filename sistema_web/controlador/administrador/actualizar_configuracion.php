<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once('../../modelo/ws_sistema.php');

if (isset($_POST['valor'])) {
    $config = new configuraciones();
    $nombre = 'pregunta_extra';
    $valor = $_POST['valor'];

    $result = $config->actualizarConfiguracion($nombre, $valor);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar configuración']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Valor no proporcionado']);
}
?>
