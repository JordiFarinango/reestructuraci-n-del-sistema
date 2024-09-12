<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once("../../modelo/ws_sistema.php");
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("Error: Sesión no iniciada para el jurado.");
}

$id_usuario = $_SESSION['id_usuario'];  

if (!isset($_POST['valor'])) {
    die("Error: ID de candidata no proporcionado.");
}

$id_candidata = $_POST['valor'];  

$parametros = new parametros();
$result = $parametros->buscar_parametros("");

$config = new configuraciones();
$pregunta_extra_activada = $config->obtenerConfiguracion('pregunta_extra') == '1';

$categoria_map = [
    1 => 'Coreografía',
    2 => 'Traje Típico',
    3 => 'Traje de Gala',
    4 => 'Respuesta a la pregunta'
];

$categorias = [
    'Coreografía' => [],
    'Traje Típico' => [],
    'Traje de Gala' => [],
    'Respuesta a la pregunta' => []
];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $categoria_id = $row['id_categoria_re'];
        $nom_parametro = $row['nom_parametro'];
        $id_parametro = $row['id_parametros'];

        if (isset($categoria_map[$categoria_id])) {
            $categoria_nombre = $categoria_map[$categoria_id];
            $categorias[$categoria_nombre][] = [
                'nombre' => $nom_parametro,
                'id' => $id_parametro
            ];
        }
    }

    $calificaciones = [];
    $calificacion_obj = new calificacion();
    $result_calificaciones = $calificacion_obj->obtener_calificaciones($id_usuario, $id_candidata);
    if ($result_calificaciones && mysqli_num_rows($result_calificaciones) > 0) {
        while ($row_calificacion = mysqli_fetch_array($result_calificaciones)) {
            $calificaciones[$row_calificacion['id_parametro_re']] = $row_calificacion['calificacion'];
        }
    }

    $html = '';
    $first = true; 
    $presentation_number = 1; 

    foreach ($categoria_map as $categoria_id => $categoria_nombre) {
        if (isset($categorias[$categoria_nombre]) && count($categorias[$categoria_nombre]) > 0) {
            $categoria_con_texto = "<strong>Presentación {$presentation_number}:</strong> {$categoria_nombre}";
            $html .= "<tr><td>{$categoria_con_texto}</td>";

            foreach ($categorias[$categoria_nombre] as $parametro) {
                $id_parametro = $parametro['id'];
                $nota = $calificaciones[$id_parametro] ?? '';
                $disabled = $nota || !$first ? 'disabled' : '';
                
                $min = 1;
                $max = 25;
                $extraClass = '';

                if ($categoria_nombre == 'Respuesta a la pregunta') {
                    if (strpos($parametro['nombre'], '40') !== false) {
                        $max = 40;
                    } elseif (strpos($parametro['nombre'], '30') !== false) {
                        $max = 30;
                    }
                    if (strpos($parametro['nombre'], 'Pregunta extra') !== false) {
                        $extraClass = 'bg-warning';
                        $disabled = 'disabled';
                        if ($pregunta_extra_activada) {
                            $disabled = '';
                        }
                    } else {
                        $extraClass = 'bg-info';
                    }
                } elseif ($categoria_nombre == 'Coreografía') {
                    $extraClass = 'bg-secondary text-light';
                } elseif ($categoria_nombre == 'Traje Típico') {
                    $extraClass = 'bg-primary text-light';
                } elseif ($categoria_nombre == 'Traje de Gala') {
                    $extraClass = 'bg-success text-light';
                }

                $html .= "<td class='{$extraClass}'>{$parametro['nombre']}<br><input type='number' name='nota_{$id_parametro}' id='nota_{$id_parametro}' value='{$nota}' min='{$min}' max='{$max}' step='1' required {$disabled}>";
                if (!$nota && $extraClass != 'bg-warning') {
                    $html .= "<button type='button' id='btn_guardar_{$id_parametro}' onclick='guardar_nota({$id_parametro}, {$id_candidata})' {$disabled}>Guardar</button>";
                } elseif (!$nota && $extraClass == 'bg-warning' && $pregunta_extra_activada) {
                    $html .= "<button type='button' id='btn_guardar_{$id_parametro}' onclick='guardar_nota({$id_parametro}, {$id_candidata})'>Guardar</button>";
                }
                $html .= "</td>";

                if (!$nota && $first) {
                    $first = false; // Deshabilitar el primer campo después del primero habilitado
                }
            }

            $html .= "</tr>";
            $presentation_number++; // Incrementar el número de presentación
        }
    }

    echo $html;

} else {
    echo "<tr><td colspan='5' class='bg-danger text-light text-center'>No existen registros</td></tr>";
}
?>
