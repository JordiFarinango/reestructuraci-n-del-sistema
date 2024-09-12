<?php
require_once('../../modelo/ws_sistema.php');
$obj = new candidatas();
$row = $obj -> vcedula($_POST['valor']);
if(isset($row['ced_candidata']))
{
    $texto="Cedula ya registrada en el sistema";
}
else
{
    $texto="";
}
echo $texto;

?>