<link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">

<?php
require_once('../../modelo/ws_sistema.php'); 
$objp = new usuario();
$row = $objp->ConsultarDatoNotario($_GET['valor']);
//modificar persona
?>

<!doctype html>
<html lang="en">
<head>
    <title>Modificar Notario</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/ajax.js"></script>

    <style>
        body {
            background: url('../../assets/administrador/actualizar_usuarios.png') no-repeat center center fixed;
            background-size: cover;
        }
        .content {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.8); 
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

<body class="container">
    <div class="content">
        <form action="../../controlador/notario/act_notario.php" method="post">
            <input hidden type="text" id="txt_idnotarios" name="txt_idnotarios" value="<?php echo $row['id_usuario'];?>"> <!-- hidden es para ocultar esas cosas -->
            <div>
                <h2 class="text-primary">Actualizar Notario</h2>
            </div>
            <div class="d-flex justify-content-end mb-3">
                <a href="ver_notario.html" class="btn btn-primary">Regresar</a>
            </div>
            <div class="container">
                <div class="form-group row">
                    <label class="col-2">Nombres</label>
                    <input type="text" class="form-control col-4" name="txt_nombre" id="txt_nombre" value="<?php echo $row['nom_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Apellidos</label>
                    <input type="text" class="form-control col-4" name="txt_apellido" id="txt_apellido" value="<?php echo $row['ape_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Cedula</label>
                    <input type="number" class="form-control col-4" name="txt_cedula" id="txt_cedula" value="<?php echo $row['ced_usuario'];?>" minlength="1" maxlength="13" title="" onblur="vcedulausu(this.value);">
                    <div class="text-danger col-2" name="mensaje" id="mensaje"></div>
                </div>
                <div class="form-group row">
                    <label class="col-2">Correo</label>
                    <input type="text" class="form-control col-4" name="txt_correo" id="txt_correo" value="<?php echo $row['correo_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Dirección</label>
                    <input type="text" class="form-control col-4" name="txt_direccion" id="txt_direccion" value="<?php echo $row['dire_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-2">Celular</label>
                    <input type="number" class="form-control col-4" name="txt_telefono" id="txt_telefono" value="<?php echo $row['cel_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-5">Ocupación?</label>
                    <input type="text" class="form-control col-4" name="txt_ocupacion" id="txt_ocupacion" value="<?php echo $row['ocupa_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-5">Usuario</label>
                    <input type="text" class="form-control col-4" name="txt_usuario" id="txt_usuario" value="<?php echo $row['usu_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-5">Clave</label>
                    <input type="text" class="form-control col-4" name="txt_clave" id="txt_clave" value="<?php echo $row['clave_usuario'];?>">
                </div>
                <div class="form-group row">
                    <label class="col-2 text-center">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </label>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
