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
            $.ajax({
                url: `http://localhost/asesorias/classes/consultancies.php?clave=${id}`,
                type: "post",
                data: {action: "displayData_signature"},
                success: function(htmlResponse){
                    console.log('Petición para mostrar las asesorías de una materia.');
                    
                    workArea.innerHTML = `
                    <div class="flex-column height-90 padding-20 relative" style="padding-top: 10px;">
                        <div class="Assesories-Interacitve-Container flex justify-between margin-bottom-10">
                            <div class="Filters-Items-Container flex align-center margin-bottom-10">
                                <div class="Teacher-Name-Filter height-fit align-center overflow-hidden flex box-shadow-light border-radius-10 padding-5 bg-white">
                                    <i class="fa-solid fa-magnifying-glass margin-right-5 color-primary-blue"></i>
                                    <input class="border-none" type="text" placeholder="Buscar asesoría por nombre">
                                </div>

                                <div class="Form-Date-Filter height-fit flex align-center bg-white border-radius-10 overflow-hidden" style="margin-left: 10px;">
                                    <label class="font-size-10" for="input-date"><strong>Filtrar asesoría por fecha</strong></label>
                                    <input class="padding-5 height-100 bg-light-gray border-none" type="date" id="input-date" name="input-date-start" value="2024-05-19">
                                </div>
                            </div>

                            <button
                                onclick="return consultancies(\'formNew\', '${id}')" 
                                class="Btn-Primary-Blue bg-primary-blue text-white padding-10 border-none">
                                Registrar nueva asesoría
                                <i class="fa-solid fa-address-card margin-left-5"></i>
                            </button>
                        </div>

                        <!-- <div class="margin-auto" style="width: 100%; height: 70%;  overflow: scroll;"> -->
                        <div class="margin-auto width-100" style="height: 70%;  overflow-y: scroll;">
                    </div>
                    `;
                    workArea.innerHTML += htmlResponse;
                    
                    workArea.innerHTML += `
                    </div>
                        <a 
                        class="Btn-Primary-Blue absolute right-0 bg-primary-blue text-white border-radius-10 padding-10 border-none" style="bottom: 40px;"
                        target="_blank"  href="http://localhost/asesorias/classes/pdfs.php?id=${id}" >
                            Generar reporte de asesorías
                            <i class="fa-solid fa-download margin-left-5"></i>
                        </a>
                    </div>`;
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
        default:
            alert('NO se encontró la opción');
            break;
    }
}