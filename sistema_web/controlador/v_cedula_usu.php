<?php
require_once('../modelo/ws_sistema.php');
$obj = new usuario();
$row = $obj -> vcedulausu($_POST['valor']);
if(isset($row['ced_usuario']))
{
    $texto="Cedula ya registrada en el sistema";
}
else
{
    $texto="";
}
echo $texto;

?>