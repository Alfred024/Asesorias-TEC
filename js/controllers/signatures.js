var ventFrame = '';

function signatures(action, id) {
    switch (action) {
        case 'formEdit':
            console.log(`Clave de la materia: ${id}`);
            $.dialog({
                title: 'Edición de materia',
                columnClass: 'col-7',
                content: `url: http://localhost/asesorias/classes/signatures.php?action=${action}&clave=${id}`,
                onContentReady: function () {
                    ventFrame = this;
                },
            });
            break;
        case 'formNew':
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
            errorMessage = '<p class="text-align-center font-weight-600" style="color: #c80004; font-size:15px;">Favor de llenar cada uno de los campos.</p>';

            if(keyId.value <= "" || groupId.value <= "" || signatureId.value <= ""){
                message.innerHTML = errorMessage;
                setTimeout(() => {
                    message.innerHTML = "";
                }, 3000);
                return false;
            }

        case "update_signature": 
            formData = new FormData(document.getElementById("form_signature"));
            $.ajax({
                    url: "http://localhost/asesorias/classes/signatures.php",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (htmlResponse) {
                        ventFrame.close();
                        SubjectsCardsContainerId.innerHTML = '';
                
                        setTimeout(() => {
                            SubjectsCardsContainerId.innerHTML = htmlResponse;
                        }, 1000);
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
                                'success': function (htmlResponse) {
                                    SubjectsCardsContainerId.innerHTML = htmlResponse;
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