<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once("../../modelo/ws_sistema.php");

$conexion = new DBConexion();
$conex = $conexion->Conectar();

$query = "
    SELECT 
        u.nom_usuario AS jurado, 
        c.nom_candidata AS candidata,
        p.nom_parametro AS parametro, 
        cal.calificacion,
        cat.nom_categoria AS categoria
    FROM calificacion cal
    JOIN usuarios u ON cal.id_usuario_re = u.id_usuario
    JOIN candidata c ON cal.id_candidata_re = c.id_candidata
    JOIN parametros p ON cal.id_parametro_re = p.id_parametros
    JOIN categoria cat ON p.id_categoria_re = cat.id_categoria
";

$result = mysqli_query($conex, $query);

$calificaciones = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categoria = $row['categoria'];
        if (!isset($calificaciones[$row['jurado']][$row['candidata']])) {
            $calificaciones[$row['jurado']][$row['candidata']] = [
                'coreografia' => null,
                'traje_tipico' => null,
                'traje_gala' => null,
                'respuesta_pregunta' => null,
            ];
        }
        switch ($categoria) {
            case 'Coreografía':
                $calificaciones[$row['jurado']][$row['candidata']]['coreografia'] = $row['calificacion'];
                break;
            case 'Traje Típico':
                $calificaciones[$row['jurado']][$row['candidata']]['traje_tipico'] = $row['calificacion'];
                break;
            case 'Traje de Gala':
                $calificaciones[$row['jurado']][$row['candidata']]['traje_gala'] = $row['calificacion'];
                break;
            case 'Respuesta a la pregunta':
                $calificaciones[$row['jurado']][$row['candidata']]['respuesta_pregunta'] = $row['calificacion'];
                break;
        }
    }
}

$calificaciones_flat = [];
foreach ($calificaciones as $jurado => $candidatas) {
    foreach ($candidatas as $candidata => $notas) {
        $calificaciones_flat[] = [
            'jurado' => $jurado,
            'candidata' => $candidata,
            'coreografia' => $notas['coreografia'],
            'traje_tipico' => $notas['traje_tipico'],
            'traje_gala' => $notas['traje_gala'],
            'respuesta_pregunta' => $notas['respuesta_pregunta'],
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($calificaciones_flat);

