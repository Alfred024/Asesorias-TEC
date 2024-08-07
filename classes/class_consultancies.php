<?php
// session_start();
if (!isset($_SESSION)) session_start();
if (!class_exists("PDFS")) include "../classes/class_pdfs.php";
if (!class_exists("Class_Database")) include "../classes/class_database.php";
if (!class_exists("Class_Access")) include "../classes/class_access.php";

class Consultancies extends Class_Database
{
    function action($action_case)
    {
        switch ($action_case) {
            case 'formNew':
                // Obtener la clave del request
                // Obtener el id_usuario del maestro de la sesión
                $clave = strval($_REQUEST['clave']);
                $students = $this->displayStudents();
                return
                    '<form 
                            id="form_constultancie"
                            onsubmit="event.preventDefault(); return consultancies(\'insert_consultancie\')" method="post"
                            class="flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
                
                            <input 
                                id="temaId"
                                class="input-1" type="text" name="tema" placeholder="Tema de la asesoría">
                            <br>
                
                            <label class="flex-column">
                                Competencia
                                <br>
                                <select class="input-1" name="competencia">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </label>
                            <br>
                
                            <textarea 
                                id="descripcionId"
                                style="height: 100px; resize: none;" class="input-1" name="descripcion" placeholder="Descripción de la asesoría"></textarea>
                            <br>
                
                            <label class="flex-column width-100 margin-auto">
                                Alumno toma la asesoría
                                <br>
                                <select class="input-1" name="alumno">
                                    ' . $students . '
                                </select>
                            </label><br>
                            
                            <input type="hidden" name="action" value="insert_consultancie">
                            <input type="hidden" name="clave" value="' . $clave . '">

                            <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-10 padding-10 border-none margin-auto" value="Registrar Asesoría" style="width: 200px;">
                            <span id="message"></span>
                        </form>';

                break;
            case 'insert_consultancie':
                $user_id_toma = $_REQUEST['alumno'];
                // $student_email = $this->getUserEmailById($user_id_toma);
                
                $tema = $_REQUEST['tema'];
                $description = $_REQUEST['descripcion'];
                $competencia = $_REQUEST['competencia'];
                $user_id = $_SESSION['session_user_id'];
                $signature_key = $_REQUEST['clave'];

                $insert_consultancie_query = '
                    insert into asesoria
                    (tema, competencia, descripcion, id_usuario_imparte, id_usuario_toma, clave)
                    values ("' . $tema . '", "' . $competencia . '", "' . $description . '", "' . $user_id . '", "' . $user_id_toma . '", "' . $signature_key . '");';

                $this->getIdOfQuery($insert_consultancie_query);
                return $this->registerId;
                break;
            case 'displayData_signature':
                // $admin =  $_SESSION['admin'];
                $signature_key = $_REQUEST['clave'];
                $query_param =
                    'SELECT
                        concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                        ase.competencia,
                        ase.tema,
                        ase.descripcion,
                        ase.fecha
                    FROM asesoria AS ase
                    JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
                    WHERE ase.clave = "' . $signature_key . '" and ase.confirmada = TRUE; ';

                echo ('
                    <div class="flex-column padding-20 relative" style="padding-top: 10px;">
                        <div class="Assesories-Interacitve-Container flex justify-between margin-bottom-10">
                            <div class="Filters-Items-Container flex align-center margin-bottom-10">
                                <div class="Teacher-Name-Filter height-fit align-center overflow-hidden flex box-shadow-light border-radius-10 padding-5 bg-white">
                                    <i class="fa-solid fa-magnifying-glass margin-right-5 color-primary-blue"></i>
                                    <input 
                                        onkeypress="return consultancies(\'searchStudent\', \'' . $signature_key . '\')" 
                                        class="border-none" type="text" 
                                        style="width: 200px;"
                                        id="consultanciesInput" placeholder="Buscar alumno por nombre...">
                                </div>

                                <!-- <div class="Form-Date-Filter height-fit flex align-center bg-white border-radius-10 overflow-hidden" style="margin-left: 10px;">
                                    <label class="font-size-10" for="input-date"><strong>Filtrar asesoría por fecha</strong></label>
                                    <input class="padding-5 height-100 bg-light-gray border-none" type="date" id="input-date" name="input-date-start" value="2024-05-19">
                                </div> -->
                            </div>

                            '.($_SESSION['admin'] ? 
                            '<button
                                onclick="return signatures(\'storeContent\', \'' . $signature_key . '\', )"
                                class="Btn-Primary-Blue bg-primary-blue text-white padding-10 border-none">
                                Archivar materia
                                <i class="fa-solid fa-database margin-left-5"></i>
                            </button>' 
                                : 
                            '<button
                                onclick="return consultancies(\'formNew\', \'' . $signature_key . '\')" 
                                class="Btn-Primary-Blue bg-primary-blue text-white padding-10 border-none">
                                Registrar nueva asesoría
                                <i class="fa-solid fa-address-card margin-left-5"></i>
                            </button>').'
                            
                        </div>

                        <div class="margin-auto width-100" style="height: 70%;  overflow-y: scroll;">
                    </div>');
                
                    $this->displayData($query_param);
                echo ('</div>
                    <a 
                        class="Btn-Primary-Blue absolute right-0 bg-primary-blue text-white border-radius-10 padding-10 border-none" style="bottom: 40px;"
                        target="_blank"  href="../classes/class_pdfs.php?id=' . $signature_key . '&table=asesoria" >
                            Generar reporte de asesorías
                            <i class="fa-solid fa-download margin-left-5"></i>
                        </a>
                    </div>');
                break;
            case 'displayData_recent':
                $user_id = $_SESSION['session_user_id'];
                
                $query_param =
                    'SELECT 
                        concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                        ase.competencia,
                        ase.tema,
                        ase.descripcion,
                        ase.fecha
                    FROM asesoria ase
                    JOIN usuario usu ON ase.id_usuario_toma = usu.id_usuario
                    WHERE ase.id_usuario_imparte = "' . $user_id . '"
                    ORDER BY 5 desc limit 8;';
                $this->displayData($query_param);
                break;
            case 'searchStudent':
                if (isset($_REQUEST['studentSearched'])) {
                    $studentSearched = $_REQUEST['studentSearched'];
                }
                $signature_key = $_REQUEST['clave'];

                $query_param =
                    'SELECT
                            concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                            ase.competencia,
                            ase.tema,
                            ase.descripcion,
                            ase.fecha
                        FROM asesoria AS ase
                        JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
                        WHERE ase.clave = "' . $signature_key . '" 
                        AND CONCAT(usu.nombres, " ", usu.apellido_paterno, " ", usu.apellido_materno, " ") 
                        LIKE CONCAT("%' . $studentSearched . '%");';
                $this->displayData($query_param);
                break;
            case 'storeContent':
                $clave = $_REQUEST['clave'];
                
                $query_tranfer_group = 
                'insert into grupo_archivado (grupo, clave, id_usuario, id_materia, id_periodo)
                select grupo, clave, id_usuario, id_materia, id_periodo from grupo where clave = "'.$clave.'";';
                $this->query($query_tranfer_group);

                $query_tranfer_consultancies = 
                'insert into asesoria_archivada (tema, competencia, descripcion, id_usuario_imparte, id_usuario_toma, clave)
                select tema, competencia, descripcion, id_usuario_imparte, id_usuario_toma, clave from asesoria
                where clave = "'.$clave.'";';
                $this->query($query_tranfer_consultancies);

                $query_delete_group = 'delete from grupo where clave = "'.$clave.'";';
                $this->query($query_delete_group);
                // echo (
                //     '<div style="width: 200px; margin-left: 20px;" class="flex margin-y-5 box-shadow-light border-radius-10 padding-10 bg-white place-self-end">
                //     <i class="fa-solid fa-magnifying-glass margin-right-5 color-primary-blue"></i>
                //     <input onkeypress="return users(\'searchTeacher\')" id="searchTeacherInput" class="border-none" type="text" placeholder="Buscar maestro">
                //     </div>');
                $_REQUEST['action'] = 'displayData';
                include './class_teachers.php';
                break;
            case 'getUserEmail':
                $user_id = $_REQUEST['id_student'];
                $this->getUserEmailById($user_id);
                break;
            case 'confirmConsultancie':
                $id_consultancie = $_REQUEST['id_consultancie_created'];
                $this->confirmConsultancie($id_consultancie);
                header('location: ../confirmation.php');
                break;
        }
    }

    function displayData($query_param){
        // $user_id=$_SESSION['session_user_id'];
        $this->getRecord($query_param);

        if ($this->registersNum == 0) {
            $current_page = $_SERVER['SCRIPT_NAME'];
            // echo $current_page;

            switch ($current_page) {
                case '/asesorias/teacher/home.php':
                    echo ('
                    <div id="Assesories_Container" class="flex-column center-flex-xy margin-top-10">
                        <h5 class="padding-20 text-align-center font-size-15 color-primary-blue">Aún no tienes asesorías registradas, haz click en la card de la materia y accede al panel para registrar una nueva asesoría.</h5>
                        <i class="fa-solid fa-box-archive fa-xl margin-auto color-primary-blue"></i>
                    </div>');
                    break;
                default:
                    echo ('
                    <div id="Assesories_Container" class="flex-column center-flex-xy margin-top-10">
                        <h5 class="padding-20 text-align-center font-size-15 color-primary-blue">Aún no tienes asesorías registradas en esta materia. Para registrar una asesoría haz click en el botón de la parte superior derecha.</h5>
                        <i class="fa-solid fa-box-archive fa-xl margin-auto color-primary-blue"></i>
                    </div>');
                    break;
            }

            return;
        }
        $tableStart = '
            <table id="Assesories_Container" class="Assesories-Table overflow-x-auto padding-10 width-90 margin-auto" style="background-color: white;">
                <thead class="Table-Header">
                    <tr class="text-secondary-blue">
                        <th>Alumno</th>
                        <th>Competencia</th>
                        <th>Tema</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>';

        $consultancies = '';
        foreach ($this->registrersBlock as $registerRow) {
            $consultancies .= '
                <tr>
                    <td>' . $registerRow["alumno"] . '</td>
                    <td>' . $registerRow["competencia"] . '</td>
                    <td>' . $registerRow["tema"] . '</td>
                    <td style="max-width: 100px;">' . $registerRow["descripcion"] . '</td>
                    <td>' . $registerRow["fecha"] . '</td>
                </tr>';
        }
        $tableEnd = '
                </tbody>
            </table>';

        echo ($tableStart . $consultancies . $tableEnd);
    }

    function displayStudents()
    {
        $this->getRecord('
            select
                us.id_usuario,
                us.email,
                concat(us.nombres, " ",us.apellido_paterno, " ",us.apellido_materno) as alumno
            from usuario us
            where us.id_rol = 3;');

        $students = '';
        foreach ($this->registrersBlock as $registerRow) {
            $students .= '
                <option value="' . $registerRow['id_usuario'] . '">' . $registerRow['alumno'] . '</option>';
        }
        return $students;
    }

    function getUserEmailById($user_id){
        $query_param = 'select email from usuario where id_usuario = '.$user_id.'';
        $res = $this->getRecord($query_param);
        echo $res->email;
    }

    function confirmConsultancie($id_consultancie){
        $update_concultancie = 'update asesoria set confirmada = TRUE where id_asesoria = "'.$id_consultancie.'"';
        $this->query($update_concultancie);
    }
}


// $databaseConsultancies = new Class_Database();
// $consultanciesObject = new Consultancies($databaseConsultancies);
$consultanciesObject = new Consultancies();
if (isset($_REQUEST['action'])) {
    echo $consultanciesObject->action($_REQUEST['action']);
} else {
    $current_page = $_SERVER['SCRIPT_NAME'];
    // echo $current_page;

    switch ($current_page) {
        case '/asesorias/teacher/home.php':
            echo $consultanciesObject->action('displayData_recent');
            break;
        default:
            break;
    }
}
