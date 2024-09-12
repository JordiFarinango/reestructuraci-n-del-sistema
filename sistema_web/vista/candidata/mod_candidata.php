<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../../modelo/ws_sistema.php");

$id_candidata = $_GET['valor'];
$candidatas = new candidatas();
$row = $candidatas->buscar_candidata_por_id($id_candidata);

if ($row) {
?>
<!doctype html>
<html lang="en">
<head>
    <title>Actualizar Persona</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('../../assets/administrador/actualizar_usuarios.png') no-repeat center center fixed;
            background-size: cover;
        }
        .content {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .centrado {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div>
                <h2 class="text-primary">Actualizar Persona</h2>
            </div>
            <div class="d-flex justify-content-end mb-3">
                <a href="../candidata/ver_candidata.html" class="btn btn-primary me-2">Regresar</a>
            </div>
            <form action="../../controlador/candidata/act_candidata.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_candidata" value="<?php echo $id_candidata; ?>">
                <input type="hidden" name="imagen_actual" value="<?php echo $row['img_candidata']; ?>">
                <div class="form-group row">
                    <label class="col-2">Nombres</label>
                    <input type="text" class="form-control col-4" name="txt_nombre" id="txt_nombre" value="<?php echo $row['nom_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Apellidos</label>
                    <input type="text" class="form-control col-4" name="txt_apellido" id="txt_apellido" value="<?php echo $row['ape_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Cedula</label>
                    <input type="number" class="form-control col-4" name="txt_cedula" id="txt_cedula" value="<?php echo $row['ced_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Correo</label>
                    <input type="text" class="form-control col-4" name="txt_correo" id="txt_correo" value="<?php echo $row['correo_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Telefono</label>
                    <input type="number" class="form-control col-4" name="txt_telefono" id="txt_telefono" value="<?php echo $row['cel_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Direccion</label>
                    <input type="text" class="form-control col-4" name="txt_direccion" id="txt_direccion" value="<?php echo $row['dir_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-5">¿A qué institución representa?</label>
                    <input type="text" class="form-control col-4" name="txt_representa" id="txt_representa" value="<?php echo $row['repre_candidata']; ?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Imagen</label>
                    <input type="file" class="form-control col-4" name="imagen_candidata" id="imagen_candidata">
                </div>
                <div class="form-group row">
                    <div class="col-2">
                        <?php if ($row['img_candidata']) { ?>
                            <img src="../../assets/fotos_candidatas/<?php echo $row['img_candidata']; ?>" alt="Imagen actual" style="width: 100px; height: 100px;">
                        <?php } ?>
                    </div>
                </div>
            </br>
                <div class="form-group row">
                    <div class="col-2">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo "No se encontró la candidata.";
}
?>
