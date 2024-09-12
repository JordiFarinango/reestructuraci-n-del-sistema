<?php
session_start();
require_once('../../modelo/ws_sistema.php');

$id_usuario = $_SESSION['id_usuario'];  

$objp = new usuario();
$row = $objp->ConsultarDato($id_usuario);

if ($row) {
    echo json_encode(['success' => true, 'usuario' => $row['usu_usuario']]);
} else {
    echo json_encode(['success' => false]);
}
?>
