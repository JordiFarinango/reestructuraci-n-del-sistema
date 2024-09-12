<?php
session_start();
require_once('../../modelo/ws_sistema.php');

$id_usuario = $_SESSION['id_usuario'];  
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$objp = new usuario();
$result = $objp->actualizarCredenciales($usuario, $clave, $id_usuario);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
