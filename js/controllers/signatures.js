function signatures(action, id) {
    switch (action) {
        case 'formNew':
            console.log('PETICIÓN PARA INSERTAR UNA NUEVA MATERIA');
            // $.ajax({
            //     url: "../../classes/signatures.php",
            //     type: "post",
            //     data: {action: "formNew"},
            //     success: function(htmlResponse){
            //         console.log('Petición para form de registro de una nueva materia');
            //         workArea.innerHTML = htmlResponse;
            //     },
            //     error: function(err){ console.log(JSON.stringify(err)); },
            // });
            break;
        default:
            break;
    }
}