var dictionary = "abcdefghijklmnopqrstuvwxyz";
var tecDomain = "@itcelaya.edu.mx";

function users(action, id) {

    switch (action) {
        case 'searchTeacher': 
            teacher = searchTeacherInput.value;
            $.ajax({
                url: `../classes/class_teachers.php?teacherSearched=${teacher}`,
                type: "post",
                data: {action: "searchTeacher"},
                success: function(htmlResponse){
                    Teachers_Container.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
        break;
        case 'validateEmail':
            errorMessage = '<p class="text-align-center font-weight-600" style="color: #c80004; font-size:12px;">El dominio del correo es incorrecto, favor de comprobarlo.</p>';
            const email = emailId.value;
            indexChar = 0;

            // while ( indexChar < email.length && email[indexChar] !== "." ) {
            //     if(!dictionary.includes(email[indexChar])){
            //         message.innerHTML = errorMessage;
            //         clearMessage(message);
            //         return false;
            //     }indexChar++;
            // }
            // indexChar++;
            // while ( indexChar < email.length && email[indexChar] !== "@" ) {
            //     if(!dictionary.includes(email[indexChar])){
            //         message.innerHTML = errorMessage;
            //         clearMessage(message);
            //         return false;
            //     }indexChar++;
            // }
            // emailDomain = email.slice(indexChar, email.lenght);
            // console.log(emailDomain);
            // if(emailDomain !== tecDomain ){
            //     message.innerHTML = errorMessage;  
            //     clearMessage(message); 
            //     return false;
            // }

        return true;
        default:
            alert('NO se encontró la opción');
            break;
    }
}

function clearMessage(message) {
    setTimeout(() => {
        message.innerHTML = "";
    }, 3000);
}