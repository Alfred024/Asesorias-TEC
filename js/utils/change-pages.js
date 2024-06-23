var selected_AnchorClass = 'AsideBar-Anchor-Selected';

function quitAsideBar_selected() {
    document.querySelectorAll('.AsideBar-Anchor').forEach(a => a.classList.remove('AsideBar-Anchor-Selected'));
}

function load_page(page_name) {
    post_req(
        `../classes/class_${page_name}.php`, 
        {action: 'display_page'},
        function (htmlResponse) {
            console.log(`${page_name} class response: ${htmlResponse}`);
            workArea.innerHTML = htmlResponse;
        }
    );
    
    quitAsideBar_selected();
    switch (page_name) {
        case 'settings':
            SettingsId.classList.add(selected_AnchorClass);
            break;
        case 'signatures':
            SignaturesStoredId.classList.add(selected_AnchorClass);
            break;
        case 'excel':
            ExcelId.classList.add(selected_AnchorClass);
            break;
        default:
            break;
    }
}

// CÓDIGO PARA MOSTRAR EN EL INPUT EL NOMBRE DEL ARCHIVO SELECCIONADO
// document.querySelector('.custom-file-label').addEventListener('click', function() {
//     document.querySelector('#customFile').click();
// });
// document.querySelector('#customFile').addEventListener('change', function() {
//     const fileName = this.files[0] ? this.files[0].name : 'Seleccione un archivo';
//     document.querySelector('.custom-file-label').textContent = fileName;
//     document.querySelector('.custom-file-label').insertAdjacentHTML('afterbegin', '<i class="fas fa-upload"></i> ');
// });