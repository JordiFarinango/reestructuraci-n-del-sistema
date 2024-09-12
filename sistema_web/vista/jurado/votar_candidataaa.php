<!doctype html>
<html lang="en">
<head>
    <title>Calificar</title>
    <link rel="shortcut icon" href="../../assets/logo_municipio_c.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../libs/bootstrap-5.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="../../libs/jquery.min.js"></script>
    <script src="../../libs/bootstrap-5.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../libs/ajax.js"></script>
    <style>
        .centrado {
            text-align: center;
            vertical-align: middle;
        }
        .letra-grande {
            font-size: 1.3rem; /* Tamaño de letra aumentado */
        }

        body {
            background: url('../../assets/volcan_cayambe.png') no-repeat center center fixed;
            background-size: cover;
        }
        .content {
            position: relative;
            z-index: 2;
        }
        .centrado {
            text-align: center;
            vertical-align: middle;
        }
        .letra-grande {
            font-size: 1.2rem; /* Tamaño de letra aumentado */
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }
        .table {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
            border-radius: 15px; /* Bordes redondeados */
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
        }
        .table th,
        .table td {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con transparencia */
        }
        .card-title {
            font-size: 1.2rem; /* Aumentar tamaño de la letra del título */
        }
        .card-text {
            font-size: 1rem; /* Aumentar tamaño de la letra del texto */
        }
        .letra-muy-grande {
            font-size: 1.5rem; /* Tamaño de letra aumentado para número, nombre y apellidos */
        }
    </style>
</head>
<body onload="buscar_parametros(); obtenerNombreCandidata(); verificarPreguntaExtra();">
    <div class="container content">
        <div class="row">
            <div class="col-12">
                <br>
                <h2>Ingrese una nota para calificar:</h2>
                <div id="infoCandidata" class="d-flex justify-content-center">
                    <!-- Aquí se llenará la información de la candidata -->
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <a href="jurado.php" class="btn btn-success me-2">Regresar</a>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="card text-center" style="width: 18rem; margin-right: 1rem;">
                        <div class="card-body">
                            <h5 class="card-title text-danger">IMPORTANTE</h5>
                            <p class="card-text">Las calificaciones ingresadas deberán ser de 1 a 25, a excepción de los parámetros donde se específica el rango del valor a calificar. Una vez de clic en "Guardar" no podrá volver a modificar la nota.</p>
                        </div>
                    </div>

                    <div class="card text-center" style="width: 14rem; margin-right: 1rem;">
                        <div class="card-body">
                            <h5 class="card-title text-success">TOMAR EN CUENTA</h5>
                            <p class="card-text">Para poder calificar todas las notas, debe ingresar una nota y guardar, para que se habilite el siguiente parámetro a calificar.</p>
                        </div>
                    </div>

                    <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title text-warning">PREGUNTA EXTRA</h5>
                            <p class="card-text">La pregunta extra se habilitará en caso de haber un empate. La nota ingresada deberá ser de 1 a 25, y de igual manera una vez de clic en "Guardar" no podrá modificar la nota.</p>
                        </div>
                    </div>
                </div>

                <br>
                <div id="alert-container"></div>
                <form id="form_notas">
                    <input type="hidden" name="id_candidata" id="id_candidata" value="<?php echo $_GET['valor']; ?>">
                    <input type="hidden" name="numero_candidata" id="numero_candidata" value="<?php echo $_GET['numero']; ?>">
                    <div class="table-container">
                        <table id="tabla_parametros" name="tabla_parametros" class="table table-bordered letra-grande">
                            <thead class="bg-primary text-light">
                                <tr class="text-center">
                                    <th>N.</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_parametros_cuerpo">
                                <!-- Las filas serán agregadas aquí por AJAX -->
                            </tbody>
                        </table>
                    </div>
                </form>
                <script>
                    function obtenerNombreCandidata() {
                        var id_candidata = document.getElementById('id_candidata').value;
                        var numero_candidata = document.getElementById('numero_candidata').value;
                        console.log("ID de candidata:", id_candidata);
                        $.ajax({
                            type: 'GET',
                            url: '../../controlador/jurado/obtener_nombre_candidata.php',
                            data: { id_candidata: id_candidata },
                            cache: false
                        })
                        .done(function(response) {
                            console.log("Respuesta del servidor:", response);
                            var data = JSON.parse(response);
                            if (data.nombre && data.apellido && data.imagen && data.institucion) {
                                $('#infoCandidata').html(`
                                    <div class="card text-center" style="width: 100%; margin-bottom: 1rem;">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="centrado align-middle letra-muy-grande">${numero_candidata}</td>
                                                    <td class="centrado align-middle"><img src="../../assets/fotos_candidatas/${data.imagen}" alt="Imagen de la candidata" width="100"></td>
                                                    <td class="centrado align-middle letra-muy-grande">${data.nombre}</td>
                                                    <td class="centrado align-middle letra-muy-grande">${data.apellido}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="centrado align-middle letra-muy-grande"><strong>Representando a:</strong> ${data.institucion}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                `);
                            } else {
                                $('#infoCandidata').text('Error al obtener la información de la candidata');
                            }
                        })
                        .fail(function() {
                            $('#infoCandidata').text('Error al procesar información');
                        });
                    }

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
                        $('.bg-warning button').removeAttr('disabled');
                    }

                    function deshabilitarPreguntaExtra() {
                        $('.bg-warning input').attr('disabled', 'disabled');
                        $('.bg-warning button').attr('disabled', 'disabled');
                    }
                </script>
            </div>
        </div>
    </div>
</body>
</html>
