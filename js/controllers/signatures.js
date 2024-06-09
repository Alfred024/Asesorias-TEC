var ventFrame = '';

function signatures(action, id) {
    switch (action) {
        case 'formNew':
            console.log('PETICIÓN PARA INSERTAR UNA NUEVA MATERIA');
            $.dialog({
                title: 'Registro de una nueva materia',
                columnClass: 'col-7',
                content: `url: http://localhost/asesorias/classes/signatures.php?action=${action}`,
                // content: `url: ../../classes/signatures.php?action=${action}`,
                onContentReady: function () {
                    ventFrame = this;
                },
            });
            break;
        case 'insert_signature':
            formData = new FormData(document.getElementById("form_signature"));
            console.log("Enviando datos del formulario:", formData);
            $.ajax({
                url: "http://localhost/asesorias/classes/signatures.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (htmlResponse) {
                    console.log('Petición para insert de materia EXITOSA');
                    console.log('Respuesta del servidor:', htmlResponse);
                    ventFrame.close();
                    // workArea.innerHTML = htmlResponse; // Si necesitas actualizar la página
                },
                error: function (xhr, status, error) {
                    console.log('Petición para insert de materia salió mal');
                    console.log('Estado:', status);
                    console.log('Error:', error);
                    console.log('Respuesta completa:', xhr.responseText);
                    ventFrame.close();
                },
            });
            return false;
        case 'delete':
            $.confirm({
                'title': '',
                'type': 'red',
                'content': `¿Seguro que deseas borrar la materia ${id}? Se borrarán también las asesorías registradas de la materia`,
                'buttons': {
                    'confirm': {
                        'text': 'Borrar',
                        'action': function () {
                            $.ajax({
                                'url': 'http://localhost/asesorias/classes/signatures.php',
                                'type': 'post',
                                'data': { 'action': action, signature_Id: id },
                                'success': function () {
                                    $.confirm({
                                        title: '¡Éxito!',
                                        content: 'Materia borrada exitosamente',
                                        type: 'green',
                                        buttons: {
                                            ok: {
                                                text: 'OK',
                                                btnClass: 'btn-green',
                                            }
                                        }
                                    });
                                    return true;
                                },
                                'error': function () {
                                    console.log('NO SE PUDO BORRAR LA MATERIA');
                                }
                            });
                        }
                    },
                    'delete': {
                        'text': 'Cancelar',
                    }
                }
            });
            break;
        default:
            break;
    }
}