<?php 

    // if (!isset($_SESSION)) session_start();
    if (!class_exists("Class_Database")) include "../classes/class_database.php"; 

    class Excel extends Class_Database{
        function action($action_case) {
            switch ($action_case) {
                case 'display_page':
                    $this->display_page();
                break;
                default:
                    echo ('Opción inválida');
                break;
            }
        }

        function display_page(){
            echo ('
                <div class="flex-column center-flex-xy height-100">
                    <div class="bg-white box-shadow-light border-radius-10 padding-20">
                        <h3 class="margin-bottom-10">Subir Archivo</h3>
                        <!-- <form method="post" action="../../classes/class_office.php" class="flex-column justify-center margin-top-10"> -->

                        <form method="post" action="" enctype="multipart/form-data" class="flex-column justify-center margin-top-10">
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
                </div>
            ');
        }
    }

    $excelObject = new Excel();

    if(isset($_REQUEST['action'])){
        $excelObject->action($_REQUEST['action']);
    }else{
        $excelObject->action($_REQUEST['display_page']);
    }
?>