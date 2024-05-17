function consultancies(action, id) {
    switch (action) {
        case 'select_signatures_consultancies':
            $.ajax({
                url: `../../classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "displayData_signature"},
                success: function(htmlResponse){
                    console.log('Petición para mostrar las asesorías de una materia.');
                    workArea.innerHTML = htmlResponse;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        default:
            break;
    }
}