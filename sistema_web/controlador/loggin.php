<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../modelo/ws_sistema.php");
session_start();

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Usuario o contraseña incorrecta.'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    $conexionDB = new DBConexion();
    $conexion = $conexionDB->Conectar();
    $consulta = "SELECT * FROM usuarios WHERE usu_usuario = '$usuario' AND clave_usuario = '$clave'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $_SESSION["id_usuario"] = $fila["id_usuario"];
        $_SESSION["rol"] = $fila["rol_id_re"];
        $response['success'] = true;
        switch ($_SESSION["rol"]) {
            case 1: 
                $response['redirect'] = '../vista/administrador/administrador.php';
                break;
            case 2: 
                $response['redirect'] = '../vista/jurado/jurado.php';
                break;
            case 3: 
                $response['redirect'] = '../vista/notario/notario.php';
                break;
            default: 
                $response['redirect'] = 'error.html';
                break;
        }
    }
    
}
echo json_encode($response);
exit();
?>
