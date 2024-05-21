function signatures(action, id) {
    switch (action) {
        case 'formNew':
            console.log('PETICIÓN PARA INSERTAR UNA NUEVA MATERIA');
            $.ajax({
                url: "http://localhost/asesorias/classes/signatures.php",
                type: "post",
                data: {action: "formNew"},
                success: function(htmlResponse){
                    console.log('Petición para form de registro de una nueva materia');
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        case 'insert_signature':
            // dónde es que la clase de php recibe la acción que hará
            // data = $('#form_user').serialize();
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
        default:
            break;
    }
}