<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../../modelo/ws_sistema.php");

file_put_contents("log.txt", "ver_calificaciones.php accessed\n", FILE_APPEND);

$calificacion_obj = new calificacion();
$result = $calificacion_obj->obtener_todas_calificaciones();

$calificaciones = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jurado = $row['nom_usuario'] . " " . $row['ape_usuario'];
        $candidata = $row['nom_candidata'] . " " . $row['ape_candidata'];
        $categoria = $row['nom_categoria'];
        $parametro = $row['nom_parametro'];
        $calificacion = $row['calificacion'];

        if (!isset($calificaciones[$candidata])) {
            $calificaciones[$candidata] = [];
        }
        if (!isset($calificaciones[$candidata][$jurado])) {
            $calificaciones[$candidata][$jurado] = [];
        }
        if (!isset($calificaciones[$candidata][$jurado][$categoria])) {
            $calificaciones[$candidata][$jurado][$categoria] = [];
        }

        $calificaciones[$candidata][$jurado][$categoria][$parametro] = $calificacion;
    }
}

$html = "";

foreach ($calificaciones as $candidata => $jurados) {
    $html .= "<h3 class='text-danger'>Candidata: {$candidata}</h3>";

    foreach ($jurados as $jurado => $categorias) {
        $html .= "<h4 class='text-info'>Jurado: {$jurado}</h4>";
        $html .= "<table class='table table-bordered' style='width: 100%; margin: 0 auto; font-size: 0.9em;'>";
        $html .= "<thead class='bg-primary text-light'><tr><th>Presentación</th><th>Parámetro</th><th>Calificación</th></tr></thead>";
        $html .= "<tbody>";

        foreach ($categorias as $categoria => $parametros) {
            foreach ($parametros as $parametro => $calificacion) {
                $html .= "<tr><td>{$categoria}</td><td>{$parametro}</td><td>{$calificacion}</td></tr>";
            }
        }

        $html .= "</tbody></table><br>";
    }
}

if (empty($html)) {
    $html = "<p class='bg-danger text-light text-center'>No existen registros</p>";
}

echo $html;
?>
