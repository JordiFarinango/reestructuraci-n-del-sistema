<?php
include '../../ws_sistema.php';

$id = $_GET['id_candidata'];

$query = "SELECT id_candidata, nom_candidata, ape_candidata, /* otros campos */ FROM candidatas WHERE id_candidata = $id";
$result = $conn->query($query);

$candidata = $result->fetch_assoc();

echo json_encode($candidata);

$conn->close();
?>
