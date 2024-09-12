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
    <title>Administrador</title>
    <link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../libs/ajax.js"></script>
    <script>
        $(document).ready(function() {
            // Obtener estado actual de la configuración
            $.ajax({
                type: 'GET',
                url: '../../controlador/administrador/obtener_configuracion.php',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        updateButtonState(data.valor);
                    } else {
                        alert(data.message);
                    }
                }
            });

            // Cambiar estado de la pregunta extra
            $('#toggleExtraQuestion').click(function() {
                var currentState = $(this).data('state');
                var newState = currentState === '0' ? '1' : '0';

                $.ajax({
                    type: 'POST',
                    url: '../../controlador/administrador/actualizar_configuracion.php',
                    data: { valor: newState },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            alert('Configuración actualizada correctamente');
                            updateButtonState(newState);
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });

            function updateButtonState(state) {
                if (state === '1') {
                    $('#toggleExtraQuestion').text('Desactivar Pregunta Extra').data('state', '1');
                } else {
                    $('#toggleExtraQuestion').text('Activar Pregunta Extra').data('state', '0');
                }
                verificarPreguntaExtra(); // Verificar el estado de la pregunta extra
            }
        });

        function verificarPreguntaExtra() {
            $.ajax({
                type: 'GET',
                url: '../../controlador/administrador/obtener_configuracion.php',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success && data.valor == '1') {
                        habilitarPreguntaExtra();
                    } else {
                        deshabilitarPreguntaExtra();
                    }
                }
            });
        }

        function habilitarPreguntaExtra() {
            $('.bg-warning input').removeAttr('disabled');
            $('.bg-warning button').show(); // Mostrar el botón de guardar
        }

        function deshabilitarPreguntaExtra() {
            $('.bg-warning input').attr('disabled', 'disabled');
            $('.bg-warning button').hide(); // Ocultar el botón de guardar
        }

        function descargarReporte() {
            window.location.href = '../../controlador/notario/generar_reporte.php';
        }

        function generarReporteGanadoras() {
            window.location.href = '../../controlador/notario/generar_reporte_ganadoras.php';
        }
    </script>
    <style>
        body {
            background: url('../../assets/administrador/fondo_admin.png') no-repeat center center fixed;
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
<body class="bg-secondary">
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="w-100 text-end">
            <a href="../../controlador/logout.php" class="btn btn-danger mb-4">Cerrar sesión</a>
        </div>
        
        <h2 class="mb-4">ADMINISTRADOR</h2>
        <div class="d-flex flex-row gap-4">
            <div class="d-flex flex-column gap-2 align-items-center">
                <button type="button" class="btn btn-success w-100" onclick="location.href='../jurado/nuevojurado.html'">Nuevo Jurado</button>
                <button type="button" class="btn btn-success w-100" onclick="location.href='../candidata/nuevacandidata.html'">Nueva Candidata</button>
                <button type="button" class="btn btn-success w-100" onclick="location.href='../notario/nuevonotario.html'">Nuevo Notario Público</button>
                <button type="button" class="btn btn-warning w-100" onclick="location.href='../jurado/ver_jurado.html'">Ver Jurados</button>
                <button type="button" class="btn btn-warning w-100" onclick="location.href='../candidata/ver_candidata.html'">Ver Candidatas</button>
                <button type="button" class="btn btn-warning w-100" onclick="location.href='../notario/ver_notario.html'">Ver Notario Público</button>
            </div>
            <div class="d-flex flex-column gap-2 align-items-center">
                <button type="button" class="btn btn-primary w-100" onclick="descargarReporte()">Descargar Notas Individuales</button>
                <!--<button type="button" class="btn btn-success w-100" onclick="generarReporteGanadoras()">Descargar Ganadoras</button>-->
            </div>
        </div>
        <br>
        <div>
            <button id="toggleExtraQuestion" class="btn btn-info">Activar Pregunta Extra</button>
        </div>
    </div>
</body>
</html>
