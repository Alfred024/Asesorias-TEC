var selected_AnchorClass = 'AsideBar-Anchor-Selected';

function quitAsideBar_selected() {
    document.querySelectorAll('.AsideBar-Anchor').forEach(a => a.classList.remove('AsideBar-Anchor-Selected'));
}

function show_HomePage() {
    
}
function show_UploadCSVPage() {
    workArea.innerHTML = `
        <div class="flex-column center-flex-xy height-100">

            <div class="bg-white box-shadow-light border-radius-10 padding-20">
                <h3 class="margin-bottom-10">Subir Archivo</h3>
                <!-- <form method="post" action='../../classes/class_office.php' class="flex-column justify-center margin-top-10"> -->

                <form method="post" action='http://localhost/asesorias/classes/class_office.php' enctype="multipart/form-data" class="flex-column justify-center margin-top-10">
                    <div class="form-group">
                        <label for="customFile" class="FileUpload-Label custom-file-label" style="display: flex; border: solid black 1px; padding: 10px;">
                            <i class="fas fa-upload margin-right-10"></i> Seleccione un archivo
                        </label>
                        <input class="display-none" type="file" name="students_excel_file" id="customFile">
                    </div>
                    <button type="submit" name="submit_file" class="Btn-Primary-Blue border-radius-10 bg-primary-blue text-white padding-10 margin-top-10 border-none margin-auto">Procesar archivo seleccionado</button>
                    <input type="hidden" name="action" value="registerStudent">
                </form>
            </div>

            <div class="padding-10">
                <p class="text-align-center">Para cargar la lista de sus alumnos, por favor, seleccione una hoja de excel y haga clic en "Subir". Asegúrese de que el archivo cumple con los requisitos especificados por el administrador.</p>
            </div>
        </div>`;

        quitAsideBar_selected();
        RegisterStudentsId.classList.add('AsideBar-Anchor-Selected');

        // document.querySelector('.custom-file-label').addEventListener('click', function() {
        //     document.querySelector('#customFile').click();
        // });
        // document.querySelector('#customFile').addEventListener('change', function() {
        //     const fileName = this.files[0] ? this.files[0].name : 'Seleccione un archivo';
        //     document.querySelector('.custom-file-label').textContent = fileName;
        //     document.querySelector('.custom-file-label').insertAdjacentHTML('afterbegin', '<i class="fas fa-upload"></i> ');
        // });
}

function show_SignaturesStored() {
    workArea.innerHTML = `
        <div class="grid-container gap-20">
            <p>OLA</p>
            <p>OLA</p>
            <p>OLA</p>
            <p>OLA</p>
            <p>OLA</p>
        </div>
    `;

    quitAsideBar_selected();
    SignaturesStoredId.classList.add(selected_AnchorClass);
}

function show_Settings() {
    workArea.innerHTML = `
        <div class="bg-white margin-auto padding-20 bg-white border-radius-10 box-shadow-light" style="max-width: 600px;">
            <h2 class="color-primary-blue text-align-center margin-bottom-10">Configuración del Perfil</h2>

            <!-- Editar Foto de Perfil -->
            <div class="margin-bottom-10">
                <div class="flex-column justify-center align-center gap-10">
                    <img class="profile-pic-img" src="default-profile.png" alt="Foto de Perfil" id="profile-pic">
                    <input class="display-none" type="file" id="upload-profile-pic" accept="image/*">
                    <button class="bg-primary-blue text-white border-none padding-10 border-radius-10 cursor-pointer" onclick="uploadProfilePic()">Subir Nueva Foto</button>
                </div>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="margin-bottom-10">
                <h3 class="margin-bottom-10 color-primary-blue">Cambiar Contraseña</h3>
                <div class="flex-column justify-center">

                    <input class="input-white-border border-radius-5 width-100 padding-10 margin-bottom-10" type="password" placeholder="Contraseña Actual">
                    <input class="input-white-border border-radius-5 width-100 padding-10 margin-bottom-10" type="password" placeholder="Nueva Contraseña">
                    <input class="input-white-border border-radius-5 width-100 padding-10 margin-bottom-10" type="password" placeholder="Confirmar Nueva Contraseña">

                    <button class="bg-primary-blue margin-auto margin-top-10 width-80 text-white border-none padding-10 border-radius-10 cursor-pointer">Confirmar</button>
                </div>
            </div>

        </div>
    `;

    quitAsideBar_selected();
    SettingsId.classList.add(selected_AnchorClass);
}