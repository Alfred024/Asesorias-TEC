var ventFrame = '';

function consultancies(action, id) {

    switch (action) {
        case 'formNew':
            $.dialog({
                title: 'Registro de una nueva asesoría',
                columnClass: 'col-7',
                content: `url: ../classes/class_consultancies.php?action=${action}&clave=${id}`,
                onContentReady: function () {
                    ventFrame = this;
                },
            });
        break;
        case 'select_signatures_consultancies':
            $.ajax({
                url: `../classes/class_consultancies.php?clave=${id}`,
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
            $.ajax({
                url: "../classes/class_consultancies.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (htmlResponse) {
                    ventFrame.close();
                    Assesories_Container.innerHTML = htmlResponse; // Si necesitas actualizar la página
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
                url: `../classes/class_consultancies.php?clave=${id}&studentSearched=${student}`,
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