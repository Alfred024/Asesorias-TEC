function signatures(action, id) {
    switch (action) {
        case 'formNew':
            console.log('PETICIÓN PARA INSERTAR UNA NUEVA MATERIA');
            $.ajax({
                url: "http://localhost/asesorias/classes/signatures.php",
                // url: "../../classes/signatures.php",
                type: "post",
                data: {action: "formNew"},
                success: function(htmlResponse){
                    console.log('Petición para form de registro de una nueva materia');
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        // case 'formEdit':
        //     $.dialog({
        //         title: 'Edición de la materia',
        //         columnClass: 'col-7',
        //         content: `url: http://localhost/asesorias/classes/signatures.php?action=${action}&clave_to_update=${id}`, 
        //         onContentReady: function () {
        //             ventFrame = this;
        //         },
        //     });
        //     break;
        case 'insert_signature':
            console.log('INSERTAR NEUVA MATERIA');
            $.ajax({
                url: "http://localhost/asesorias/classes/signatures.php",
                type: "post",
                data: { action: porque_esto_funciona },
                success: function(htmlResponse){
                    console.log('Petición para insert de asesoría EXITISO');
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ 
                    console.log('Petición para insert de asesoría salió mal');
                    console.log(JSON.stringify(err));
                },
            });
            return false; 
        case 'delete':
            $.confirm({
                'title': '',
                'type': 'red',
                'content': `¿Seguro que deseas borrar la materia ${id}? Se borrarán también las asesorías registradas de la materia`,
                'buttons':{
                    'confirm':{
                        'text': 'Borrar',
                        'action': function(){
                            $.ajax({
                                'url': 'http://localhost/asesorias/classes/signatures.php',
                                'type': 'post',
                                'data': {'action': action, signature_Id: id},
                                'success': function() {
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
                    'delete':{
                        'text': 'Cancelar',
                    }
                }
            });
            break;
        default:
            break;
    }
}