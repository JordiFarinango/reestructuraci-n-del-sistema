<?php
require_once("../../modelo/ws_sistema.php");

$candidatas = new candidatas();
$result = $candidatas->buscar_candidatas($_POST['valor']);

if(mysqli_num_rows($result) > 0) {
    $f = 1;
    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='grid-item'>
                <div class='numero-candidata'>{$f}</div>
                <img src='../../assets/fotos_candidatas/{$row['img_candidata']}' alt='Imagen de la candidata'>
                <h4>{$row['nom_candidata']}</h4>
                <h4>{$row['ape_candidata']}</h4>
                <a href='votar_candidataaa.php?valor=".$row['id_candidata']."&numero={$f}'><img src='../../assets/imagenes/votar.png' alt='Votar'></a>
            </div>";
        $f++;
    }
} 
else 
{
    echo "<div class='bg-danger text-light text-center p-3'>No existen registros</div>";
}
?>


