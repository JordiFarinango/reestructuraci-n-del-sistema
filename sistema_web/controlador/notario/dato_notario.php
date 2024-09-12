<?php
require_once('../../modelo/ws_sistema.php');
$obj = new usuario();
$row = $obj -> ConsultarDatoNotario($_POST['valor']);
$datos = json_encode(array("cedula"=>$row['ced_usuario'], "nombre"=>$row['nom_usuario'], "apellido"=>$row['ape_usuario']));
echo $datos;

?>
