<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../loggin.html");
    exit();
}

// Evitar que las páginas se almacenen en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en">
<head>
    <title>Notario</title>
    <link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../libs/ajax.js"></script>
    <style>
        body {
            background: url('../../assets/nevado.png') no-repeat center center fixed;
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
<body>
    <div class="container content">
        <h2 class="text-center">NOTARIO PÚBLICO</h2>
        <h2 id="nombreNotario" ></h2>

        <div class="text-end mt-3">
            <button onclick="descargarReporte()" class="btn btn-primary">Descargar Notas Individuales</button>
        </div>
        <div class="text-end mt-3">
            <button class="btn btn-success" onclick="generarReporteGanadoras()">Descargar Ganadoras</button>
        </div>
        <div class="d-flex content-end mb-3">
            <a href="../../controlador/logout.php" class="btn btn-danger me-2">Cerrar Sesión</a>
        </div>
        
        <div id="contenedor_calificaciones">
            <!-- Las calificaciones serán cargadas aquí -->
        </div>
    </div>
    <script>
        function descargarReporte() {
            window.location.href = '../../controlador/notario/generar_reporte.php';
        }

        function generarReporteGanadoras() {
            window.location.href = '../../controlador/notario/generar_reporte_ganadoras.php';
        }

        function obtenerNombreNotario() {
            $.ajax({
                type: 'GET',
                url: '../../controlador/notario/obtener_nombre_notario.php',
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response) {
                var data = JSON.parse(response);
                if (data.nombre) {
                    $('#nombreNotario').text('Bienvenido, ' + data.nombre);
                } else {
                    $('#nombreNotario').text('Error al obtener el nombre del notario');
                }
            })
            .fail(function() {
                $('#nombreNotario').text('Error al procesar información');
            });
        }

        function obtener_calificaciones() {
            $.ajax({
                type: 'GET',  // Asegurarse de usar 'GET' para obtener datos
                url: '../../controlador/notario/ver_calificaciones.php',
                cache: false,
                contentType: 'application/json',  // Ajustar el content type si es necesario
                processData: false
            })
            .done(function(data) {
                $("#contenedor_calificaciones").html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error al procesar información: ", textStatus, errorThrown);
                alert("Error al procesar información: " + textStatus + " - " + errorThrown);
            });
        }

        // Llamar a la función cada 5 segundos para obtener actualizaciones en tiempo real
        setInterval(obtener_calificaciones, 5000);

        // Obtener calificaciones y nombre del notario al cargar la página
        $(document).ready(function() {
            obtenerNombreNotario();
            obtener_calificaciones();
        });
    </script>
</body>
</html>
