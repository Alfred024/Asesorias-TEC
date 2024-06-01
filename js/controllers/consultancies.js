function consultancies(action, id) {

    switch (action) {
        case 'formNew':
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php?clave=${id}`,
                // url: `../../classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "formNew"},
                success: function(htmlResponse){
                    console.log('Petición para form de registro de una nueva asesoría succes');
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        case 'select_signatures_consultancies':
            console.log('MUESTRA LAS ASESOS´RIAS DE LA MATERIA 5: '+id);
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php?clave=${id}`,
                // url: `../../classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "displayData_signature"},
                success: function(htmlResponse){
                    console.log(`HTML response: ${htmlResponse}`);
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        case 'insert_consultancie':
            // data = $('#form_user').serialize();
            // console.log(`CLAVE: ${id}`);
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php`,
                type: "post",
                data: { action: porque_esto_funciona, clave: porque_esto_funciona2 },
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
        case 'searchStudent':
            student = consultanciesInput.value;
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php?clave=${id}&studentSearched=${student}`,
                // url: `../../classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "searchStudent"},
                success: function(htmlResponse){
                    console.log(`HTML response: ${htmlResponse}`);
                    Assesories_Table.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
        break;
        default:
            alert('NO se encontró la opción');
            break;
    }
}