function consultancies(action, id) {
    switch (action) {
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
                                onclick="return consultancies(\'insert_signature\')" 
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
                        <button class="Btn-Primary-Blue absolute right-0 bg-primary-blue text-white border-radius-10 padding-10 border-none" style="bottom: 40px;">
                            Descargar report
                            <i class="fa-solid fa-download margin-left-5"></i>
                        </button>
                    </div>`;
                },
                error: function(err){ console.log(JSON.stringify(err)); },
            });
            break;
        default:
            break;
    }
}