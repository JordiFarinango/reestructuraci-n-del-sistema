<!doctype html>
<html lang="en">
<head>
    <title>Jurado</title>
    <link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../libs/ajax.js"></script>
    <style>
        .calificado {
            background-color: #d4edda;
        }
        .centrado {
            text-align: center;
            vertical-align: middle;
        }
        .grande {
            font-size: 2.5rem; /* Tamaño de letra aumentado */
        }

        body {
            background: url('../../assets/cayambe.png') no-repeat center center fixed;
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
        .letra-grande {
            font-size: 1.2rem; /* Tamaño de letra aumentado */
        }
    </style>
</head>
<body onload="buscar_candidatasvotar(''); obtenerNombreJurado();">
    <div class="container content">
        <div>
            <h2 class="text-center">JURADO</h2>
            <h2 id="nombreJurado"></h2>
            <h2>SELECCIONE UNA CANDIDATA PARA CALIFICAR</h2>
        </div>      
        <div class="d-flex content-end mb-3">
            <a href="../loggin.html" class="btn btn-danger me-2">Cerrar Sesión</a>
        </div>
        <div class="d-flex content-end mb-3">
            <button type="button" class="btn btn-warning me-2" onclick="location.href='../jurado/actualizar_jurado.html'">Actualizar Credenciales</button>
        </div>
        <table class="table table-bordered">
            <thead class="bg-primary text-light">
                <tr>
                    <th class="centrado">N.</th>
                    <th class="centrado">Candidata</th>
                    <th class="centrado">Nombres</th>
                    <th class="centrado">Apellidos</th>
                    <th class="centrado">Votar</th>
                </tr>
            </thead>
            <tbody id="tabla_candire">
                <!-- Filas agregadas dinámicamente -->
            </tbody>
        </table>
    </div>
    <script>
        function obtenerNombreJurado() {
            $.ajax({
                type: 'GET',
                url: '../../controlador/jurado/obtener_nombre_jurado.php',
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response) {
                var data = JSON.parse(response);
                if (data.nombre) {
                    $('#nombreJurado').text('Bienvenido, ' + data.nombre);
                } else {
                    $('#nombreJurado').text('Error al obtener el nombre del jurado');
                }
            })
            .fail(function() {
                $('#nombreJurado').text('Error al procesar información');
            });
        }

        function buscar_candidatasvotar(apellidos) {
            var fd = new FormData();
            fd.append('valor', apellidos);
            $.ajax({
                type: 'POST',
                url: '../../controlador/jurado/ver_candidata_jurado.php',
                data: fd,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(data) {
                $("#tabla_candire").html(data);
                // Marcar las candidatas completamente calificadas
                marcarCandidatasCalificadas();
            })
            .fail(function() {
                alert("Error al procesar información");
            });
            return false;
        }

        function marcarCandidatasCalificadas() {
            $('#tabla_candire tr').each(function() {
                var parametrosCalificados = $(this).find('.parametro-calificado');
                var totalParametros = parametrosCalificados.length;
                var calificados = parametrosCalificados.filter(function() {
                    return $(this).text().trim() !== '';
                }).length;
                if (calificados === totalParametros) {
                    $(this).addClass('calificado');
                }
            });
        }
    </script>
</body>
</html>
