<?php

// include('dbconfig.php');
if (!isset($_SESSION)) session_start();
if (!class_exists("Class_Database")) include "../classes/class_database.php";

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends Class_Database
{

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


$excel = new Excel();
if ($_REQUEST['action'] === 'registerStudent') {
    $excel->registerStudents();
}
