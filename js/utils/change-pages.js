var selected_AnchorClass = 'AsideBar-Anchor-Selected';

function show_HomePage() {
    
}
function show_UploadCSVPage() {
    workArea.innerHTML = `
        <div class="flex-column center-flex-xy height-100">

            <div class="bg-white box-shadow-light border-radius-10 padding-20">
                <h3 class="margin-bottom-10">Subir Archivo</h3>
                <form class="flex-column justify-center margin-top-10">
                    <div class="form-group">
                        <label for="customFile" class="FileUpload-Label custom-file-label" style="display: flex; border: solid black 1px; padding: 10px;">
                            <i class="fas fa-upload margin-right-10"></i> Seleccione un archivo
                        </label>
                        <input class="display-none" type="file" id="customFile">
                    </div>
                    <button type="submit" class="Btn-Primary-Blue border-radius-10 bg-primary-blue text-white padding-10 margin-top-10 border-none margin-auto">Procesar archivo seleccionado</button>
                </form>
            </div>

            <div class="padding-10">
                <p class="text-align-center">Para cargar la lista de sus alumnos, por favor, seleccione una hoja de excel y haga clic en "Subir". Asegúrese de que el archivo cumple con los requisitos especificados por el administrador.</p>
            </div>
        </div>`;

        document.querySelectorAll('.AsideBar-Anchor').forEach(a => a.classList.remove('AsideBar-Anchor-Selected'));

        RegisterStudentsId.classList.add('AsideBar-Anchor-Selected');

        document.querySelector('.custom-file-label').addEventListener('click', function() {
            document.querySelector('#customFile').click();
        });

        document.querySelector('#customFile').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Seleccione un archivo';
            document.querySelector('.custom-file-label').textContent = fileName;
            document.querySelector('.custom-file-label').insertAdjacentHTML('afterbegin', '<i class="fas fa-upload"></i> ');
        });
}