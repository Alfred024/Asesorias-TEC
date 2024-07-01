<?php 
    require '../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    if (!isset($_SESSION)) session_start();
    if (!class_exists("Class_Database")) include "../classes/class_database.php"; 

    class Excel extends Class_Database{
        function action($action_case) {
            switch ($action_case) {
                case 'display_page':
                    $this->display_page();
                break;
                case 'registerStudents':
                    $this->registerStudents();
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

                        <form method="post" action="../classes/class_excel.php" enctype="multipart/form-data" class="flex-column justify-center margin-top-10">
                            <div class="form-group">
                                <label for="customFile" class="FileUpload-Label custom-file-label" style="display: flex; border: solid black 1px; padding: 10px;">
                                    <i class="fas fa-upload margin-right-10"></i> Seleccione un archivo
                                </label>
                                <input class="display-none" type="file" name="students_excel_file" id="customFile">
                            </div>
                            <button type="submit" name="submit_file" class="Btn-Primary-Blue border-radius-10 bg-primary-blue text-white padding-10 margin-top-10 border-none margin-auto">Procesar archivo seleccionado</button>
                            <input type="hidden" name="action" value="registerStudents">
                        </form>
                    </div>

                    <div class="padding-20">
                        <p class="text-align-center">Para cargar la lista de sus alumnos, por favor, seleccione una hoja de excel y haga clic en "Subir". Asegúrese de que el archivo cumple con los requisitos especificados por el administrador.</p>
                    </div>
                </div>
            ');
        }

        function registerStudents(){
            if (isset($_POST['submit_file'])) {
                $fileName = $_FILES['students_excel_file']['name'];
                // echo 'Nombre del archivo: '.$fileName;
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
                // echo 'Extensión del archivo: '.$file_ext;
    
                $allowed_ext = ['xls', 'csv', 'xlsx'];
    
                if (in_array($file_ext, $allowed_ext)) {
    
                    $inputFileNamePath = $_FILES['students_excel_file']['tmp_name'];
                    echo $inputFileNamePath;
                    $spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                    $data = $spreadsheet->getActiveSheet()->toArray();
    
                    $count = "0";
                    foreach ($data as $column) {
                        if ($count > 0) {
                            $user = $column['0'];
                            $email = $column['1'];
                            $names = $column['2'];
                            $first_last_name = $column['3'];
                            $second_last_name = $column['4'];
    
                            if(!$this->isStudentRegister($user)){
                                $studentQuery =
                                    "insert into usuario (id_rol, usuario, email, nombres, apellido_paterno, apellido_materno)
                                    values (3, '{$user}', '{$email}', '{$names}', '{$first_last_name}', '{$second_last_name}');";
                                    
                                $this->query($studentQuery);
                            }
                            $msg = true;
                        } else {
                            $count = "1";
                        }
                    }
    
                    if (isset($msg)) {
                        // Importación exitosa
                        echo ('Importación exitosa');
                    } else {
                        // Importación NO exitosa
                        echo ('La importación no pudo realizarse con éxito');
                    }
                } else {
                    echo ('La extensión del archivo no es válida');
                }
            } else {
                echo ('No se cargó ningún archivo');
            }
        }
    
        function isStudentRegister($student_ctrlNum): bool{
            $query_searchStudent = 'select * from usuario where usuario = "' . $student_ctrlNum . '";';
            $this->getRecord($query_searchStudent);
    
            if ($this->registersNum == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    $excelObject = new Excel();

    if(isset($_REQUEST['action'])){
        $excelObject->action($_REQUEST['action']);
    }else{
        $excelObject->action($_REQUEST['display_page']);
    }
?>