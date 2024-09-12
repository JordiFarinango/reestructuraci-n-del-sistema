<?php
require_once('../../modelo/ws_sistema.php');
$obj = new candidatas();
$row = $obj -> ConsultarDato($_POST['valor']);
$datos = json_encode(array("cedula"=>$row['ced_candidata'], "nombre"=>$row['nom_candidata'], "apellido"=>$row['ape_candidata']));
echo $datos;

?>
