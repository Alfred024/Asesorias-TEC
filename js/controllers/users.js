var dictionary = "abcdefghijklmnopqrstuvwxyz";
var tecDomain = "@itcelaya.edu.mx";

function users(action, id) {

    switch (action) {
        case 'searchTeacher': 
            teacher = searchTeacherInput.value;
            $.ajax({
                url: `http://localhost/asesorias/classes/class_teachers.php?teacherSearched=${teacher}`,
                // url: `../../classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "searchTeacher"},
                success: function(htmlResponse){
                    console.log(`HTML response users: ${htmlResponse}`);
                    Teachers_Containers.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
        break;
        case 'validateEmail':
            errorMessage = '<p class="text-align-center font-weight-600" style="color: #c80004; font-size:12px;">El dominio del correo es incorrecto, favor de comprobarlo.</p>';
            const email = emailId.value;
            indexChar = 0;

            console.log(`Email: ${email}`);
            while ( indexChar < email.length && email[indexChar] !== "." ) {
                if(!dictionary.includes(email[indexChar])){
                    console.log('Dictionary no incluye: '+email[indexChar]);
                    message.innerHTML = errorMessage;
                    return false;
                }indexChar++;
                console.log('Validación antes del .');
                console.log(email[indexChar]);
            }
            indexChar++;
            while ( indexChar < email.length && email[indexChar] !== "@" ) {
                if(!dictionary.includes(email[indexChar])){
                    message.innerHTML = errorMessage;
                    return false;
                }indexChar++;
                console.log('Validación antes del @');
                console.log(email[indexChar]);
            }
            emailDomain = email.slice(indexChar, email.lenght);
            console.log(emailDomain);
            if(emailDomain !== tecDomain ){
                message.innerHTML = errorMessage;   
                return false;
            }

        return true;
        default:
            alert('NO se encontró la opción');
            break;
    }
}