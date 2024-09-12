<?php
require_once("../../modelo/ws_sistema.php");

$candidatas = new candidatas();
$id_candidata = $_GET['id_candidata'];
$numero_candidata = isset($_GET['numero']) ? $_GET['numero'] : ''; // Agregamos la obtención del número

$row = $candidatas->ConsultarDato($id_candidata);

if ($row) {
    $response = array(
        'nombre' => $row['nom_candidata'],
        'apellido' => $row['ape_candidata'],
        'numero' => $numero_candidata, // Usamos el número pasado como parámetro
        'imagen' => $row['img_candidata'],
        'institucion' => $row['repre_candidata'] // Corregimos la asignación del valor
    );
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'No se encontró la candidata'));
}
?>
