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
        default:
            alert('NO se encontró la opción');
            break;
    }
}