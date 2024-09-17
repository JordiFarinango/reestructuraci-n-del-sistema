function contar(usuario) {
    var l = usuario.length;
    if (l > 10) {
        $('#mensaje_usu').html("Usuario máximo 10 caracteres");
    } else {
        $('#mensaje_usu').html("");
    }
 }
 
 function contarp(mensajep) {
    var l = mensajep.length;
    if (l > 10) {
        $('#mensaje_cla').html("Clave máximo 10 caracteres");
    } else {
        $('#mensaje_cla').html("");
    }
 }
 
 function buscar_candidatas(apellidos) {
    var fd = new FormData();
    fd.append('valor', apellidos);
    $.ajax({
        type: 'POST',
        url: '../../controlador/candidata/ver_candidatas.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        $("#tabla_candi").html(data);
    })
    .fail(function() {
        alert("Error al procesar información");
    });
    return false;
 }
 
 function buscar_jurados(apellidos) {
    var fd = new FormData();
    fd.append('valor', apellidos);
    $.ajax({
        type: 'POST',
        url: '../../controlador/jurado/ver_jurado.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        $("#tabla_jura").html(data);
    })
    .fail(function() {
        alert("Error al procesar información");
    });
    return false;
 }
 
 function buscar_notarios(apellidos) {
    var fd = new FormData();
    fd.append('valor', apellidos);
    $.ajax({
        type: 'POST',
        url: '../../controlador/notario/ver_notario.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        $("#tabla_nota").html(data);
    })
    .fail(function() {
        alert("Error al procesar información");
    });
    return false;
 }
 
 function eliminar(codigo) {
    $("#codigo").val(codigo);
    var fd = new FormData();
    fd.append('valor', codigo);
    $.ajax({
        type: 'POST',
        url: '../../controlador/candidata/dato_candidata.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        var datos = JSON.parse(data);
        $('#txt_cedula').val(datos.cedula);
        $('#txt_nombre').val(datos.nombre);
        $('#txt_apellido').val(datos.apellido);
    })
    .fail(function() {
        alert("Error al procesar la información.");
    });
    return false;
 }
 
 function eliminarjurado(codigo) {
    $("#codigo").val(codigo);
    var fd = new FormData();
    fd.append('valor', codigo);
    $.ajax({
        type: 'POST',
        url: '../../controlador/jurado/dato_jurado.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        var datos = JSON.parse(data);
        $('#txt_cedula').val(datos.cedula);
        $('#txt_nombre').val(datos.nombre);
        $('#txt_apellido').val(datos.apellido);
    })
    .fail(function() {
        alert("Error al procesar la información.");
    });
    return false;
 }
 
 function eliminarnotario(codigo) {
    $("#codigo").val(codigo);
    var fd = new FormData();
    fd.append('valor', codigo);
    $.ajax({
        type: 'POST',
        url: '../../controlador/notario/dato_notario.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        var datos = JSON.parse(data);
        $('#txt_cedula').val(datos.cedula);
        $('#txt_nombre').val(datos.nombre);
        $('#txt_apellido').val(datos.apellido);
    })
    .fail(function() {
        alert("Error al procesar la información.");
    });
    return false;
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
    })
    .fail(function() {
        alert("Error al procesar información");
    });
    return false;
 }
 
 function guardar_nota(id_parametro, id_candidata) {
     var notaElement = document.getElementById('nota_' + id_parametro);
     var nota = notaElement ? notaElement.value : '';
     
     if (nota === "" || nota < parseInt(notaElement.min) || nota > parseInt(notaElement.max)) {
         showAlert("Por favor, ingrese una nota válida entre " + notaElement.min + " y " + notaElement.max, 'danger');
         return;
     }
     
     var fd = new FormData();
     fd.append('id_parametro', id_parametro);
     fd.append('id_candidata', id_candidata);
     fd.append('nota', nota);
     
     $.ajax({
         type: 'POST',
         url: '../../controlador/jurado/guardar_notas.php',
         data: fd,
         cache: false,
         contentType: false,
         processData: false,
         success: function(response) {
             if (response.success) {
                 showAlert(response.message, 'success');
                 // Bloquear el campo y eliminar el botón
                 notaElement.setAttribute('disabled', 'disabled');
                 var botonGuardar = document.getElementById('btn_guardar_' + id_parametro);
                 if (botonGuardar) {
                     botonGuardar.remove();
                 }
                 // Habilitar el siguiente campo sin necesidad de actualizar
                 habilitarSiguienteCampo(notaElement);
             } else {
                 showAlert(response.message, 'danger');
             }
         },
         error: function() {
             showAlert("Error al guardar la nota", 'danger');
         }
     });
 }
 
 function habilitarSiguienteCampo(currentElement) {
     var currentCell = currentElement.closest('td');
     var currentRow = currentElement.closest('tr');
     var currentCellIndex = Array.from(currentRow.children).indexOf(currentCell);
     
     var nextCell = currentCell.nextElementSibling;
     if (nextCell) {
         var nextInput = nextCell.querySelector('input[type="number"]');
         if (nextInput && nextInput.getAttribute('id') !== 'nota_extra') { // Ignorar la pregunta extra
             nextInput.removeAttribute('disabled');
             var botonGuardar = nextInput.nextElementSibling;
             if (botonGuardar && botonGuardar.tagName.toLowerCase() === 'button') {
                 botonGuardar.removeAttribute('disabled');
             }
         }
     } else {
         // Si no hay más columnas, intentar con la siguiente fila en la primera columna
         var nextRow = currentRow.nextElementSibling;
         if (nextRow) {
             var firstCellInNextRow = nextRow.children[1]; // Saltar la primera columna que es el índice
             var firstInputInNextRow = firstCellInNextRow.querySelector('input[type="number"]');
             if (firstInputInNextRow && firstInputInNextRow.getAttribute('id') !== 'nota_extra') { // Ignorar la pregunta extra
                 firstInputInNextRow.removeAttribute('disabled');
                 var botonGuardar = firstInputInNextRow.nextElementSibling;
                 if (botonGuardar && botonGuardar.tagName.toLowerCase() === 'button') {
                     botonGuardar.removeAttribute('disabled');
                 }
             }
         }
     }
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
     var extraCell = document.querySelector('.bg-warning');
     if (extraCell) {
         var botonGuardar = extraCell.querySelector('button');
         if (botonGuardar) {
             botonGuardar.style.display = 'block'; // Mostrar el botón de guardar
         }
     }
 }
 
 
 
 
 
 
 
 
 function getNextInput(currentElement) {
     var allInputs = document.querySelectorAll('input[type="number"]');
     for (var i = 0; i < allInputs.length; i++) {
         if (allInputs[i] === currentElement && i + 1 < allInputs.length) {
             return allInputs[i + 1];
         }
     }
     return null;
 }
 
 
 
 function buscar_parametros() {
     var id_candidata = document.getElementById('id_candidata').value;
  
     var fd = new FormData();
     fd.append('valor', id_candidata);
    
     $.ajax({
         type: 'POST',
         url: '../../controlador/jurado/ver_parametros.php',
         data: fd,
         cache: false,
         contentType: false,
         processData: false
     })
     .done(function(data) {
         $("#tabla_parametros_cuerpo").html(data);
     })
     .fail(function() {
         showAlert('Error al procesar información', 'danger');
     });
     return false;
 }
 
 
  
  function showAlert(message, type) {
      var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                      message +
                      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                      '</div>';
      $('#alert-container').html(alertHtml);
  
      setTimeout(function() {
          $('.alert').alert('close');
      }, 5000);
  }
  
  
 // url: 'http://172.23.25.5/clasesaplicaciones/sistema_web/controlador/notario/ver_calificaciones.php',
 
 
 function obtener_calificaciones() {
     $.ajax({
         type: 'GET', 
         url: '../../controlador/notario/ver_calificaciones.php',
         cache: false,
         contentType: 'application/json',  
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
 
 /*setInterval(obtener_calificaciones, 5000);
 
 $(document).ready(function() {
     obtener_calificaciones();
 });*/
 
 
 /* ORIGINAL:
 
 function obtener_calificaciones() {
     $.ajax({
         type: 'GET',  
         url: '../../controlador/notario/ver_calificaciones.php',
         cache: false,
         contentType: false,
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
 */
 
 
 function generarReporteGanadoras() {
     window.location.href = '../../controlador/notario/generar_reporte_ganadoras.php';
 }
 
 function descargarReporte() {
     window.location.href = '../../controlador/notario/generar_reporte.php';
 }
 
 
 
 function vcedula(cedula) {
     var fd = new FormData();
     fd.append('valor', cedula);
     $.ajax({
         type: 'POST',
         url: '../../controlador/candidata/v_cedula.php', 
         data: fd,
         cache: false,
         contentType: false,
         processData: false
     })
     .done(function(data) {
         $("#mensaje").html(data);
     })
     .fail(function() {
         alert("Error al procesar la información.");
     });
     return false;
 }
 
 
 function vcedulausu(cedula) {
    var fd = new FormData();
    fd.append('valor', cedula);
    $.ajax({
        type: 'POST',
        url: '../../controlador/v_cedula_usu.php',
        data: fd,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(data) {
        // Mostrar el mensaje solo si la cédula ya está registrada
        if (data.trim() === "Cédula ya registrada en el sistema") {
            $("#mensaje").html(data);
        } else {
            // Limpiar el mensaje si la cédula es válida
            $("#mensaje").html("");
        }
    })
    .fail(function() {
        alert("Error al procesar la información.");
    });
    return false;
}


 
 
 function esEntero(numero) {
     return Number.isInteger(Number(numero));
 }
 
 function guardar_nota(id_parametro, id_candidata) {
     var notaElement = document.getElementById('nota_' + id_parametro);
     var nota = notaElement ? notaElement.value : '';
 
     if (nota === "" || nota < parseInt(notaElement.min) || nota > parseInt(notaElement.max)) {
         showAlert("Por favor, ingrese una nota válida entre " + notaElement.min + " y " + notaElement.max, 'danger');
         return;
     }
     
     if (!esEntero(nota)) {
         showAlert("Por favor, ingrese un número entero. No se permiten números decimales.", 'danger');
         return;
     }
 
     var fd = new FormData();
     fd.append('id_parametro', id_parametro);
     fd.append('id_candidata', id_candidata);
     fd.append('nota', nota);
 
     $.ajax({
         type: 'POST',
         url: '../../controlador/jurado/guardar_notas.php',
         data: fd,
         cache: false,
         contentType: false,
         processData: false,
         success: function(response) {
             if (response.success) {
                 showAlert(response.message, 'success');
                 // Bloquear el campo y eliminar el botón
                 notaElement.setAttribute('disabled', 'disabled');
                 var botonGuardar = document.getElementById('btn_guardar_' + id_parametro);
                 if (botonGuardar) {
                     botonGuardar.remove();
                 }
                 // Habilitar el siguiente campo sin necesidad de actualizar
                 habilitarSiguienteCampo(notaElement);
             } else {
                 showAlert(response.message, 'danger');
             }
         },
         error: function() {
             showAlert("Error al guardar la nota", 'danger');
         }
     });
 }
 
 function showAlert(message, type) {
     var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                     message +
                     '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                     '</div>';
     $('#alert-container').html(alertHtml);
 
     setTimeout(function() {
         $('.alert').alert('close');
     }, 5000);
 }


 /////// notario.php

 