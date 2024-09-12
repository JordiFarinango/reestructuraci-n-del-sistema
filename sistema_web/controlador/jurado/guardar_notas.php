<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once("../../modelo/ws_sistema.php");
session_start();

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Error al guardar la nota.'
];

if (!isset($_SESSION['id_usuario'])) {
    $response['message'] = 'Sesión no iniciada para el jurado.';
    echo json_encode($response);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['id_parametro']) || !isset($_POST['id_candidata']) || !isset($_POST['nota'])) {
        $response['message'] = 'Datos incompletos.';
        echo json_encode($response);
        exit();
    }

    $id_parametro = $_POST['id_parametro'];
    $id_candidata = $_POST['id_candidata'];
    $nota = $_POST['nota'];

    if (!filter_var($nota, FILTER_VALIDATE_INT)) {
        $response['message'] = 'Por favor, ingrese un número entero. No se permiten números decimales.';
        echo json_encode($response);
        exit();
    }

    if ($nota < 1 || $nota > 40) {
        $response['message'] = 'Nota fuera del rango permitido.';
        echo json_encode($response);
        exit();
    }

    $conexion = new DBConexion();
    $conex = $conexion->Conectar();

    $stmt = $conex->prepare("INSERT INTO calificacion (id_usuario_re, id_candidata_re, id_parametro_re, calificacion) VALUES (?, ?, ?, ?)
                             ON DUPLICATE KEY UPDATE calificacion = ?");
    $stmt->bind_param("iiiii", $id_usuario, $id_candidata, $id_parametro, $nota, $nota);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Nota guardada exitosamente';
    } else {
        $response['message'] = 'Error al guardar la nota';
    }

    $stmt->close();
    $conex->close();
} else {
    $response['message'] = 'Método no permitido';
}

echo json_encode($response);
?>
