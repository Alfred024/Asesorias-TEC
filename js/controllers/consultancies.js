var ventFrame = '';

async function consultancies(action, id) {

    switch (action) {
        case 'formNew':
            custom_dialog(
                'Registro de una nueva asesoría', 
                `url: ../classes/class_consultancies.php?action=${action}&clave=${id}`
        );
        break;
        case 'select_signatures_consultancies':
            post_req(
                `../classes/class_consultancies.php?clave=${id}`, 
                {action: "displayData_signature"}, 
                function(htmlResponse){
                    console.log(`HTML response: ${htmlResponse}`);
                    workArea.innerHTML = htmlResponse;
                }
            );
        break;
        case 'insert_consultancie':
            errorMessage = '<p class="text-align-center font-weight-600" style="color: #c80004; font-size:15px;">Favor de llenar cada uno de los campos.</p>';

            if(descripcionId.value <= "" || temaId.value <= ""){
                message.innerHTML = errorMessage;
                return false;
            }

            formData = new FormData(document.getElementById("form_constultancie"));
            const id_student = formData.get('alumno');
            let id_consultancie_created;
            
            await $.ajax({
                url: "../classes/class_consultancies.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: async function (response) {
                    ventFrame.close();
                    id_consultancie_created = response;
                    alert_message('Asesoría registrada', 'Espere a que el alumno la confirme para verla reflejada en su pantalla.', 'blue');
                },
                error: function (error) {
                    console.log('Error:', error);
                    ventFrame.close();
                },
            });

            console.log(`CONSULTANCE CREATED: ${id_consultancie_created}`);
            
            post_req(
                "../classes/class_consultancies.php",
                {action: 'getUserEmail', id_student: id_student},
                function (emailResponse) {
                    console.log(emailResponse); 
                    post_req(
                        "../classes/class_access.php",
                        {
                            action: 'sendEmail', 
                            email: emailResponse,
                            email_html: `
                            <article
                                style="background-color: #f0efef; margin: 10px; display: flex; flex-direction:column; justify-content: center; padding: 20px; border-block: solid 4px #1B396A;">

                                <h4 style="text-align:center;">Para confirmar que asisitió a la asesoría registrada por su maestro, por favor oprima el botón.</h4><br>

                                <a href="https://tigger.celaya.tecnm.mx/AsesoriasInd/classes/class_consultancies.php?action=confirmConsultancie&id_consultancie_created=${id_consultancie_created}" style="width: 200px; padding: 10px; border-radius: 10px; margin:auto; background-color: #1B396A; color: white; border:none; cursor:pointer;">Confirmar</a>

                            </article>`,
                            email_subject: 'Confirmacion de asistencia a asesoria.'
                        },
                        function (response) {
                            console.log(response);
                        }
                    );
                }
            );
            return false; 
        case 'searchStudent': // searchStudentSignature
            student = consultanciesInput.value;
            $.ajax({
                url: `../classes/class_consultancies.php?clave=${id}&studentSearched=${student}`,
                type: "post",
                data: {action: "searchStudent"},
                success: function(htmlResponse){
                    Assesories_Container.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
        break;
        case 'sendConfirmEmail':

            break;
        default:
            alert('NO se encontró la opción');
            break;
    }
}