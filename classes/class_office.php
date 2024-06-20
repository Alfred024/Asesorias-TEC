<?php

// include('dbconfig.php');
if (!isset($_SESSION)) session_start();
if (!class_exists("Class_Database")) include "../classes/class_database.php";

// include '../resources/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php';
// include '../resources/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
// include '../resources/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Shared/File.php';
// include '../resources/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Reader/Xlsx';
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\IOFactory;

require '../vendor/autoload.php';
//require __DIR__ .  '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends Class_Database{
    
    function registerStudents(){
            if (isset($_POST['submit_file'])) {
                $fileName = $_FILES['students_excel_file']['name'];
                $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

                $allowed_ext = ['xls', 'csv', 'xlsx'];

                if (in_array($file_ext, $allowed_ext)) {
                    
                    $inputFileNamePath = $_FILES['students_excel_file']['tmp_name'];
                    echo $inputFileNamePath;
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                    $data = $spreadsheet->getActiveSheet()->toArray();

                    $count = "0";
                    foreach ($data as $row) {
                        if ($count > 0) {
                            $user = $row['0'];
                            $email = $row['1'];
                            $names = $row['2'];
                            $first_last_name = $row['3'];
                            $second_last_name = $row['4'];

                            $studentQuery = 
                            "insert into usuario (3, usuario, email, nombres, apellido_paterno, apellido_materno)
                            values (3, ".$user.", ".$email.", ".$names.", ".$first_last_name.", ".$second_last_name.");";
                            $this->query($studentQuery);
                            $msg = true;
                        } else {
                            $count = "1";
                        }
                    }

                    if (isset($msg)) {
                        // Importación exitosa
                    } else {
                        // Importación NO exitosa
                    }
                } else {
                    echo('No se cargó ningún archivo');
                }
            }
        }
    }

    $excel = new Excel();
    if($_REQUEST['action'] === 'registerStudent'){
        $excel->registerStudents();
    }

?>