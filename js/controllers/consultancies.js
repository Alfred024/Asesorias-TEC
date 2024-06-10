var ventFrame = '';

function consultancies(action, id) {

    switch (action) {
        case 'formNew':
            $.dialog({
                title: 'Registro de una nueva asesoría',
                columnClass: 'col-7',
                content: `url: http://localhost/asesorias/classes/consultancies.php?action=${action}&clave=${id}`,
                // content: `url: ../../classes/signatures.php?action=${action}`,
                onContentReady: function () {
                    ventFrame = this;
                },
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
            errorMessage = '<p class="text-align-center font-weight-600" style="color: #c80004; font-size:15px;">Favor de llenar cada uno de los campos.</p>';

            if(descripcionId.value <= "" || temaId.value <= ""){
                message.innerHTML = errorMessage;
                return false;
            }

            formData = new FormData(document.getElementById("form_constultancie"));
            console.log("Enviando datos del formulario:", formData);
            $.ajax({
                url: "http://localhost/asesorias/classes/consultancies.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (htmlResponse) {
                    console.log('Petición para insert de asesoría EXITOSA');
                    console.log('Respuesta del servidor:', htmlResponse);
                    ventFrame.close();
                    // workArea.innerHTML = htmlResponse; // Si necesitas actualizar la página
                },
                error: function (xhr, status, error) {
                    console.log('Petición para insert de asesoría salió mal');
                    console.log('Estado:', status);
                    console.log('Error:', error);
                    console.log('Respuesta completa:', xhr.responseText);
                    ventFrame.close();
                },
            });
            return false; 
        case 'searchStudent': // searchStudentSignature
            student = consultanciesInput.value;
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php?clave=${id}&studentSearched=${student}`,
                //url: `../../classes/consultancies.php?clave=${id}`,
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